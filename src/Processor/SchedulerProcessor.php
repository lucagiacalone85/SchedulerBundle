<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 17:15.
 */

namespace Jackal\SchedulerBundle\Processor;

use Jackal\SchedulerBundle\Action\ScheduledAction;

class SchedulerProcessor
{
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
            $list[] = get_class($action);

            return $list;
        }, []);
    }

    public function run()
    {
        foreach ($this->actions as $action) {
            if ($action->isTimeToWakeUp()) {
                $action->getName();
            }
        }
    }
}
