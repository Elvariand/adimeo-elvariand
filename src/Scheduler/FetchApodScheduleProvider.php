<?php

namespace App\Scheduler;

use App\Message\FetchApodMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
// ...

#[AsSchedule('Apod')]
class FetchApodScheduleProvider implements ScheduleProviderInterface
{
    public function getSchedule(): Schedule
    {
        return (new Schedule())->add(
            RecurringMessage::every('1 day', new FetchApodMessage(), from: new \DateTimeImmutable('8:00', new \DateTimeZone('Europe/Paris')))
        );
    }
}