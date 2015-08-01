<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 20:11
 */

namespace Jackal\Scheduler\Bundle\Tests\Cron;


use Jackal\Scheduler\Bundle\Cron\CronEveryMinute;

class CronEveryMinuteTest extends BaseCronTest
{

    /**
     * @test
     * @dataProvider getValidDateTimes()
     */
    public function itShouldWakeUp($hour, \DateTime $dateTime)
    {
        $cron = new CronEveryMinute();
        $this->assertValidDateTime($cron,$dateTime);
    }

    public function getValidDateTimes()
    {
        $dates = [];

        for($i=0;$i<=23;$i++){
            for($minute=0;$minute<=59;$minute++){
                $dates[] = [$minute,\DateTime::createFromFormat('Y-m-d H:i:s',sprintf('2013-01-01 %s:%s:00',str_pad($i,2,'0'),str_pad($minute,2,'0')))];
            }
        }

        return $dates;
    }

    /**
     * @test
     * @dataProvider getInvalidDateTimes()
     */
    public function itShouldNotWakeUp($hour, \DateTime $dateTime)
    {
        $cron = new CronEveryMinute();
        $this->assertInvalidDateTime($cron,$dateTime);
    }

    public function getInvalidDateTimes()
    {
        $dates = [];

        for($i=0;$i<=23;$i++){
            $dates[] = [$i,\DateTime::createFromFormat('Y-m-d H:i:s',sprintf('2013-01-01 %s:01:01',str_pad($i,2,'0')))];
            $dates[] = [$i,\DateTime::createFromFormat('Y-m-d H:i:s',sprintf('2013-01-01 %s:00:59',str_pad($i,2,'0')))];
        }
        return $dates;
    }
}