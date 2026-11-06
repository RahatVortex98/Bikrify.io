<?php
namespace App\Http\Controllers;
use App\Models\{Customer,Payment,Prospect,Subscriber};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class CrmController extends Controller {
 const STAGES=['new'=>'New list','no_response'=>'No response','interested'=>'Interested','hot'=>'Hot (almost agreed)'];
 public function prospects(Request $r){
  $s=$r->get('stage','new'); abort_unless(isset(self::STAGES[$s]),404);
  return view('admin.prospects',['stage'=>$s,'stages'=>self::STAGES,'counts'=>Prospect::selectRaw('stage, count(*) c')->groupBy('stage')->pluck('c','stage'),'rows'=>Prospect::where('stage',$s)->latest()->paginate(50)->withQueryString()]);
 }
 public function import(Request $r){
  $r->validate(['file'=>'required|file|mimes:xlsx,xls,csv|max:20480']);
  try {
   $type=match(strtolower($r->file('file')->getClientOriginalExtension())) { 'xlsx'=>'Xlsx', 'xls'=>'Xls', default=>'Csv' };
   $rows=\PhpOffice\PhpSpreadsheet\IOFactory::createReader($type)->load($r->file('file')->getRealPath())->getActiveSheet()->toArray(null,true,true,false);
  } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
   return back()->withErrors(['file'=>'This spreadsheet could not be read. Please upload a valid Excel or CSV file.']);
  }
  $header=array_shift($rows);
  if (!$header) return back()->withErrors(['file'=>'The spreadsheet is empty or has no header row.'])->withInput();
  $headers=array_map(fn($x)=>strtolower(trim(str_replace(['_','-'],' ',(string)$x))),$header);
  $find=fn($pattern)=>collect($headers)->search(fn($x)=>preg_match($pattern,$x));
  $nameColumn=collect($headers)->search(fn($x)=>preg_match('/\b(page|business|company|shop|store|lead|prospect|customer|brand|organization|organisation|name|title)\b/',$x)&&!preg_match('/link|url|facebook|instagram|website|profile/',$x));
  $linkColumn=$find('/link|url|facebook|instagram|website|profile/');
  $followersColumn=$find('/follow|audience|likes|fans/');
  $phoneColumn=$find('/phone|whats|contact|mobile|telephone|tel\b/');
  $firstRowLooksLikeData=collect($header)->contains(function($value){
   $value=trim((string)$value);
   return $value!==''&&(preg_match('/https?:\/\/|www\./i',$value)||preg_match('/^\+?[\d\s().-]{7,}$/',$value));
  });
  if ($firstRowLooksLikeData) {
   $rows=array_merge([$header],$rows);
   $headers=array_map(fn($index)=>'column '.($index+1),array_keys($header));
   $nameColumn=$linkColumn=$followersColumn=$phoneColumn=false;
  }
  $get=fn($index,$row)=>$index===false?'':trim((string)($row[$index]??''));
  $new=0; $updated=0; $skipped=0;
  foreach($rows as $rowIndex=>$row){
   $values=array_map(fn($value)=>trim((string)$value),$row);
   if (!collect($values)->contains(fn($value)=>$value!=='')) { $skipped++; continue; }
   $phoneValue=$get($phoneColumn,$row);
   if ($phoneValue===''||!preg_match('/\d{7,15}/',preg_replace('/\D/','',$phoneValue))) {
    $phoneCandidates=collect($values)->filter(fn($value,$index)=>$index!==$followersColumn&&preg_match('/^\+?[\d\s().-]{7,}$/',$value));
    $phoneValue=$phoneCandidates->first(fn($value)=>preg_match('/^\s*(?:\+|0)[\d\s().-]{6,}$/',$value))??$phoneCandidates->last()??'';
   }
   $phone=$phoneValue!==''?substr(preg_replace('/\D/','',$phoneValue),-11):'';
   $followers=$get($followersColumn,$row);
   if ($followers==='') $followers=collect($values)->first(fn($value)=>$value!==$phoneValue&&preg_match('/^\s*[\d,.]+\s*[km]?\s*$/i',$value))??'';
   $link=$get($linkColumn,$row);
   if ($link==='') $link=collect($values)->first(fn($value)=>preg_match('/https?:\/\/|www\./i',$value))??'';
   $name=$get($nameColumn,$row);
   if ($name==='') {
    $name=collect($values)->first(fn($value)=>$value!==''&&$value!==$phoneValue&&$value!==$followers&&!preg_match('/^\+?[\d\s().-]{7,}$/',$value)&&!preg_match('/https?:\/\/|www\./i',$value))??'';
   }
   if ($name===''&&$phone==='') $name=$link;
   if ($name==='') $name='Lead '.($rowIndex+1);
   $f=strtolower(str_replace(',','',$followers)); $count=(float)$f;
   if(str_contains($f,'k')) $count*=1000;
   if(str_contains($f,'m')) $count*=1000000;
   $prospect=Prospect::updateOrCreate(
    ['page_name'=>$name,'phone'=>$phone?:null],
    ['fb_link'=>$link?:null,'followers'=>$count?(int)$count:null]
   );
   if ($prospect->wasRecentlyCreated) $new++;
   else $updated++;
  }
  return back()->with('ok',"Import complete: $new new leads, $updated updated, $skipped blank rows skipped.");
 }
 public function stage(Request $r,Prospect $prospect){
  $d=$r->validate(['stage'=>'required|in:new,no_response,interested,hot','note'=>'nullable|max:1000']);
  $prospect->update($d+['last_contact_at'=>now()]); return back();
 }
 public function create(Request $r){ return view('admin.customer-new',['p'=>Prospect::find($r->prospect)]); }
 public function store(Request $r){
  $m=fn($f)=>'required_if:plan,monthly|'.$f;
  $d=$r->validate(['prospect_id'=>'nullable|integer|exists:prospects,id','name'=>'required|string|max:120','phone'=>'required|string|max:20','site_url'=>'nullable|url:http,https|max:255','plan'=>'required|in:purchase,monthly',
   'price'=>'required_if:plan,purchase|nullable|integer|min:0','monthly_fee'=>$m('nullable|integer|min:1'),'nid'=>$m('nullable|digits_between:10,17'),
   'photo'=>$m('nullable|image|max:3072'),'pay_method'=>$m('nullable|max:40'),'pay_account'=>$m('nullable|max:60'),'paid_until'=>$m('nullable|date')]);
  if($r->hasFile('photo')) $d['photo']=$r->file('photo')->store('customer-photos','local');
  $c=Customer::create($d);
  if($c->prospect_id) Prospect::whereKey($c->prospect_id)->update(['stage'=>'won']);
  return redirect('/admin/customers')->with('ok',"Customer added. License key: {$c->license_key}");
 }
 public function customers(){ return view('admin.customers',['rows'=>Customer::with('payments')->latest()->get()]); }
 public function pay(Request $r,Customer $customer){
  $r->merge(['amount'=>$r->filled('amount')?$r->input('amount'):($customer->monthly_fee?:$customer->price)]);
  $d=$r->validate(['amount'=>'required|integer|min:1|max:4294967295']);
  DB::transaction(function() use($customer,$d){
   $customer=Customer::whereKey($customer->id)->lockForUpdate()->firstOrFail();
   Payment::create(['customer_id'=>$customer->id,'amount'=>$d['amount'],'paid_on'=>today()]);
   $u=['status'=>'active']; if($customer->plan==='monthly') $u['paid_until']=max($customer->paid_until??today(),today())->copy()->addMonthNoOverflow();
   $customer->update($u);
  });
  return back()->with('ok','Payment recorded. Site is active.');
 }
 public function toggle(Customer $customer){ $customer->update(['status'=>$customer->status==='active'?'suspended':'active']); return back(); }
 public function photo(Customer $customer){ abort_unless($customer->photo && Storage::disk('local')->exists($customer->photo),404); return response()->file(Storage::disk('local')->path($customer->photo)); }
 public function license(string $key){ $c=Customer::where('license_key',$key)->first(); return response()->json(['status'=>$c?->status??'unknown']); }
 public function subscribe(Request $r){ Subscriber::firstOrCreate($r->validate(['email'=>'required|email'])); return back()->with('sub','Thanks for subscribing!'); }
}
