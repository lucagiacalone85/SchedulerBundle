<?php

namespace Jackal\Scheduler\Bundle\Queue;

use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\Process\Process;

class CommandQueue
{
    /**
     * @var string
     */
    private $kernelRootDir;

    /**
     * @var Logger
     */
    private $logger;

    function __construct($kernelRootDir,Logger $logger)
    {
        $this->logger = $logger;
        $this->kernelRootDir = $kernelRootDir;
    }

    public function enqueue($processName){

        $this->logger->addDebug(sprintf('Enqueue %s',$processName));
        $process = new Process(sprintf('%s %s %s %s',
            'php',
            'console',
            'jackal:process:container',
            $processName
        ),$this->kernelRootDir);
        $process->start();
    }
}