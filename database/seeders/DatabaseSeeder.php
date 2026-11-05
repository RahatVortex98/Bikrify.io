<?php
namespace Database\Seeders;
use App\Models\{Service,User};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder {
 public function run(): void {
  $steps=[['Discover','A short call and a demo with your own products.'],['Build','We set up your system in weekly, testable steps.'],['Train','Your team learns it with quick guides and a trial run.'],['Support','Updates, backups, and fixes after launch.']];
  $s=[
   ['online-store-order-system','Online Store & Order System','Turn your page into a shop that tracks every order.','Your own store with COD checkout, one order dashboard, and courier booking, built for Bangladeshi sellers.',
    ['Orders lost in Messenger chats','Fake orders and repeat returns','Parcel details typed by hand','No clear daily sales picture'],
    ['Every order in one dashboard','Confirmation and risk flags before shipping','Courier booking from one screen','A daily report to your inbox'],
    [['Store with COD checkout','Mobile-friendly, with your brand and domain.'],['Order dashboard','New, shipped, delivered, and returned at a glance.'],['Courier integration','Steadfast, Pathao, and RedX connected.'],['Risky customer flags','Spot repeat returners before you ship.']],
    [['How long does setup take?','It depends on scope. We confirm a timeline after your demo.'],['What does it cost?','We give a fixed quote after a short discovery call.'],['Can I start small?','Yes. Start with the store and orders, add more later.']]],
   ['pos-inventory-system','POS & Inventory','Fast billing. Stock you can trust.','Counter billing, stock, and branch pricing in one system that closes the day without manual rework.',
    ['Stock counts that never match','Returns that do not restore stock','Prices that differ between branches','Day-end totals rebuilt by hand'],
    ['Live stock across counters and branches','Returns that restore inventory correctly','One price list with branch overrides','Day-end reports that add up'],
    [['Counter billing','Fast checkout with receipts and mixed payments.'],['Stock and transfers','Adjustments, transfers, and low-stock alerts.'],['Branch price lists','Central control with local overrides.'],['Day-end reconciliation','Totals by payment type and cashier.']],
    [['Does it work offline?','We scope offline needs per shop during discovery.'],['Which hardware works?','Common receipt printers and barcode scanners. We confirm against your list.'],['Can it grow into ERP?','Yes. Modules connect as your business grows.']]],
   ['custom-erp-automation','Custom ERP & Automation','One system for orders, stock, accounts, and approvals.','Software built around how your company works, with automation that handles repeat work.',
    ['Data scattered across Excel and chats','Approvals stuck in messages','Reports rebuilt every month','Staff doing the same task twice'],
    ['One source of truth for the company','Approval flows with clear owners','Reports generated automatically','Alerts and tasks that run themselves'],
    [['Accounts and billing','Invoices, payments, and ledgers.'],['HR and attendance','Staff records, attendance, and leave.'],['Procurement and approvals','Requests to purchase with sign-off.'],['Reports and alerts','Scheduled reports and exception alerts.']],
    [['Is ERP only for big companies?','No. Start with one module and add more later.'],['Do you build custom features?','Yes. That is the point of a custom ERP.'],['Who supports it after launch?','We do, with updates, backups, and fixes.']]],
  ];
  foreach($s as $i=>$r) Service::updateOrCreate(['slug'=>$r[0]],['title'=>$r[1],'tagline'=>$r[2],'intro'=>$r[3],'sort'=>$i,
   'data'=>['problems'=>$r[4],'solutions'=>$r[5],'caps'=>$r[6],'faq'=>$r[7],'steps'=>$steps]]);
  $pw=env('ADMIN_PASSWORD') ?: Str::random(14);
  $admin=User::firstOrCreate(['email'=>config('bikrify.admin_email')],['name'=>'Admin','password'=>Hash::make($pw)]);
  if ($admin->wasRecentlyCreated) {
   $this->command->info("Admin login: ".config('bikrify.admin_email')." / $pw");
  } else {
   $this->command->info('Admin account already exists; its password was not changed.');
  }
 }
}
