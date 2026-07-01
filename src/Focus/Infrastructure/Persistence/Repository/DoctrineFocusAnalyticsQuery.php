<?php

namespace App\Focus\Infrastructure\Persistence\Repository;

use App\Dashboard\Application\DTO\Heatmap\Heatmap;
use App\Dashboard\Application\DTO\Heatmap\HeatmapDay;
use App\Dashboard\Application\DTO\Heatmap\HeatmapLevel;
use App\Dashboard\Application\DTO\Heatmap\HeatmapWeek;
use App\Focus\Application\Analytics\QueryRepository\FocusAnalyticsQueryInterface;
use App\Identity\Domain\ValueObject\UserId;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final readonly class DoctrineFocusAnalyticsQuery implements FocusAnalyticsQueryInterface
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    /**
     * @throws Exception
     */
    public function heatmap(
        UserId $userId,
    ): Heatmap {
        $rows = $this->connection->fetchAllAssociative(
            <<<'SQL'
        SELECT
            DATE(started_at) AS day,

            SUM(
                GREATEST(
                    TIMESTAMPDIFF(
                        MINUTE,
                        started_at,
                        COALESCE(
                            ended_at,
                            NOW()
                        )
                    ) - FLOOR(paused_seconds / 60),
                    0
                )
            ) AS focus_minutes,

            COUNT(*) AS completed_tasks,

            0 AS interrupt_count

        FROM focus_session

        WHERE user_id = :userId

        GROUP BY DATE(started_at)

        ORDER BY day
        SQL,
            [
                'userId' => $userId->value(),
            ],
        );

        if ($rows === []) {
            return Heatmap::empty();
        }

        return $this->mapHeatmap($rows);
    }

    private function mapHeatmap(
        array $rows,
    ): Heatmap {
        $statistics = [];

        foreach ($rows as $row) {
            $statistics[$row['day']] = $row;
        }

        $start = (new DateTimeImmutable('-364 days'))
            ->setTime(0, 0);

        $weeks = [];
        $days = [];

        for ($i = 0; $i < 365; $i++) {
            $date = $start->modify("+{$i} days");

            $key = $date->format('Y-m-d');

            $row = $statistics[$key] ?? null;

            if ($row === null) {
                $days[] = new HeatmapDay(
                    date: $date,
                    focusMinutes: 0,
                    completedTasks: 0,
                    interruptCount: 0,
                    level: HeatmapLevel::NONE,
                );
            } else {
                $minutes = (int) $row['focus_minutes'];

                $days[] = new HeatmapDay(
                    date: $date,
                    focusMinutes: $minutes,
                    completedTasks: (int) $row['completed_tasks'],
                    interruptCount: (int) $row['interrupt_count'],
                    level: $this->resolveLevel($minutes),
                );
            }

            if (count($days) === 7) {
                $weeks[] = new HeatmapWeek($days);
                $days = [];
            }
        }

        if ($days !== []) {
            $weeks[] = new HeatmapWeek($days);
        }

        return new Heatmap($weeks);
    }

    private function resolveLevel(
        int $minutes,
    ): HeatmapLevel {
        return match (true) {
            $minutes === 0 => HeatmapLevel::NONE,
            $minutes < 30 => HeatmapLevel::LOW,
            $minutes < 60 => HeatmapLevel::MEDIUM,
            $minutes < 120 => HeatmapLevel::HIGH,
            default => HeatmapLevel::EXTREME,
        };
    }
}
