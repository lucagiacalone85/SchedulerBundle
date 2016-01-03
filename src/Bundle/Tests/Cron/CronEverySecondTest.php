<?php

namespace Jackal\Scheduler\Bundle\Tests\Cron;

use Jackal\Scheduler\Bundle\Cron\Cron;

class CronEverySecondTest extends BaseCronTest
{

    /**
     * @test
     * @dataProvider getValidDateTimes()
     */
    public function itShouldWakeUp(\DateTime $dateTime)
    {
        $cron = Cron::EverySecond();
        $this->assertValidDateTime($cron,$dateTime);
    }

    public function getValidDateTimes()
    {
        $dates = [];

            for($minute=0;$minute<=59;$minute++){
                for($second=0;$second<=59;$second++) {
                    $dates[] = [\DateTime::createFromFormat('Y-m-d H:i:s', sprintf('2013-01-01 00:%s:%s', str_pad($minute, 2, '0'), str_pad($second, 2, '0')))];
                }
            }

        return $dates;
    }
}