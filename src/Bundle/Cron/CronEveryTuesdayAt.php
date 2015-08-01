<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 22:58.
 */

namespace Jackal\Scheduler\Bundle\Cron;

class CronEveryTuesdayAt extends Cron
{
    /**
     * @param $hour
     */
    public function __construct($hour)
    {
        parent::__construct(0, 0, $hour, null, null, CronDay::Tuesday());
    }
}
