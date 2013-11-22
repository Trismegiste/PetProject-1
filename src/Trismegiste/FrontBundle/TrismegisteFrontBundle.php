<?php

namespace Trismegiste\FrontBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Trismegiste\FrontBundle\DependencyInjection\CompilerPass\HistoryInjection;

class TrismegisteFrontBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new HistoryInjection());
    }

}
