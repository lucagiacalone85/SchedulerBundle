<?php

namespace Jackal\Scheduler\Bundle\Tests\Cron;

use Jackal\Scheduler\Bundle\Cron\Cron;

class CronWeekDaysTest extends BaseCronTest
{
    /**
     * @test
     * @dataProvider getValidDateTimes()
     */
    public function itShouldWakeUp($className, $hour, \DateTime $dateTime)
    {
        $cron = Cron::$className($hour);
        $this->assertValidDateTime($cron, $dateTime);
    }

    public function getValidDateTimes()
    {
        return [
            ['everyMondayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-27 01:00:00')],
            ['everyTuesdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-28 01:00:00')],
            ['everyWednesdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-29 01:00:00')],
            ['everyThursdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-30 01:00:00')],
            ['everyFridayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-31 01:00:00')],
            ['everySaturdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-08-01 01:00:00')],
            ['everySundayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-08-02 01:00:00')],
        ];
    }

    /**
     * @test
     * @dataProvider getInvalidDateTimes()
     */
    public function itShouldNotWakeUp($className, $hour, \DateTime $dateTime)
    {
        $cron = Cron::$className($hour);
        $this->assertInvalidDateTime($cron, $dateTime);
    }

    public function getInvalidDateTimes()
    {
        return [

            ['EveryMondayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-26 01:00:00')],
            ['EveryMondayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-27 02:00:00')],
            ['EveryMondayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-27 01:00:01')],

            ['EveryTuesdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-27 01:00:00')],
            ['EveryTuesdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-28 02:00:00')],
            ['EveryTuesdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-28 01:00:01')],

            ['EveryWednesdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-28 01:00:00')],
            ['EveryWednesdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-29 02:00:00')],
            ['EveryWednesdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-29 01:00:01')],

            ['EveryThursdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-29 01:00:00')],
            ['EveryThursdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-30 02:00:00')],
            ['EveryThursdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-30 01:00:01')],

            ['EveryFridayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-30 01:00:00')],
            ['EveryFridayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-31 02:00:00')],
            ['EveryFridayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-31 01:00:01')],

            ['EverySaturdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-31 01:00:00')],
            ['EverySaturdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-08-01 02:00:00')],
            ['EverySaturdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-08-01 01:00:01')],

            ['EverySundayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-08-01 01:00:00')],
            ['EverySundayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-08-02 02:00:00')],
            ['EverySundayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-08-02 01:00:01')],
        ];
    }
}
