<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 17:15.
 */

namespace Jackal\Scheduler\Bundle\Processor;

use Jackal\Scheduler\Bundle\Action\ScheduledAction;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

class SchedulerProcessor
{
    /**
     * @var ProcessQueue
     */
    private $processQueue;

    public function __construct(ProcessQueue $processQueue)
    {
        $this->processQueue = $processQueue;
    }

    /**
     * @var ScheduledAction[]
     */
    private $actions = [];

    public function addScheduledAction(ScheduledAction $action)
    {
        $this->actions[$action->getName()] = $action;
    }

    public function getActionsList()
    {
        return array_reduce($this->actions, function ($list, ScheduledAction $action) {
            $list[] = new ParameterBag([
                'class' => get_class($action),
                'name'  => $action->getName(),
                'schedule' => $action->getScheduleDescription(),
            ]);

            return $list;
        }, []);
    }

    public function isRegistered($commandName){
        return in_array($commandName,array_keys($this->actions));
    }

    public function run($commandName = null)
    {
        for($i=0;$i<60;$i++){
            foreach ($this->actions as $action) {
                if ($action->isTimeToWakeUp() and ($commandName === null or $action->getName() == $commandName)) {
                    $this->processQueue->enqueue($action->getName());
                }
            }
            sleep(1);
        }
    }

    public function dumpTitle(OutputInterface $output){
        $output->writeln("       _            _         _    _____      _              _       _             _____
      | |          | |       | |  / ____|    | |            | |     | |           |  __ \
      | | __ _  ___| | ____ _| | | (___   ___| |__   ___  __| |_   _| | ___ _ __  | |__) |   _ _ __  _ __   ___ _ __
  _   | |/ _` |/ __| |/ / _` | |  \___ \ / __| '_ \ / _ \/ _` | | | | |/ _ \ '__| |  _  / | | | '_ \| '_ \ / _ \ '__|
 | |__| | (_| | (__|   < (_| | |  ____) | (__| | | |  __/ (_| | |_| | |  __/ |    | | \ \ |_| | | | | | | |  __/ |
  \____/ \__,_|\___|_|\_\__,_|_| |_____/ \___|_| |_|\___|\__,_|\__,_|_|\___|_|    |_|  \_\__,_|_| |_|_| |_|\___|_|

                                                                                                                     ");
    }

    public function dumpHelp(OutputInterface $output){
        $output->writeln('Add this line to your crontab file');
        $output->writeln('* * * * * {user} {path-to-your-app}/app/console jackal:scheduler:runner');
    }

    public function dumpActionsList(OutputInterface $output)
    {
        $output->writeln(str_pad('-', 107, '-'));
        $output->writeln(sprintf('| %s| %s| %s|', str_pad('name', 30), str_pad('class', 50), str_pad('schedule', 20)));
        $output->writeln(str_pad('-', 107, '-'));
        foreach ($this->getActionsList() as $action) {
            /* @var ParameterBag $action */
            $output->writeln(sprintf('| %s| %s| %s|',
                str_pad($action->get('name'), 30),
                str_pad($action->get('class'), 50),
                str_pad($action->get('schedule'), 20)
            ));
        }
        $output->writeln(str_pad('-', 107, '-'));
    }
}
