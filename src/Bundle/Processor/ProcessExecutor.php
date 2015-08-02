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

class ProcessExecutor
{

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var string
     */
    private $kernelRootDir;

    function __construct(Logger $logger,$kernelRootDir)
    {
        $this->logger = $logger;
        $this->kernelRootDir = $kernelRootDir;
    }

    public function enqueue($processName){
        $process = new Process('php console jackal:process:container '.$processName,$this->kernelRootDir);
        $process->start();
    }
}