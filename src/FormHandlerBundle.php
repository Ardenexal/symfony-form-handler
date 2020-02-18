<?php

namespace Ardenexal\FormHandler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FormHandlerBundle extends Bundle
{
public function build(ContainerBuilder $container)
{
    parent::build($container);
    $container->addCompilerPass(new DependencyInjection\Compiler\FormHandlerCompiler());
}
}