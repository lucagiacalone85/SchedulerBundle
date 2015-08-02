<?php

namespace Jackal\Scheduler\Bundle\Command;

use Jackal\Scheduler\Bundle\Processor\SchedulerProcessor;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 31/07/15
 * Time: 17:11.
 */
class JackalSchedulerCommand extends ContainerAwareCommand
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName('jackal:scheduler:runner')->addOption('list');
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
        /** @var SchedulerProcessor $processor */
        $processor = $this->getContainer()->get('jackal_scheduler.processor');

        if ([] == $processor->getActionsList()) {
            $output->writeln('<error>No Command registered</error>');
        }

        if ($input->getOption('list')) {
            $output->writeln(str_pad('-', 107, '-'));
            $output->writeln(sprintf('| %s| %s| %s|', str_pad('name', 30), str_pad('class', 50), str_pad('schedule', 20)));
            $output->writeln(str_pad('-', 107, '-'));
            foreach ($processor->getActionsList() as $action) {
                /* @var ParameterBag $action */
                $output->writeln(sprintf('| %s| %s| %s|',
                    str_pad($action->get('name'), 30),
                    str_pad($action->get('class'), 50),
                    str_pad($action->get('schedule'), 20)
                ));
            }
            $output->writeln(str_pad('-', 107, '-'));
        } else {
            $processor->run();
        }
    }
}
