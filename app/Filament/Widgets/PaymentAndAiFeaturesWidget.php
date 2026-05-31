<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class PaymentAndAiFeaturesWidget extends Widget
{
    protected static ?int $sort = 0;

    protected int|string|array $columnSpan = 'full';

    protected static string $view = 'filament.widgets.payment-and-ai-features-widget';
}
