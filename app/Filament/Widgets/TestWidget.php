<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestWidget extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        return [
            Stat::make('New Users',
                User::when($this->filters['startDate'], fn ($query) => $query->whereDate('created_at', '>', $this->filters['startDate'])
                    ->when($this->filters['endDate'], fn ($query) => $query->whereDate('created_at', '<', $this->filters['endDate'])
                    ))->count()
            )
                ->description('New users that have joined.')
                ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
                ->chart([0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50])
                ->color('success'),
        ];
    }
}
