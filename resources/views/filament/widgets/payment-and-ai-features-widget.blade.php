<x-filament-widgets::widget class="fi-features-widget">
    <x-filament::section>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center gap-x-3">
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-primary-500/10 text-primary-500">
                    <x-filament::icon icon="heroicon-o-sparkles" class="w-6 h-6" />
                </div>
                <div>
                    <h2 class="text-lg font-bold leading-6 text-gray-950 dark:text-white">
                        New Core Upgrades Active
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Enterprise Payment Infrastructure and Google Gemini AI integrations are successfully compiled and deployed.
                    </p>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Payment Gateway Card -->
                <div class="p-5 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/10 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="inline-flex items-center gap-x-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-emerald-500/10 text-emerald-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Driver-Based Architecture
                            </span>
                            <x-filament::icon icon="heroicon-o-credit-card" class="w-5 h-5 text-gray-400" />
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1">
                            Enterprise Payments Gateway
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-4 leading-relaxed">
                            Support for Stripe, Razorpay, Paytm, and COD with automated fallback routing, webhook verification, partial/full refund console, and live health monitors.
                        </p>
                    </div>
                    <div class="flex items-center gap-x-2 pt-2 border-t border-gray-150 dark:border-white/5">
                        <x-filament::button
                            size="sm"
                            color="primary"
                            icon="heroicon-m-cog-6-tooth"
                            tag="a"
                            href="/admin/payment-gateways"
                        >
                            Configure Gateways
                        </x-filament::button>
                        <x-filament::button
                            size="sm"
                            color="gray"
                            icon="heroicon-m-document-text"
                            tag="a"
                            href="/admin/payment-transactions"
                        >
                            Audit Logs
                        </x-filament::button>
                    </div>
                </div>

                <!-- Gemini AI Card -->
                <div class="p-5 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/10 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="inline-flex items-center gap-x-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-blue-500/10 text-blue-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                Powered by Gemini LLM
                            </span>
                            <x-filament::icon icon="heroicon-o-sparkles" class="w-5 h-5 text-gray-400" />
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1">
                            Google Gemini AI Assistants
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-4 leading-relaxed">
                            Generate detailed catalog descriptions, automatically suggest matching product categories, and compile metadata tags with single-click SEO optimizations.
                        </p>
                    </div>
                    <div class="flex items-center gap-x-2 pt-2 border-t border-gray-150 dark:border-white/5">
                        <x-filament::button
                            size="sm"
                            color="primary"
                            icon="heroicon-m-sparkles"
                            tag="a"
                            href="/admin/products/create"
                        >
                            Try AI Assistant
                        </x-filament::button>
                        <x-filament::button
                            size="sm"
                            color="gray"
                            icon="heroicon-m-adjustments-horizontal"
                            tag="a"
                            href="/admin/store-settings"
                        >
                            AI Settings
                        </x-filament::button>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
