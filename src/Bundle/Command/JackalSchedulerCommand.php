<?php

namespace Jackal\Scheduler\Bundle\Command;

use Jackal\Scheduler\Bundle\Processor\SchedulerProcessor;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 17:11.
 */
class JackalSchedulerCommand extends ContainerAwareCommand
{
    /**
     * @var SchedulerProcessor
     */
    private $schedulerProcessor;

    public function __construct(SchedulerProcessor $schedulerProcessor)
    {
        $this->schedulerProcessor = $schedulerProcessor;
        parent::__construct();
    }

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName('jackal:scheduler:runner')->addArgument('command_name',InputArgument::OPTIONAL)->addOption('list');
    }

    /**
     * Executes the current command.
     *
     * This method is not abstract because you can use this class
     * as a concrete class. In this case, instead of defining the
     * execute() method, you set the code to execute by passing
     * a Closure to the setCode() method.
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @return null|int null or 0 if everything went fine, or an error code
     *
     * @throws \LogicException When this abstract method is not implemented
     *
     * @see setCode()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ([] == $this->schedulerProcessor->getActionsList()) {
            $output->writeln('<error>No Command registered</error>');
        }

        if ($input->getOption('list')) {
            $this->schedulerProcessor->dumpActionsList($output);
        } else {
            $commandName = $input->getArgument('command_name') ? $input->getArgument('command_name') : null;
            if(!$commandName and $this->schedulerProcessor->isRegistered($commandName)){
                throw new \Exception(sprintf('command with name \'%s\' is not registered to scheduler',$commandName));
            }
            $this->schedulerProcessor->run($commandName);
        }
    }
}
