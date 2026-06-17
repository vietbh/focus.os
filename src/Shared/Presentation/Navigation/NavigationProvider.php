<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Navigation;

final class NavigationProvider
{
    /**
     * @return list<NavigationItem>
     */
    public function primaryItems(): array
    {
        return [
            new NavigationItem(
                label: 'Today',
                route: 'dashboard',
                routePrefix: 'dashboard',
                icon: 'home',
            ),

            new NavigationItem(
                label: 'Inbox',
                route: 'inbox_list',
                routePrefix: 'inbox_',
                icon: 'inbox',
            ),

            new NavigationItem(
                label: 'Tasks',
                route: 'task_list',
                routePrefix: 'task_',
                icon: 'check-square',
            ),

            new NavigationItem(
                label: 'Goals',
                route: 'goal_list',
                routePrefix: 'goal_',
                icon: 'target',
            ),

            new NavigationItem(
                label: 'Areas',
                route: 'area_list',
                routePrefix: 'area_',
                icon: 'folder',
            ),

            new NavigationItem(
                label: 'Notes',
                route: 'note_list',
                routePrefix: 'note_',
                icon: 'file-text',
            ),
        ];
    }

    /**
     * @return list<NavigationItem>
     */
    public function reviewItems(): array
    {
        return [
            new NavigationItem(
                label: 'Daily',
                route: 'daily_review_list',
                routePrefix: 'daily_review_',
            ),

            new NavigationItem(
                label: 'Weekly',
                route: 'weekly_review_list',
                routePrefix: 'weekly_review_',
            ),

            new NavigationItem(
                label: 'Monthly',
                route: 'monthly_review_list',
                routePrefix: 'monthly_review_',
            ),
        ];
    }
}
