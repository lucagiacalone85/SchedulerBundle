<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 17:40.
 */

namespace Jackal\Scheduler\Bundle\Cron;

class CronEveryDayAt extends Cron
{
    /**
     * @param int $hour
     */
    public function __construct($hour)
    {
        parent::__construct(0,0, $hour, null, null, null);
    }
}
