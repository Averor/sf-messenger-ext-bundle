<?php declare(strict_types=1);

namespace Averor\Messenger\DependencyInjection;

use Symfony\Component\{Config\FileLocator,
    DependencyInjection\ContainerBuilder,
    DependencyInjection\Loader\XmlFileLoader,
    HttpKernel\DependencyInjection\ConfigurableExtension
};

class BundleExtension extends ConfigurableExtension
{
    public function getAlias()
    {
        return 'averor_messenger';
    }

    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader(
            $container,
            new FileLocator(dirname(__DIR__) . '/Resources/config')
        );

        $loader->load('services.xml');
    }
}
