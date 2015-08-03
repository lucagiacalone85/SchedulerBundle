<?php

namespace Jackal\Scheduler\Bundle;

use Jackal\Scheduler\Bundle\Compiler\JackalSchedulerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class JackalSchedulerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new JackalSchedulerCompilerPass());
        
    }
}