<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 17:15.
 */

namespace Jackal\Scheduler\Bundle\Processor;

use Jackal\Scheduler\Bundle\Action\ScheduledAction;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Process\Process;

class SchedulerProcessor
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var string
     */
    private $kernelRootDir;

    function __construct(Logger $logger,$kernelRootDir)
    {
        $this->logger = $logger;
        $this->kernelRootDir = $kernelRootDir;
    }


    /**
     * @var ScheduledAction[]
     */
    private $actions = [];

    public function addScheduledAction(ScheduledAction $action)
    {
        $this->actions[] = $action;
    }

    public function getActionsList()
    {
        return array_reduce($this->actions, function ($list, ScheduledAction $action) {
            $list[] = new ParameterBag([
                'class' => get_class($action),
                'name'  => $action->getName(),
                'schedule' => $action->getScheduleDescription()
            ]);
            return $list;
        }, []);
    }

    public function run()
    {
        while(true) {
            foreach ($this->actions as $action) {
                if ($action->isTimeToWakeUp()) {
                    $this->logger->addDebug(sprintf('Jackal Scheduler - Calling %s', $action->getName()));
                    $process = new Process('php console '.$action->getName(),$this->kernelRootDir);
                    $process->start();
                }
            }
            sleep(1);
        }
    }
}
