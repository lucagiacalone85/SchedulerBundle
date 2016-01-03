<?php

namespace Jackal\Scheduler\Bundle\Tests\Cron;

use Jackal\Scheduler\Bundle\Cron\Cron;

class CronEveryDayAtTest extends BaseCronTest
{
    /**
     * @dataProvider getValidDateTimes()
     */
    public function itShouldWakeUp($hour,\DateTime $dateTime){

        $cron = Cron::everyDayAt($hour);
        $this->assertValidDateTime($cron,$dateTime);
    }

    public function getValidDateTimes(){
        return [
            [5,\DateTime::createFromFormat('Y-m-d H:i:s','2013-01-01 05:00:00')],
            [3,\DateTime::createFromFormat('Y-m-d H:i:s','2013-01-01 15:00:00')],
        ];
    }

    /**
     * @test
     * @dataProvider getInvalidDateTimes()
     */
    public function itShouldNotWakeUp($hour,\DateTime $dateTime){

        $cron = Cron::everyDayAt($hour);
        $this->assertInvalidDateTime($cron,$dateTime);
    }

    public function getInvalidDateTimes(){
        return [
            [5,\DateTime::createFromFormat('Y-m-d H:i:s','2013-01-01 04:01:00')],
            [4,\DateTime::createFromFormat('Y-m-d H:i:s','2013-01-01 04:00:01')],
            [5,\DateTime::createFromFormat('Y-m-d H:i:s','2013-01-01 04:59:00')],
            [5,\DateTime::createFromFormat('Y-m-d H:i:s','2013-01-01 05:01:00')],
            [3,\DateTime::createFromFormat('Y-m-d H:i:s','2013-01-01 15:00:00')],
        ];
    }
}