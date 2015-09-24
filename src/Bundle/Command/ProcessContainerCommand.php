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
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
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
        $this->logger->debug(sprintf('Executing %s - PID %s', $processName, $processPid));

        while ($process->isRunning()) {
        }

        if ($process->isSuccessful()) {
            $this->logger->debug(sprintf('Executed %s - PID %s',$processName, $processPid));
        } else {
            $this->logger->debug(sprintf('ERROR - %s: %s',$processName,$process->getErrorOutput()));
        }
    }
}
