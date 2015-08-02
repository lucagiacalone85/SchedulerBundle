<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 02/08/15
 * Time: 14:00
 */

namespace Jackal\Scheduler\Bundle\Command;

use Symfony\Bridge\Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class ProcessContainerCommand extends ContainerAwareCommand
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName('jackal:process:container')->addArgument('command_name',InputArgument::REQUIRED);
    }

    /**
     * Executes the current command.
     *
     * This method is not abstract because you can use this class
     * as a concrete class. In this case, instead of defining the
     * execute() method, you set the code to execute by passing
     * a Closure to the setCode() method.
     *
     * @param InputInterface $input An InputInterface instance
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
        /** @var Logger $logger */
        $logger = $this->getContainer()->get('logger');
        $formatter = $this->getHelper('formatter');
        $processName = $input->getArgument('command_name');

        $process = new Process('php console '.$processName,$this->getContainer()->getParameter('kernel.root_dir'));
        $process->start();

        $processPid = $process->getPid();
        $logger->addDebug(sprintf('TEST - Executing %s - PID %s', $processName,$processPid));

        while($process->isRunning()){

        }

        if($process->isSuccessful()){
            $logger->addDebug('TEST - TUTTO OK'.$process->getOutput());
        }else{
            $logger->addDebug('TEST - ERRORE! '.$process->getErrorOutput());
        }






    }


}