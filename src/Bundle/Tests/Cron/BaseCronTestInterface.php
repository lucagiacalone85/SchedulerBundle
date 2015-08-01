<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 19:56
 */

namespace Jackal\SchedulerBundle\Tests\Cron;


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