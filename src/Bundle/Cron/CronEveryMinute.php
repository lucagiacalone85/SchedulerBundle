<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 17:38.
 */

namespace Jackal\SchedulerBundle\Cron;

class CronEveryMinute extends Cron
{
    public function __construct()
    {
        parent::__construct(0, null, null, null, null, null);
    }
}
