<?php

namespace Jackal\Scheduler\Bundle\Tests\Cron;

interface BaseCronTestInterface
{
    /**
     * @test
     * @dataProvider getValidDateTimes()
     */
    public function itShouldWakeUp($hour,\DateTime $dateTime);
    public function getValidDateTimes();

    /**
     * @test
     * @dataProvider getInvalidDateTimes()
     */
    public function itShouldNotWakeUp($hour,\DateTime $dateTime);
    public function getInvalidDateTimes();
}