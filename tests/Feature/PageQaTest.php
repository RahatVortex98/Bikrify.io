<?php

namespace Tests\Feature;

use App\Jobs\ProcessLead;
use App\Models\{Customer, HomeBuildItem, Post, Prospect, Service, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\{Queue, Storage};
use Tests\TestCase;

class PageQaTest extends TestCase
{
    use RefreshDatabase;

    public function test_every_page_template_renders_with_records_and_guest_access_is_protected(): void
    {
        $this->seed();
        $post = Post::create(['title'=>'QA article', 'slug'=>'qa-article', 'excerpt'=>'A useful guide.', 'meta_description'=>'A useful guide.', 'body'=>str_repeat('Practical business guidance. ',10), 'published_at'=>now()->subHour()]);
        $draft = Post::create(['title'=>'Draft', 'slug'=>'qa-draft', 'excerpt'=>'Private draft.', 'meta_description'=>'Private draft.', 'body'=>str_repeat('Draft content. ',10)]);
        $prospect = Prospect::create(['page_name'=>'QA shop', 'phone'=>'01700000000']);
        Storage::fake('local');
        Storage::disk('local')->put('customer-photos/qa.txt', 'QA photo fixture');
        $customer = Customer::create(['name'=>'QA customer', 'phone'=>'01700000000', 'plan'=>'monthly', 'monthly_fee'=>1000, 'paid_until'=>today(), 'nid'=>'1234567890', 'photo'=>'customer-photos/qa.txt']);
        Customer::create(['name'=>'Purchase customer', 'phone'=>'01700000001', 'plan'=>'purchase', 'price'=>5000]);
        foreach (['/e-commerce-software-company-bangladesh','/blog','/blog/'.$post->slug,'/case-studies','/security','/status','/policies','/sitemap.xml','/up','/admin/login'] as $path) {
            $this->get($path)->assertOk();
        }
        foreach (Service::all() as $service) $this->get('/services/'.$service->slug)->assertOk()->assertSee($service->title);
        foreach (['/blog/'.$draft->slug,'/blog/no-such-post','/services/no-such-service'] as $path) $this->get($path)->assertNotFound();
        $this->get('/')->assertRedirect('/e-commerce-software-company-bangladesh');
        $this->get('/services/online-store-order-system')->assertRedirect('/services/order-management-system-for-facebook-sellers');
        $this->get('/admin/customers/'.$customer->id.'/photo')->assertRedirect('/admin/login');
        $this->actingAs(User::where('is_admin',true)->firstOrFail());
        foreach ([
            '/admin/leads','/admin/prospects','/admin/prospects?stage=no_response','/admin/prospects?stage=interested','/admin/prospects?stage=hot',
            '/admin/customers','/admin/customers/new','/admin/customers/new?prospect='.$prospect->id,'/admin/customers/'.$customer->id.'/photo',
            '/admin/blog/posts','/admin/blog/posts/create','/admin/blog/posts/'.$post->id.'/edit','/admin/blog/posts/'.$draft->id.'/edit',
            '/admin/homepage/what-we-build','/admin/homepage/what-we-build/create','/admin/homepage/what-we-build/'.HomeBuildItem::firstOrFail()->id.'/edit',
            '/admin/users','/admin/users/create','/admin/users/'.auth()->id().'/edit',
        ] as $path) $this->get($path)->assertOk();
        $this->get('/admin/prospects?stage=invalid')->assertNotFound();
        $this->get('/admin/customers/99999/photo')->assertNotFound();
    }

    public function test_public_forms_validate_and_save_without_sending_real_mail(): void
    {
        Queue::fake();
        $this->get('/e-commerce-software-company-bangladesh')->assertOk()->assertDontSee('data-carousel-prev', false)->assertDontSee('data-carousel-next', false);
        $this->post('/demo', [])->assertSessionHasErrors(['name','phone']);
        $this->post('/demo', ['name'=>'QA demo', 'phone'=>'01700000000','email'=>'qa@example.test'])->assertRedirect();
        $this->assertDatabaseHas('leads',['name'=>'QA demo']);
        Queue::assertPushed(ProcessLead::class);
        $this->post('/demo',['website'=>'bot.example'])->assertRedirect();
        $this->assertDatabaseCount('leads',1);
        $this->post('/subscribe',['email'=>'invalid'])->assertSessionHasErrors('email');
        $this->post('/subscribe',['email'=>'qa@example.test'])->assertRedirect();
        $this->post('/subscribe',['email'=>'qa@example.test'])->assertRedirect();
        $this->assertDatabaseCount('subscribers',1);
    }

    public function test_payments_reject_invalid_amounts_and_extend_month_end_without_overflow(): void
    {
        $this->actingAs(User::factory()->create(['is_admin'=>true]));
        $this->travelTo(now()->setDate(2026,1,31)->startOfDay());
        $customer = Customer::create(['name'=>'QA billing', 'phone'=>'01700000000', 'plan'=>'monthly', 'monthly_fee'=>1000, 'paid_until'=>today(), 'status'=>'suspended']);
        foreach ([-1,0,'invalid',1.5,4294967296] as $amount) {
            $this->post('/admin/customers/'.$customer->id.'/pay',compact('amount'))->assertSessionHasErrors('amount');
        }
        $this->assertDatabaseCount('payments',0);
        $this->post('/admin/customers/'.$customer->id.'/pay',[])->assertRedirect();
        $this->assertDatabaseHas('payments',['customer_id'=>$customer->id,'amount'=>1000]);
        $this->assertSame('2026-02-28',$customer->fresh()->paid_until->toDateString());
        $this->assertSame('active',$customer->fresh()->status);
        $this->travelBack();
    }

    public function test_public_rate_limits_are_enforced_without_blocking_other_forms(): void
    {
        Queue::fake();
        for ($i=0; $i<5; $i++) $this->post('/subscribe',['email'=>'qa@example.test'])->assertRedirect();
        $this->post('/subscribe',['email'=>'qa@example.test'])->assertStatus(429);
        $this->post('/demo',['name'=>'QA demo','phone'=>'01700000000'])->assertRedirect();
        $admin=User::factory()->create(['is_admin'=>true,'password'=>'qa-admin-password']);
        $this->post('/admin/login',['email'=>$admin->email,'password'=>'qa-admin-password'])->assertRedirect('/admin/leads');
        $this->assertAuthenticatedAs($admin);
    }

    public function test_customer_validation_retains_monthly_plan_and_rejects_unknown_prospect(): void
    {
        $this->actingAs(User::factory()->create(['is_admin'=>true]));
        $this->from('/admin/customers/new')->post('/admin/customers', ['plan'=>'monthly'])->assertSessionHasErrors(['name','phone','monthly_fee']);
        $this->get('/admin/customers/new')->assertOk()->assertSee('value="monthly" selected',false);
        $this->post('/admin/customers',['name'=>'QA customer','phone'=>'01700000000','plan'=>'purchase','price'=>100,'prospect_id'=>99999])->assertSessionHasErrors('prospect_id');
        $this->assertDatabaseCount('customers',0);
        $this->post('/admin/customers',['name'=>'QA customer','phone'=>'01700000000','plan'=>'purchase','price'=>100])->assertRedirect('/admin/customers');
        $this->assertDatabaseCount('customers',1);
    }

    public function test_valid_csv_import_and_corrupt_spreadsheet_have_useful_results(): void
    {
        $this->actingAs(User::factory()->create(['is_admin'=>true]));
        $csv=UploadedFile::fake()->createWithContent('qa.csv', "Business,Phone,Followers,Website\nQA shop,01700000000,1.2k,https://example.test\n");
        $this->post('/admin/prospects/import',['file'=>$csv])->assertRedirect();
        $this->assertDatabaseHas('prospects',['page_name'=>'QA shop','followers'=>1200]);
        $bad=UploadedFile::fake()->createWithContent('broken.xlsx','not a spreadsheet');
        $this->post('/admin/prospects/import',['file'=>$bad])->assertRedirect()->assertSessionHasErrors('file');
    }
}
