<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 23:27.
 */

namespace Jackal\Scheduler\Bundle\Action;

use Jackal\Scheduler\Bundle\Cron\Cron;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

abstract class ScheduledAction extends ContainerAwareCommand
{
    /**
     * @var Cron
     */
    private $cron;

    public function __construct(Cron $cron)
    {
        $this->cron = $cron;
        parent::__construct(null);
    }

    /**
     * @return bool
     */
    public function isTimeToWakeUp()
    {
        return $this->cron->isTimeToWakeUp();
    }

    public function getScheduleDescription(){
        return (string) $this->cron;
    }


}
