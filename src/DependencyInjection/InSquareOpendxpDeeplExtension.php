<?php

declare(strict_types=1);

namespace InSquare\OpendxpDeeplBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class InSquareOpendxpDeeplExtension extends Extension
{
    public function getAlias(): string
    {
        return 'in_square_opendxp_deepl';
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('in_square_opendxp_deepl.overwrite.documents', (bool) $config['overwrite']['documents']);
        $container->setParameter('in_square_opendxp_deepl.overwrite.objects', (bool) $config['overwrite']['objects']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }
}
