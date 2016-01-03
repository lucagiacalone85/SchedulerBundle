<?php

namespace Jackal\Scheduler\Bundle\Manager;

use Jackal\Scheduler\Bundle\Model\ScheduledCommand;
use Jackal\Scheduler\Bundle\Queue\CommandQueue;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

class ScheduledCommandManager
{
    /**
     * @var CommandQueue
     */
    private $queue;

    public function __construct(CommandQueue $queue)
    {
        $this->queue = $queue;
    }

    /**
     * @var ScheduledCommand[]
     */
    private $commands = [];

    public function addScheduledCommand(ScheduledCommand $command)
    {
        $this->commands[$command->getName()] = $command;
    }

    public function getCommandsList()
    {
        return array_reduce($this->commands, function ($list, ScheduledCommand $command) {
            $list[] = new ParameterBag([
                'class' => get_class($command),
                'name'  => $command->getName(),
                'schedule' => (string)$command->getScheduleCron(),
                'next' => $command->getNextExecutionTime()
            ]);

            return $list;
        }, []);
    }

    public function isRegistered($commandName){
        return in_array($commandName,array_keys($this->commands));
    }

    public function run(OutputInterface $output, $commandName = null)
    {
        for($i=0;$i<60;$i++){
            foreach ($this->commands as $command) {
                if ($command->getScheduleCron()->isTimeToWakeUp() and ($commandName === null or $command->getName() == $commandName)) {
                    $output->writeln(sprintf('<info>WAKE UP: %s</info>',$command->getName()));
                    $this->queue->enqueue($command->getName());
                }
            }
            sleep(1);
        }
    }
}
