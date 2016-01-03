<?php

namespace Jackal\Scheduler\Bundle\Model;

use Jackal\Scheduler\Bundle\Cron\Cron;
use Jackal\Scheduler\Bundle\Cron\CronDay;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

abstract class ScheduledCommand extends ContainerAwareCommand
{
    /**
     * @return Cron
     */
    abstract function getScheduleCron();

    /**
     * @param \DateTime|null $startingFrom
     * @return \DateTime
     */
    public function getNextExecutionTime(\DateTime $startingFrom = null)
    {
        $dateTime = $startingFrom === null ? new \DateTime('now') : $startingFrom;

        $dateTime = $this->moveToDay($dateTime);

        $dateTime = $this->moveToHour($dateTime);

        while (!$this->getScheduleCron()->isTimeToWakeUp($dateTime)) {
            $dateTime = $dateTime->add(new \DateInterval('PT1S'));
        }

        return $dateTime;
    }

    /**
     * @param \DateTime $dateTime
     * @return \DateTime
     */
    private function moveToDay(\DateTime $dateTime)
    {
        if (null !== $this->getScheduleCron()->getDayOfWeek()) {
            $dateTime = $dateTime->setTime(0, 0, 0);
            while ((new CronDay($dateTime))->getDay() != $this->getScheduleCron()->getDayOfWeek()) {
                $dateTime = $dateTime->add(new \DateInterval('P1D'));
            }
        }

        return $dateTime;
    }

    /**
     * @param \DateTime $dateTime
     * @return \DateTime
     */
    private function moveToHour(\DateTime $dateTime){
        if(null !== $this->getScheduleCron()->getHour()){
            $dateTime = $dateTime->setTime(0, 0, 0);
            while ($this->getScheduleCron()->getHour() != $this->getScheduleCron()->getHour()) {
                $dateTime = $dateTime->add(new \DateInterval('PT1H'));
            }
        }

        return $dateTime;
    }
}
