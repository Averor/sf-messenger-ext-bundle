<?php declare(strict_types=1);

namespace Averor\Messenger\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\{
    ContainerBuilder,
    Extension\Extension,
    Loader\XmlFileLoader
};

class BundleExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader(
            $container,
            new FileLocator(dirname(__DIR__) . '/Resources/config')
        );

        $loader->load('services.xml');
    }
}
