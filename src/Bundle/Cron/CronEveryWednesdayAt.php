<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 23:00
 */

namespace Jackal\SchedulerBundle\Cron;


class CronEveryWednesdayAt extends Cron
{
    /**
     * @param $hour
     */
    public function __construct($hour)
    {
        parent::__construct(0, 0, $hour, null, null, CronDay::Wednesday());
    }
}