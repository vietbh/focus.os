<?php

namespace App\Focus\Application\QueryRepository;

use App\Focus\Application\DTO\FocusStatisticsDto;
use App\Identity\Domain\ValueObject\UserId;
use DateTimeImmutable;

interface FocusStatisticsQueryInterface
{
    public function daily(
        UserId $userId,
        DateTimeImmutable $date,
    ): FocusStatisticsDto;

    public function weekly(
        UserId $userId,
        DateTimeImmutable $date,
    ): FocusStatisticsDto;

    public function monthly(
        UserId $userId,
        DateTimeImmutable $date,
    ): FocusStatisticsDto;

//    public function heatmap(
//        UserId $userId,
//        DateTimeImmutable $from,
//        DateTimeImmutable $to,
//    ): FocusHeatmapDto;
//
//    public function trend(
//        UserId $userId,
//    ): FocusTrendDto;
}
