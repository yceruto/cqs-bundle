<?php

namespace Yceruto\CqsBundle;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Yceruto\CqsBundle\Controller\CommandAction;
use Yceruto\CqsBundle\Controller\CqsAction;
use Yceruto\CqsBundle\Controller\QueryAction;
use Yceruto\CqsBundle\DependencyInjection\Configurator\MessageHandlerConfigurator;

class CqsBundle extends AbstractBundle
{
    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->import('../config/definition.php');
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        MessageHandlerConfigurator::configure($builder);

        $builder->registerForAutoconfiguration(CommandAction::class)
            ->addTag('controller.service_arguments');
        $builder->registerForAutoconfiguration(QueryAction::class)
            ->addTag('controller.service_arguments');
        $builder->registerForAutoconfiguration(CqsAction::class)
            ->addTag('controller.service_arguments');

        if ($config['middleware']['doctrine']) {
            $container->import('../config/packages/doctrine.php');
        }

        $container->import('../config/services.php');
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
