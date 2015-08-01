<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 20:15
 */

namespace Jackal\SchedulerBundle\Cron;


class CronEverySecond extends Cron
{
    public function __construct()
    {
        parent::__construct(null, null, null, null, null, null);
    }
}