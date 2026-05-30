<?php

namespace App\Filament\Widgets;

use Filament\Widgets\AccountWidget as BaseAccountWidget;

class CustomAccountWidget extends BaseAccountWidget
{
    /**
     * Set the width to full column span.
     */
    protected int|string|array $columnSpan = 'full';

    protected static string $view = 'filament.widgets.custom-account-widget';
}
