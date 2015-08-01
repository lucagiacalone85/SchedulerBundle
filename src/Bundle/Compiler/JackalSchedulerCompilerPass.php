<?php

namespace Jackal\Scheduler\Bundle\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class JackalSchedulerCompilerPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition(
            'jackal_scheduler.processor'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'jackal_scheduler.command'
        );
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                'addScheduledAction',
                array(new Reference($id))
            );
        }
    }
}