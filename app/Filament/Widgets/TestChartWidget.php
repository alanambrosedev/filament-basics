<?php

namespace App\Filament\Widgets;

use App\Models\Comment;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class TestChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected int | string | array $columnSpan = 0;


    protected function getData(): array
    {
        $data = Trend::model(Comment::class)
            ->between(
                start: now()->subMonths(6),
                end: now(),
            )
            ->perMonth()
            ->count();
        
        
        
        return [
            'datasets' => [
                [
                    'label' => 'Blog comments created',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),

                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
            // 'datasets' => [
            //     [
            //         'label' => '2023-24',
            //         'data' => [300, 50, 100],
            //         'backgroundColor' => [
            //         'rgb(255, 99, 132)',
            //         'rgb(54, 162, 235)',
            //         'rgb(255, 205, 86)'
            //         ],
            //     ],
            // ],
            // 'labels' => ['A','B','C']
        ];
    }

    protected function getType(): string
    {
        // return 'doughnut';
        return 'line';

    }
}
