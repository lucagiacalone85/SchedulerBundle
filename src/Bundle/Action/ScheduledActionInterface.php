<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 03/08/15
 * Time: 09:28
 */

namespace Jackal\Scheduler\Bundle\Action;

use Jackal\Scheduler\Bundle\Cron\Cron;

interface ScheduledActionInterface
{
    /**
     * @return Cron
     */
    public function getScheduleCron();
}