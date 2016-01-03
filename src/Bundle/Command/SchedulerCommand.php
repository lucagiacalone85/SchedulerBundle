<?php

namespace Jackal\Scheduler\Bundle\Command;

use Jackal\Scheduler\Bundle\Manager\ScheduledCommandManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

class SchedulerCommand extends ContainerAwareCommand
{
    /**
     * @var ScheduledCommandManager
     */
    private $scheduledCommandManager;

    public function __construct(ScheduledCommandManager $scheduledCommandManager)
    {
        $this->scheduledCommandManager = $scheduledCommandManager;
        parent::__construct();
    }

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName('jackal:scheduler:runner')
             ->addArgument('command_name', InputArgument::OPTIONAL)
             ->addOption('list',null,null,'Display all registered command to execute');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ([] == $this->scheduledCommandManager->getCommandsList()) {
            $output->writeln('<error>No Command registered</error>');
        }

        if ($input->getOption('list')) {
            $output->writeln(str_pad('-', 128, '-'));
            $output->writeln(sprintf('| %s| %s| %s| %s|',
                str_pad('name', 30),
                str_pad('class', 50),
                str_pad('schedule', 20),
                str_pad('next', 20)
            ));
            $output->writeln(str_pad('-', 128, '-'));
            foreach ($this->scheduledCommandManager->getCommandsList() as $action) {
                /* @var ParameterBag $action */
                $output->writeln(sprintf('| %s| %s| %s| %s|',
                    str_pad($action->get('name'), 30),
                    str_pad($action->get('class'), 50),
                    str_pad($action->get('schedule'), 20),
                    str_pad($action->get('next')->format('Y-m-d H:i:s'), 20)
                ));
            }
            $output->writeln(str_pad('-', 128, '-'));


            return;
        }

        $commandName = $input->getArgument('command_name') ? $input->getArgument('command_name') : null;
        if (!$commandName and $this->scheduledCommandManager->isRegistered($commandName)) {
            throw new \Exception(sprintf('command with name \'%s\' is not registered to scheduler', $commandName));
        }
        $this->scheduledCommandManager->run($output,$commandName);
    }
}
