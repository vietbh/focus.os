<?php

declare(strict_types=1);

namespace App\Review\Application\UseCase;

use App\Dashboard\Application\DTO\DashboardSnapshot;
use App\Review\Application\DTO\DailyReviewSuggestion;

final class GenerateDailyReviewSuggestionUseCase
{
    public function execute(
        DashboardSnapshot $snapshot,
    ): DailyReviewSuggestion {
        return new DailyReviewSuggestion(
            completedWork: $this->buildCompletedWork($snapshot),
            wins: $this->buildWins($snapshot),
            blockers: $this->buildBlockers($snapshot),
            focusTomorrow: $this->buildFocusTomorrow($snapshot),
        );
    }

    private function buildCompletedWork(
        DashboardSnapshot $snapshot,
    ): string {
        $lines = [];

        if ($snapshot->today->doneTasks > 0) {
            $lines[] = sprintf(
                'Completed %d task(s).',
                $snapshot->today->doneTasks,
            );
        }

        if ($snapshot->currentTask !== null) {
            $lines[] = sprintf(
                'Made progress on "%s".',
                $snapshot->currentTask->title(),
            );
        }

        return implode("\n", $lines);
    }

    private function buildWins(
        DashboardSnapshot $snapshot,
    ): string {
        $lines = [];

        if ($snapshot->today->focusMinutes > 0) {
            $hours = intdiv(
                $snapshot->today->focusMinutes,
                60,
            );

            $minutes = $snapshot->today->focusMinutes % 60;

            $lines[] = sprintf(
                'Focused for %dh %dm.',
                $hours,
                $minutes,
            );
        }

        if ($snapshot->today->doneTasks > 0) {
            $lines[] = sprintf(
                'Finished %d task(s).',
                $snapshot->today->doneTasks,
            );
        }

        return implode("\n", $lines);
    }

    private function buildBlockers(
        DashboardSnapshot $snapshot,
    ): string {
        if ($snapshot->today->interruptedTasks === 0) {
            return '';
        }

        return sprintf(
            'Interrupted %d time(s).',
            $snapshot->today->interruptedTasks,
        );
    }

    private function buildFocusTomorrow(
        DashboardSnapshot $snapshot,
    ): string {
        if ($snapshot->currentTask === null) {
            return '';
        }

        return sprintf(
            'Continue "%s".',
            $snapshot->currentTask->title(),
        );
    }
}
