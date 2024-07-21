<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestWidget extends BaseWidget
{


    protected function getStats(): array
    {
        return [
            Stat::make('New  Users', User::count())
            ->description('New users that have joined.')
            ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
            ->chart([0,5,10,15,20,25,30,35,40,45,50])
            ->color('success')
        ];
    }
}
