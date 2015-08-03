<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 17:15.
 */

namespace Jackal\Scheduler\Bundle\Processor;

use Jackal\Scheduler\Bundle\Action\ScheduledAction;
use Symfony\Component\HttpFoundation\ParameterBag;


class SchedulerProcessor
{
    /**
     * @var ProcessQueue
     */
    private $processQueue;

    function __construct(ProcessQueue $processQueue)
    {
        $this->processQueue = $processQueue;
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

    public function run($commandName = null)
    {
        while(true) {
            foreach ($this->actions as $action) {
                if ($action->isTimeToWakeUp() and ($commandName === null or $action->getName() == $commandName)) {
                    $this->processQueue->enqueue($action->getName());
                }
            }
            sleep(1);
        }
    }
}
