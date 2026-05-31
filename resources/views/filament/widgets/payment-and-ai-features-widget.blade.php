<x-filament-widgets::widget class="fi-features-widget">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Payments Gateway Section -->
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-x-2">
                    <x-filament::icon icon="heroicon-o-credit-card" class="w-5 h-5 text-primary-600 dark:text-primary-400" />
                    <span>Manage Payment Gateways</span>
                </div>
            </x-slot>
            
            <x-slot name="description">
                Configure payment gateways including Stripe, Razorpay, Paytm, and COD. Adjust priority ordering, toggles, verify webhook logs, handle payouts, and run diagnostic health connections.
            </x-slot>
            
            <div class="flex items-center gap-x-2 pt-2">
                <x-filament::button
                    size="sm"
                    color="primary"
                    icon="heroicon-m-cog-6-tooth"
                    tag="a"
                    href="/admin/payment-gateways"
                >
                    Gateway Settings
                </x-filament::button>
                <x-filament::button
                    size="sm"
                    color="gray"
                    icon="heroicon-m-document-text"
                    tag="a"
                    href="/admin/payment-transactions"
                >
                    Transactions Audit
                </x-filament::button>
            </div>
        </x-filament::section>

        <!-- Gemini AI Section -->
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-x-2">
                    <x-filament::icon icon="heroicon-o-sparkles" class="w-5 h-5 text-primary-600 dark:text-primary-400" />
                    <span>Google Gemini AI Assistant</span>
                </div>
            </x-slot>
            
            <x-slot name="description">
                Use Google Gemini generative models to compose product catalog descriptions, classify inventory categories, and construct meta tags with SEO optimizations in one click.
            </x-slot>
            
            <div class="flex items-center gap-x-2 pt-2">
                <x-filament::button
                    size="sm"
                    color="primary"
                    icon="heroicon-m-sparkles"
                    tag="a"
                    href="/admin/products/create"
                >
                    Launch AI Creator
                </x-filament::button>
                <x-filament::button
                    size="sm"
                    color="gray"
                    icon="heroicon-m-adjustments-horizontal"
                    tag="a"
                    href="/admin/store-settings"
                >
                    AI Configurations
                </x-filament::button>
            </div>
        </x-filament::section>
    </div>
</x-filament-widgets::widget>
