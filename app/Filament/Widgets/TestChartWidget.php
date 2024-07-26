<?php

namespace App\Filament\Widgets;

use App\Models\Comment;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class TestChartWidget extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Chart';

    protected int|string|array $columnSpan = 0;

    protected function getData(): array
    {
        $start = $this->filters['startDate'] ?? null;
        $end = $this->filters['endDate'] ?? null;

        $data = Trend::model(Comment::class)
            ->between(
                $start ? Carbon::parse($start) : now()->subMonths(6),
                $end ? Carbon::parse($end) : now()
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Blog comments created',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => ['rgba(255, 99, 132, 0.2)'], // Adjust color as needed
                    'borderColor' => ['rgba(255, 99, 132, 1)'], // Adjust color as needed
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        // return 'doughnut';
        return 'line';
    }
}
