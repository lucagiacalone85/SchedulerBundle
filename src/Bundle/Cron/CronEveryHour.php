<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 17:39
 */

namespace Jackal\SchedulerBundle\Cron;


class CronEveryHour extends Cron
{
    public function __construct()
    {
        parent::__construct(0,0, null, null, null, null);
    }
}