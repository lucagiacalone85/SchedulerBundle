<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 19:55
 */

namespace Jackal\Scheduler\Bundle\Tests\Cron;


use Jackal\Scheduler\Bundle\Cron\CronEveryHour;

class CronEveryHourTest extends BaseCronTest
{


    /**
     * @test
     * @dataProvider getValidDateTimes()
     */
    public function itShouldWakeUp($hour, \DateTime $dateTime)
    {
        $cron = new CronEveryHour();
        $this->assertValidDateTime($cron,$dateTime);
    }

    public function getValidDateTimes()
    {
        $dates = [];

        for($i=0;$i<=23;$i++){
            $dates[] = [$i,\DateTime::createFromFormat('Y-m-d H:i:s',sprintf('2013-01-01 %s:00:00',str_pad($i,2,'0')))];
        }
        return $dates;
    }

    /**
     * @test
     * @dataProvider getInvalidDateTimes()
     */
    public function itShouldNotWakeUp($hour, \DateTime $dateTime)
    {
        $cron = new CronEveryHour();
        $this->assertInvalidDateTime($cron,$dateTime);
    }

    public function getInvalidDateTimes()
    {
        $dates = [];

        for($i=0;$i<=23;$i++){
            $dates[] = [$i,\DateTime::createFromFormat('Y-m-d H:i:s',sprintf('2013-01-01 %s:01:00',str_pad($i,2,'0')))];
            $dates[] = [$i,\DateTime::createFromFormat('Y-m-d H:i:s',sprintf('2013-01-01 %s:01:01',str_pad($i,2,'0')))];
            $dates[] = [$i,\DateTime::createFromFormat('Y-m-d H:i:s',sprintf('2013-01-01 %s:00:50',str_pad($i,2,'0')))];
        }
        return $dates;
    }
}