<?php

namespace Jackal\Scheduler\Bundle\Command;

use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class ProcessContainerCommand extends ContainerAwareCommand
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var string
     */
    private $kernelRootDir;

    public function __construct(Logger $logger,$kernelRootDir)
    {
        $this->logger = $logger;
        $this->kernelRootDir = $kernelRootDir;
        parent::__construct();
    }

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName('jackal:process:container')->addArgument('command_name', InputArgument::REQUIRED);
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
        $processName = $input->getArgument('command_name');

        $process = new Process(
            sprintf('%s', implode(['php', 'console', $processName], ' ')),
            $this->kernelRootDir
        );
        $process->start();

        $processPid = $process->getPid();
        $this->logger->addDebug(sprintf('Executing %s - PID %s', $processName, $processPid));

        while ($process->isRunning()) {
        }

        if ($process->isSuccessful()) {
            $this->logger->addDebug(sprintf('%s - Executed',$process->getOutput()));
        } else {
            $this->logger->addError(sprintf('%s - ERROR: %s',$processName,$process->getErrorOutput()));
        }
    }
}
