<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 23:04.
 */

namespace Jackal\SchedulerBundle\Tests\Cron;

class CronWeekDaysTest extends BaseCronTest
{
    /**
     * @test
     * @dataProvider getValidDateTimes()
     */
    public function itShouldWakeUp($className, $hour, \DateTime $dateTime)
    {
        $cron = new $className($hour);
        $this->assertValidDateTime($cron, $dateTime);
    }

    public function getValidDateTimes()
    {
        return [
            ['\Jackal\SchedulerBundle\Cron\CronEveryMondayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-27 01:00:00')],
            ['\Jackal\SchedulerBundle\Cron\CronEveryTuesdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-28 01:00:00')],
            ['\Jackal\SchedulerBundle\Cron\CronEveryWednesdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-29 01:00:00')],
            ['\Jackal\SchedulerBundle\Cron\CronEveryThursdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-30 01:00:00')],
            ['\Jackal\SchedulerBundle\Cron\CronEveryFridayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-31 01:00:00')],
            ['\Jackal\SchedulerBundle\Cron\CronEverySaturdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-08-01 01:00:00')],
            ['\Jackal\SchedulerBundle\Cron\CronEverySundayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-08-02 01:00:00')],
        ];
    }

    /**
     * @test
     * @dataProvider getInvalidDateTimes()
     */
    public function itShouldNotWakeUp($className, $hour, \DateTime $dateTime)
    {
        $cron = new $className($hour);
        $this->assertInvalidDateTime($cron, $dateTime);
    }

    public function getInvalidDateTimes()
    {
        return [

            ['\Jackal\SchedulerBundle\Cron\CronEveryMondayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-26 01:00:00')],
            ['\Jackal\SchedulerBundle\Cron\CronEveryMondayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-27 02:00:00')],
            ['\Jackal\SchedulerBundle\Cron\CronEveryMondayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-27 01:00:01')],

            ['\Jackal\SchedulerBundle\Cron\CronEveryTuesdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-27 01:00:00')],
            ['\Jackal\SchedulerBundle\Cron\CronEveryTuesdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-28 02:00:00')],
            ['\Jackal\SchedulerBundle\Cron\CronEveryTuesdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-28 01:00:01')],

            ['\Jackal\SchedulerBundle\Cron\CronEveryWednesdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-28 01:00:00')],
            ['\Jackal\SchedulerBundle\Cron\CronEveryWednesdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-29 02:00:00')],
            ['\Jackal\SchedulerBundle\Cron\CronEveryWednesdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-29 01:00:01')],

            ['\Jackal\SchedulerBundle\Cron\CronEveryThursdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-29 01:00:00')],
            ['\Jackal\SchedulerBundle\Cron\CronEveryThursdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-30 02:00:00')],
            ['\Jackal\SchedulerBundle\Cron\CronEveryThursdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-30 01:00:01')],

            ['\Jackal\SchedulerBundle\Cron\CronEveryFridayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-30 01:00:00')],
            ['\Jackal\SchedulerBundle\Cron\CronEveryFridayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-31 02:00:00')],
            ['\Jackal\SchedulerBundle\Cron\CronEveryFridayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-31 01:00:01')],

            ['\Jackal\SchedulerBundle\Cron\CronEverySaturdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-31 01:00:00')],
            ['\Jackal\SchedulerBundle\Cron\CronEverySaturdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-08-01 02:00:00')],
            ['\Jackal\SchedulerBundle\Cron\CronEverySaturdayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-08-01 01:00:01')],

            ['\Jackal\SchedulerBundle\Cron\CronEverySundayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-08-01 01:00:00')],
            ['\Jackal\SchedulerBundle\Cron\CronEverySundayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-08-02 02:00:00')],
            ['\Jackal\SchedulerBundle\Cron\CronEverySundayAt',1,\DateTime::createFromFormat('Y-m-d H:i:s', '2015-08-02 01:00:01')],
        ];
    }
}