<?php

namespace App\Filament\Components;

use Filament\Schemas\Components\Section;

class FullWidthSection extends Section
{
    public function setup(): void
    {
        parent::setup();
        $this->columnSpanFull();
    }
}
