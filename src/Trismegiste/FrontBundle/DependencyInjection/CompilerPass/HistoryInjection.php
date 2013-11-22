<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * HistoryInjection injects the history stack in the session
 */
class HistoryInjection implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        $def = $container->getDefinition('session');
        $def->addMethodCall('registerBag', [new Reference('front.history')]);
    }

}