<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 19:26
 */

namespace Jackal\SchedulerBundle\Tests\Cron;


use Jackal\SchedulerBundle\Cron\CronEveryDayAt;

class CronEveryDayAtTest extends BaseCronTest implements BaseCronTestInterface
{
    /**
     * @dataProvider getValidDateTimes()
     */
    public function itShouldWakeUp($hour,\DateTime $dateTime){

        $cron = new CronEveryDayAt($hour);
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

        $cron = new CronEveryDayAt($hour);
        $this->assertInvalidDateTime($cron,$dateTime);
    }

    public function getInvalidDateTimes(){
        return [
            [5,\DateTime::createFromFormat('Y-m-d H:i:s','2013-01-01 04:01:00')],
            [5,\DateTime::createFromFormat('Y-m-d H:i:s','2013-01-01 04:59:00')],
            [5,\DateTime::createFromFormat('Y-m-d H:i:s','2013-01-01 05:01:00')],
            [3,\DateTime::createFromFormat('Y-m-d H:i:s','2013-01-01 15:00:00')],
        ];
    }
}