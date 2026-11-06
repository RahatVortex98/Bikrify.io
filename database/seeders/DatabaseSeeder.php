<?php

namespace Database\Seeders;

use App\Models\HomeBuildItem;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $steps = [
            ['Discover', 'A short call and a demo with your own products.'],
            ['Build', 'We set up your system in weekly, testable steps.'],
            ['Train', 'Your team learns it with quick guides and a trial run.'],
            ['Support', 'Updates, backups, and fixes after launch.'],
        ];

        $services = [
            [
                'old_slug' => 'online-store-order-system',
                'slug' => 'order-management-system-for-facebook-sellers',
                'title' => 'Order Management System for Facebook Sellers',
                'nav_title' => 'Orders for Facebook Sellers',
                'tagline' => 'An order management system for Facebook sellers to organize orders from message to delivery.',
                'h1' => 'Order Management System for Facebook Sellers',
                'seo_title' => 'Order Management System for Facebook Sellers | Bikrify',
                'meta_description' => 'Organize Facebook orders, customer details, confirmations, and delivery in one order management system for sellers in Bangladesh.',
                'intro' => 'An order management system for Facebook sellers gives your team one clear place to record each order, check customer details, and follow its progress. If orders arrive through Facebook pages, Messenger, WhatsApp, or a website, information can become scattered across conversations and notebooks. A shared order record helps you see what needs confirmation, what is ready to pack, and what has gone to a courier without searching through old chats.',
                'problems' => ['Orders are spread across Messenger and WhatsApp conversations', 'Staff retype names, phone numbers, and addresses', 'A parcel may be packed before the customer confirms', 'It is difficult to find the reason for a return'],
                'solutions' => ['Keep customer and order details together', 'Review and confirm orders before dispatch', 'See the current order stage in a shared list', 'Record delivery outcomes and follow-up notes'],
                'caps' => [
                    ['Order records', 'Keep item, quantity, customer, and delivery details together.'],
                    ['Order stages', 'See which orders are new, confirmed, packed, or dispatched.'],
                    ['Courier handoff', 'Keep delivery details ready for your chosen courier process.'],
                    ['Return follow-up', 'Record returned parcels and decide what to do next.'],
                ],
                'sections' => [
                    ['Why sellers need an order process', 'A Facebook order may begin in a comment, continue in Messenger, and end with a phone call. When several people reply to customers, it is easy to miss an address correction or forget that a customer asked to confirm before shipping. A clear process turns each request into an order record with the information your team needs. You can decide which details must be checked before an order moves forward, such as a reachable phone number, delivery area, product choice, and quantity. This does not replace good customer service; it gives the team a reliable way to provide it.'],
                    ['Collect the details that matter', 'The right order form reflects how your shop actually sells. A clothing seller may need a size and colour, while a food seller may need a delivery time and special instruction. Keep the fields useful and straightforward, and avoid collecting personal information that is not needed to fulfill an order. When customers correct a detail, update the order record so the person packing the parcel sees the latest information rather than an older chat message.'],
                    ['Confirm before packing', 'A short confirmation step helps your staff catch incomplete orders before a parcel is prepared. The team can check the selected item, quantity, delivery address, and phone number, then record whether the customer confirmed. For cash-on-delivery orders, clear confirmation is especially useful because a parcel that cannot be delivered creates work for both the seller and the courier. A record of the confirmation also lets another team member answer questions without asking the customer to repeat the whole conversation.'],
                    ['Track packing, dispatch, and returns', 'Simple order stages show what the team should do next. For example, new, awaiting confirmation, ready to pack, dispatched, delivered, and returned may fit your process. Keep the names consistent so staff understand them. When a courier update or customer message changes the situation, update the order and record a useful note. Returned parcels can then be reviewed for a reason, such as an unreachable customer or an address issue, rather than disappearing from the sales list.'],
                    ['Use information to improve daily work', 'An organized order list helps answer practical questions: which orders still need a call, which parcels are waiting to be packed, and which deliveries need follow-up? Reviewing those lists at the start and end of the day gives the team a shared routine. You can also use recorded order outcomes to notice recurring operational issues, while remembering that past outcomes do not guarantee what a future customer will do. Good records support informed decisions; they do not replace judgment or respectful customer communication.'],
                    ['Choose a setup that fits your shop', 'Before adopting a tool, list the channels where orders arrive, the details your team must capture, and the steps between confirmation and delivery. Ask who will enter orders, who can view customer information, and how corrections will be handled. Start with the process you need today and add fields or integrations only when they solve a real problem. If you also need storefront and checkout features, see our online store and order tools. Shops with counter sales can explore POS software for Bangladesh, while businesses coordinating multiple departments may need custom ERP software.'],
                ],
                'faq' => [
                    ['What does an order management system do for a Facebook seller?', 'It keeps order and customer details together and helps the team track an order from request and confirmation through dispatch and delivery.'],
                    ['Can it handle orders from Messenger and WhatsApp?', 'The process can include orders from the channels your team uses. The exact data entry and integrations should be confirmed during requirements planning.'],
                    ['Does the system guarantee fewer returned parcels?', 'No system can guarantee delivery outcomes. Recording confirmations, contact details, and return reasons can help your team review its process.'],
                    ['Can I start without replacing my Facebook page?', 'Yes. An order workflow can support the way customers already find and contact your business. A separate storefront is optional and depends on your needs.'],
                    ['How do I choose which order details to collect?', 'Start with the information needed to identify the product, contact the customer, prepare the order, and arrange delivery. Avoid unnecessary personal data.'],
                ],
            ],
            [
                'old_slug' => 'pos-inventory-system',
                'slug' => 'pos-software-bangladesh',
                'title' => 'POS Software Bangladesh',
                'nav_title' => 'POS & Inventory',
                'tagline' => 'POS software in Bangladesh shops can use to connect checkout with stock records.',
                'h1' => 'POS Software Bangladesh',
                'seo_title' => 'POS Software Bangladesh | Bikrify',
                'meta_description' => 'Explore POS software for Bangladesh shops to record sales, track stock, manage returns, and review daily totals in one place.',
                'intro' => 'POS software in Bangladesh can help a shop record counter sales and keep its stock information close to the checkout process. When sales, returns, and stock adjustments are written in separate places, it takes extra work to understand what is available and how the day went. A point-of-sale workflow brings those everyday records together so staff can enter a sale, apply the right price, and review what changed during a shift.',
                'problems' => ['Paper sales records take time to total', 'Staff cannot easily confirm current stock', 'Returns and exchanges are recorded inconsistently', 'Branch prices and day-end totals are hard to compare'],
                'solutions' => ['Record each sale with its items and payment details', 'Update stock as sales and returns are entered', 'Keep a consistent process for adjustments', 'Review daily totals by branch or payment type'],
                'caps' => [
                    ['Counter checkout', 'Record products, quantities, discounts, and payments.'],
                    ['Stock records', 'Review available quantities and record stock changes.'],
                    ['Returns and exchanges', 'Keep the reason and stock outcome with the transaction.'],
                    ['Daily review', 'Compare sales totals using a consistent end-of-day routine.'],
                ],
                'sections' => [
                    ['A clearer checkout record', 'A point-of-sale system is most useful when it matches the way staff serve customers. The checkout flow should make it straightforward to find an item, enter a quantity, apply an approved price, and record how the customer paid. A receipt or transaction record helps the shop answer questions later. Before choosing POS software, walk through a normal sale and a less common case, such as a partial payment or a price correction, and confirm how each should be recorded.'],
                    ['Keep stock changes understandable', 'Stock counts change for more reasons than sales. A delivery from a supplier adds items, damage may remove them, and a return may or may not be suitable for resale. A reliable stock process records why a quantity changed and who entered the adjustment. This makes later stock checks more useful than a single unexplained number. Decide how often staff should count key items and how they should report a difference between the shelf and the system.'],
                    ['Handle returns with care', 'A return affects both the customer transaction and the stock record. Staff should record which item came back, why it was returned, and whether it is going back into sellable stock. These steps help the business keep an accurate record without assuming every returned item is ready to sell again. A consistent process also makes it easier to explain an exchange or refund and to review recurring product or service issues.'],
                    ['Support one shop or several counters', 'A single shop may need a shared view across a counter and a back room. A business with multiple branches may also need to know where stock is held and which price list applies at each location. Agree on product names, units, and adjustment rules before setting up more than one location. Staff training matters: people need to know which branch or register they are using and how to record transfers so the same stock is not counted twice.'],
                    ['Make day-end totals easier to review', 'At closing time, compare the sales recorded by the POS with the cash and other payment records your team actually has. Differences should be investigated and noted rather than silently changed. A regular checklist can cover refunds, cancelled transactions, cash movements, and unresolved payment questions. Reports are only as useful as the entries behind them, so clear staff practices and occasional stock checks remain important even when software is used.'],
                    ['Plan for your equipment and workflow', 'List the products you sell, how they are priced, the payment methods you accept, and any printers or scanners you expect to use. Confirm compatibility before buying new equipment or relying on a feature such as offline checkout. The right setup depends on the shop and should be tested with staff before going live. If online and social sales are also important, review our order management system for Facebook sellers. For connected finance, approvals, or several business functions, consider custom ERP software in Bangladesh.'],
                ],
                'faq' => [
                    ['What is POS software used for?', 'POS software records sales at checkout and can connect those transactions with stock, payments, and reporting workflows.'],
                    ['Can POS software track inventory?', 'A POS setup can update stock from recorded sales and returns. Receiving, damage, and manual counts still need a clear process.'],
                    ['Will it work with my receipt printer or barcode scanner?', 'Compatibility depends on the exact hardware and setup. Confirm each device model and connection method before implementation.'],
                    ['Can different branches use different prices?', 'Branch-specific pricing can be planned where the selected setup supports it. Agree on central prices and local exceptions before configuration.'],
                    ['Does POS software work without an internet connection?', 'Offline behavior varies by product and configuration. Confirm how sales sync and how conflicts are handled before relying on offline use.'],
                ],
            ],
            [
                'old_slug' => 'custom-erp-automation',
                'slug' => 'custom-erp-software-bangladesh',
                'title' => 'Custom ERP Software Bangladesh',
                'nav_title' => 'Custom ERP Software',
                'tagline' => 'Custom ERP software in Bangladesh planned around your company’s daily workflows.',
                'h1' => 'Custom ERP Software Bangladesh',
                'seo_title' => 'Custom ERP Software Bangladesh | Bikrify',
                'meta_description' => 'Plan custom ERP software in Bangladesh around your company’s approvals, records, stock, and reporting needs, one practical workflow at a time.',
                'intro' => 'Custom ERP software in Bangladesh can connect the records and routines that a growing company currently manages across spreadsheets, messages, and separate applications. An ERP project should begin with the work people actually do, not a long list of features. Mapping who creates information, who approves it, and who needs to use it helps define a practical system that supports the company without making everyday tasks harder.',
                'problems' => ['Business information is duplicated across spreadsheets', 'Approvals are difficult to follow across messages', 'Teams use different names for the same records', 'Reports require repeated manual copying'],
                'solutions' => ['Agree on shared records and ownership', 'Make approval steps visible to the right people', 'Connect selected business workflows', 'Build reports from consistently maintained data'],
                'caps' => [
                    ['Business records', 'Plan shared customer, product, supplier, and transaction records.'],
                    ['Approvals', 'Make requests, decisions, and responsible people visible.'],
                    ['Connected workflows', 'Reduce repeated entry between selected business tasks.'],
                    ['Reports', 'Organize operational information for regular review.'],
                ],
                'sections' => [
                    ['Start with the work, not the software', 'ERP means enterprise resource planning, but a useful project is about the specific work your company needs to coordinate. Begin by following a few real tasks from start to finish. For example, trace how a purchase request becomes an approved order, how incoming items are recorded, and how a manager reviews the result. Ask the people who do the work where delays or repeated entry occur. This gives the team a grounded view of the problem before deciding which software features are necessary.'],
                    ['Agree on shared information', 'Different departments may keep separate names, codes, and versions of the same customer, product, or supplier. Before connecting their processes, decide which record is authoritative and who can update it. Define required fields in plain language and plan how old records will be checked before they are moved. Data migration is not simply a technical copy: inconsistent or outdated information needs review. A careful plan reduces confusion when staff begin using a shared system.'],
                    ['Make approvals clear', 'An approval workflow should show what is being requested, who needs to decide, and what happens after a decision. Consider ordinary cases as well as exceptions, such as a request that needs more information or a decision-maker who is unavailable. Keep the steps proportionate to the value and risk of the request. The goal is not to add approval for every action; it is to make important decisions easier to follow and less dependent on searching through individual inboxes.'],
                    ['Introduce modules in manageable steps', 'A company does not need to replace every tool at once. It may be more practical to start with one well-understood workflow, train its users, and learn from a trial period before expanding. Choose an initial scope with clear boundaries and a way to judge whether the new process works for the people using it. Later modules should connect to the shared records where that is useful. Smaller, reviewed steps make it easier to address issues early than a single large change.'],
                    ['Treat access, training, and maintenance as part of the project', 'Business records can contain information that should only be available to certain roles. Define who may view or change each kind of record, and remove access when it is no longer needed. Train staff using examples from their own responsibilities and provide a straightforward way to report problems. Agree on backups, updates, support, and ownership before launch. Software needs ongoing care; a handover should make clear who maintains the system and how future changes are requested.'],
                    ['Choose an implementation partner carefully', 'Ask how requirements will be documented, how you can review progress, what testing is included, and how data will be handled. Request a clear scope and discuss what is not included, how changes affect cost, and who owns the delivered work. Avoid committing to features before the underlying process is understood. If the immediate need is mainly counter sales, POS software for Bangladesh shops may be a more focused starting point. For social commerce order workflows, compare our order management system for Facebook sellers.'],
                ],
                'faq' => [
                    ['What is custom ERP software?', 'It is business software planned around an organization’s records and workflows rather than relying only on a fixed, generic process.'],
                    ['Does every company need an ERP system?', 'No. The right choice depends on the number of connected workflows, the problems to solve, and the cost of maintaining a new system.'],
                    ['Can an ERP project start with one department?', 'Yes. A defined first workflow or module can be implemented and reviewed before deciding whether to expand.'],
                    ['How do you plan a custom ERP project?', 'Document the current work, identify the users and data involved, agree on scope, and test the proposed workflow with the people who will use it.'],
                    ['How should we prepare our existing data?', 'Identify the records to move, check for duplicates and outdated details, agree on ownership, and test the migration before using it for daily work.'],
                ],
            ],
        ];

        foreach ($services as $index => $serviceData) {
            $slug = $serviceData['slug'];
            $oldSlug = $serviceData['old_slug'];
            unset($serviceData['old_slug']);

            $service = Service::where('slug', $slug)->first()
                ?? Service::where('slug', $oldSlug)->first()
                ?? new Service;

            $service->fill([
                'slug' => $slug,
                'title' => $serviceData['title'],
                'tagline' => $serviceData['tagline'],
                'intro' => $serviceData['intro'],
                'sort' => $index,
                'data' => [
                    'h1' => $serviceData['h1'],
                    'nav_title' => $serviceData['nav_title'],
                    'seo_title' => $serviceData['seo_title'],
                    'meta_description' => $serviceData['meta_description'],
                    'problems' => $serviceData['problems'],
                    'solutions' => $serviceData['solutions'],
                    'caps' => $serviceData['caps'],
                    'sections' => $serviceData['sections'],
                    'faq' => $serviceData['faq'],
                    'steps' => $steps,
                ],
            ])->save();
        }

        Service::orderBy('sort')->get()->each(function (Service $service) {
            HomeBuildItem::firstOrCreate(
                ['url' => '/services/'.$service->slug],
                [
                    'title' => $service->title,
                    'description' => $service->tagline,
                    'sort' => $service->sort,
                ]
            );
        });

        $password = env('ADMIN_PASSWORD') ?: Str::random(14);
        $admin = User::firstOrCreate(
            ['email' => config('bikrify.admin_email')],
            ['name' => 'Admin', 'password' => Hash::make($password)]
        );

        if ($admin->wasRecentlyCreated) {
            $admin->forceFill(['is_admin' => true])->save();
            $this->command->info('Admin login: '.config('bikrify.admin_email').' / '.$password);
        } else {
            $this->command->info('Admin account already exists; its password was not changed.');
        }
    }
}
