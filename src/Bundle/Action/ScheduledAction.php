<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 23:27.
 */

namespace Jackal\Scheduler\Bundle\Action;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

abstract class ScheduledAction extends ContainerAwareCommand implements ScheduledActionInterface
{
    /**
     * @return bool
     */
    public function isTimeToWakeUp()
    {
        return $this->getScheduleCron()->isTimeToWakeUp();
    }

    public function getScheduleDescription()
    {
        return (string) $this->getScheduleCron();
    }
}
