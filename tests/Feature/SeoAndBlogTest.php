<?php

namespace Tests\Feature;

use App\Models\HomeBuildItem;
use App\Models\Post;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\BlogSeeder;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SeoAndBlogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_home_page_has_its_seo_content_and_canonical_url(): void
    {
        $response = $this->get(route('home'))->assertOk();
        $homeTitle = 'Bikrify: Order Management & ERP Software, Bangladesh';
        $homeDescription = 'Stop losing orders. Bikrify builds online stores, order management, POS and ERP for Bangladeshi sellers and growing businesses. Get a free demo.';
        $this->assertLessThan(60, mb_strlen($homeTitle));
        $this->assertLessThan(155, mb_strlen($homeDescription));
        $response->assertSeeText($homeTitle);
        $response->assertSee('<meta name="description" content="'.$homeDescription.'">', false);
        $response->assertSee('rel="canonical" href="'.route('home').'"', false);
        $response->assertSee('property="og:locale" content="en_BD"', false);
        $response->assertSee('name="twitter:card" content="summary_large_image"', false);
        $response->assertSee('<h1', false);
        $this->assertSame(1, preg_match_all('/<h1(?:\s|>)/i', $response->getContent()));
        $this->assertStringContainsString(
            'e-commerce software company in bangladesh',
            mb_strtolower($response->getContent())
        );
        $this->assertGreaterThan(600, $this->wordCount($response->getContent()));

        $organization = collect($this->jsonLd($response->getContent()))->firstWhere('@type', 'Organization');
        $this->assertSame('Bikrify', $organization['name']);
        $this->assertSame('Bikrify builds online stores, order management, POS, and custom ERP for Bangladeshi sellers and growing businesses.', $organization['description']);
        $this->assertSame(config('bikrify.phone'), $organization['telephone']);
        $this->assertSame(config('bikrify.address'), $organization['address']['streetAddress']);
    }

    public function test_home_page_shows_a_horizontal_carousel_of_published_posts_only(): void
    {
        $published = Post::create([
            'title' => 'A published carousel article',
            'slug' => 'published-carousel-article',
            'excerpt' => 'This article can be browsed from the homepage carousel.',
            'meta_description' => 'A published article for testing the homepage carousel display.',
            'body' => str_repeat('Useful published article text. ', 5),
            'published_at' => now()->subDay(),
        ]);
        Post::create([
            'title' => 'A private carousel draft',
            'slug' => 'private-carousel-draft',
            'excerpt' => 'This draft must remain private.',
            'meta_description' => 'An unpublished draft that must not appear on the homepage.',
            'body' => str_repeat('Private draft content. ', 5),
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Practical business guides and ideas')
            ->assertSee('data-blog-carousel', false)
            ->assertSee('data-carousel-track', false)
            ->assertSee('data-carousel-prev', false)
            ->assertSee('data-carousel-next', false)
            ->assertSee($published->title)
            ->assertSee(route('blog.show', $published), false)
            ->assertDontSee('A private carousel draft')
            ->assertSeeInOrder(['Workflows to plan', 'Practical business guides and ideas', 'Software should fit the way your business works']);
    }

    public function test_home_page_keeps_blog_section_visible_when_there_are_no_published_posts(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSeeInOrder(['Workflows to plan', 'Practical business guides and ideas', 'New articles are being prepared.'])
            ->assertSee(route('blog.index'), false);
    }

    public function test_homepage_what_we_build_cards_are_admin_customizable(): void
    {
        User::create([
            'name' => 'Homepage editor',
            'email' => 'homepage-editor@example.test',
            'password' => Hash::make('secure-test-password'),
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('What we build')
            ->assertSee('Practical software shaped around the way your business works today')
            ->assertSee(Service::firstOrFail()->title);

        $this->withBasicAuth('homepage-editor@example.test', 'secure-test-password')
            ->post(route('admin.home-build.store'), [
                'title' => 'Retail analytics',
                'description' => 'Review store activity and keep useful business records together.',
                'url' => '/services/retail-analytics',
                'sort' => 3,
            ])
            ->assertRedirect(route('admin.home-build.index'));

        $item = HomeBuildItem::where('title', 'Retail analytics')->firstOrFail();
        $this->get(route('home'))->assertSee('Retail analytics')->assertSee('/services/retail-analytics');

        $this->withBasicAuth('homepage-editor@example.test', 'secure-test-password')
            ->put(route('admin.home-build.update', $item), [
                'title' => 'Retail reporting',
                'description' => 'A clearer view of your shop records.',
                'url' => 'https://example.com/retail',
                'sort' => 0,
            ])
            ->assertRedirect(route('admin.home-build.index'));

        $this->assertDatabaseHas('home_build_items', [
            'id' => $item->id,
            'title' => 'Retail reporting',
            'url' => 'https://example.com/retail',
            'sort' => 0,
        ]);

        $this->withBasicAuth('homepage-editor@example.test', 'secure-test-password')
            ->post(route('admin.home-build.store'), [
                'title' => 'Unsafe link',
                'description' => 'Invalid link should not be accepted.',
                'url' => 'javascript:alert(1)',
                'sort' => 4,
            ])
            ->assertSessionHasErrors('url');
    }

    public function test_service_pages_have_seo_metadata_structured_data_five_faqs_and_long_copy(): void
    {
        $expectedPages = [
            'order-management-system-for-facebook-sellers' => 'Order Management System for Facebook Sellers',
            'pos-software-bangladesh' => 'POS Software Bangladesh',
            'custom-erp-software-bangladesh' => 'Custom ERP Software Bangladesh',
        ];

        foreach ($expectedPages as $slug => $keyword) {
            $service = Service::where('slug', $slug)->firstOrFail();
            $response = $this->get(route('service', $service))->assertOk();
            $html = $response->getContent();

            $this->assertLessThan(60, mb_strlen($service->data['seo_title']));
            $this->assertLessThan(155, mb_strlen($service->data['meta_description']));
            $response->assertSee('<title>'.$service->data['seo_title'].'</title>', false);
            $response->assertSee('<meta name="description" content="'.$service->data['meta_description'].'">', false);
            $response->assertSee('<meta property="og:url" content="'.route('service', $service).'">', false);
            $response->assertSee('<h1', false);
            $response->assertSee($keyword, false);
            $response->assertSee($service->intro);
            $response->assertSee(route('service', $service), false);
            $schemaTypes = collect($this->jsonLd($html))->pluck('@type');
            $this->assertContains('Service', $schemaTypes);
            $this->assertContains('FAQPage', $schemaTypes);
            $this->assertCount(5, $service->data['faq']);
            $this->assertSame(1, preg_match_all('/<h1(?:\s|>)/i', $html));
            $this->assertGreaterThan(600, $this->wordCount($html), "Insufficient copy for {$slug}");

            foreach (Service::where('id', '!=', $service->id)->get() as $related) {
                $response->assertSee(route('service', $related), false);
            }
        }
    }

    public function test_blog_only_shows_published_posts_and_adds_article_schema(): void
    {
        $published = Post::create([
            'title' => 'A practical guide to order records',
            'slug' => 'practical-guide-order-records',
            'excerpt' => 'A guide for keeping order details clear.',
            'meta_description' => 'Learn practical ways to keep order details organized for your team.',
            'body' => str_repeat('Keep each order record clear and useful. ', 5),
            'published_at' => now()->subDay(),
        ]);
        $draft = Post::create([
            'title' => 'Unpublished article',
            'slug' => 'unpublished-article',
            'excerpt' => 'This draft is not public.',
            'meta_description' => 'This draft should remain private.',
            'body' => str_repeat('Draft content remains private. ', 5),
        ]);

        $this->get(route('blog.index'))
            ->assertOk()
            ->assertSee($published->title)
            ->assertDontSee($draft->title);

        $articleResponse = $this->get(route('blog.show', $published))->assertOk();
        $articleResponse
            ->assertSee('<title>'.$published->title.'</title>', false)
            ->assertSee('<h1', false);
        $this->assertSame(1, preg_match_all('/<h1(?:\s|>)/i', $articleResponse->getContent()));
        $articleSchema = collect($this->jsonLd($articleResponse->getContent()))->firstWhere('@type', 'Article');
        $this->assertSame($published->title, $articleSchema['headline']);

        $this->get(route('blog.show', $draft))->assertNotFound();
    }

    public function test_supplied_blog_seeder_creates_five_drafts_without_publishing_them(): void
    {
        $this->seed(BlogSeeder::class);

        $posts = Post::all();
        $this->assertCount(5, $posts);

        foreach ($posts as $post) {
            $this->assertNull($post->published_at);
            $this->assertLessThanOrEqual(60, mb_strlen($post->title));
            $this->assertLessThanOrEqual(155, mb_strlen($post->meta_description));
        }

        $this->get(route('blog.index'))->assertDontSee('How to Stop Fake Orders in F-commerce Bangladesh');
    }

    public function test_published_markdown_is_rendered_without_raw_html_or_unsafe_links(): void
    {
        $post = Post::create([
            'title' => 'Markdown article',
            'slug' => 'markdown-article',
            'excerpt' => 'A Markdown article.',
            'meta_description' => 'A guide with safely rendered Markdown.',
            'body' => "## Useful heading\n\n- First item\n- Second item\n\n[Unsafe](javascript:alert%281%29)\n\n<script>alert('unsafe')</script>",
            'published_at' => now()->subMinute(),
        ]);

        $response = $this->get(route('blog.show', $post))->assertOk();
        $response->assertSee('<h2>Useful heading</h2>', false);
        $response->assertSee('<ul>', false);
        $response->assertDontSee('<script>alert', false);
        $response->assertDontSee('href="javascript:', false);
    }

    public function test_authenticated_admin_can_create_and_edit_blog_posts(): void
    {
        User::create([
            'name' => 'Blog editor',
            'email' => 'editor@example.test',
            'password' => Hash::make('secure-test-password'),
        ]);

        $this->withBasicAuth('editor@example.test', 'secure-test-password')
            ->post(route('admin.blog.store'), [
                'title' => 'Planning a useful order workflow',
                'excerpt' => 'A practical starting point for organizing daily orders.',
                'meta_description' => 'Plan a clear order workflow for your team and daily customer requests.',
                'body' => str_repeat('A clear workflow makes the next step easier to understand. ', 3),
                'published_at' => '',
            ])
            ->assertRedirect();

        $post = Post::where('slug', 'planning-a-useful-order-workflow')->firstOrFail();
        $this->assertNull($post->published_at);

        $this->withBasicAuth('editor@example.test', 'secure-test-password')
            ->put(route('admin.blog.update', $post), [
                'title' => 'Planning a better order workflow',
                'slug' => 'planning-a-better-order-workflow',
                'excerpt' => 'A revised guide to organizing daily orders.',
                'meta_description' => 'Plan a clear order workflow for your team and daily customer requests.',
                'body' => str_repeat('A clear workflow makes the next step easier to understand. ', 3),
                'published_at' => '',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Planning a better order workflow',
            'slug' => 'planning-a-better-order-workflow',
        ]);
    }

    public function test_admin_publication_time_is_saved_as_bangladesh_time(): void
    {
        User::create([
            'name' => 'Blog editor',
            'email' => 'publisher@example.test',
            'password' => Hash::make('secure-test-password'),
        ]);
        $localPublicationTime = now()->timezone('Asia/Dhaka')->format('Y-m-d\TH:i');

        $this->withBasicAuth('publisher@example.test', 'secure-test-password')
            ->post(route('admin.blog.store'), [
                'title' => 'A Bangladesh time test',
                'excerpt' => 'A post created using the local publication time.',
                'meta_description' => 'Check publication dates using Bangladesh local time.',
                'body' => str_repeat('This article tests publication in Bangladesh local time. ', 3),
                'published_at' => $localPublicationTime,
            ])
            ->assertRedirect();

        $post = Post::where('slug', 'a-bangladesh-time-test')->firstOrFail();
        $this->assertTrue($post->published_at->lte(now()));
        $this->get(route('blog.show', $post))->assertOk();
    }

    public function test_sitemap_includes_service_and_published_article_last_modified_dates(): void
    {
        $post = Post::create([
            'title' => 'Sitemap article',
            'slug' => 'sitemap-article',
            'excerpt' => 'An article listed in the sitemap.',
            'meta_description' => 'An article included in the XML sitemap.',
            'body' => str_repeat('Published articles appear in the XML sitemap. ', 5),
            'published_at' => now()->subDay(),
        ]);
        $service = Service::firstOrFail();

        $this->get(route('sitemap'))
            ->assertOk()
            ->assertSee(route('blog.index'), false)
            ->assertSee(route('service', $service), false)
            ->assertSee($service->updated_at->toAtomString(), false)
            ->assertSee(route('blog.show', $post), false)
            ->assertSee($post->updated_at->toAtomString(), false);
    }

    public function test_robots_file_allows_public_pages_and_excludes_admin_and_api(): void
    {
        $robots = file_get_contents(public_path('robots.txt'));

        $this->assertIsString($robots);
        $this->assertStringContainsString('User-agent: *', $robots);
        $this->assertStringContainsString('Allow: /', $robots);
        $this->assertStringContainsString('Disallow: /admin', $robots);
        $this->assertStringContainsString('Disallow: /api', $robots);
        $this->assertStringContainsString('Sitemap: https://bikrify.io/sitemap.xml', $robots);
    }

    private function wordCount(string $html): int
    {
        preg_match('/<main\b[^>]*>(.*?)<\/main>/is', $html, $main);
        $body = preg_replace('/<(script|style)\b[^>]*>.*?<\/\1>/is', ' ', $main[1] ?? $html);
        $plainText = html_entity_decode(strip_tags($body), ENT_QUOTES | ENT_HTML5);
        preg_match_all('/[\p{L}\p{N}]+(?:[\'’-][\p{L}\p{N}]+)*/u', $plainText, $words);

        return count($words[0]);
    }

    private function jsonLd(string $html): array
    {
        preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/is', $html, $matches);

        return array_map(
            fn (string $json) => json_decode($json, true, 512, JSON_THROW_ON_ERROR),
            $matches[1]
        );
    }
}
