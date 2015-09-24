<?php
/**
 * Created by PhpStorm.
 * User: lucagiacalone
 * Date: 02/08/15
 * Time: 13:41
 */

namespace Jackal\Scheduler\Bundle\Processor;


use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\Process\Process;

class ProcessQueue
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