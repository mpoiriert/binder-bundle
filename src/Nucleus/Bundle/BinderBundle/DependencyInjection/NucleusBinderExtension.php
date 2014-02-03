<?php

namespace Nucleus\Bundle\BinderBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use \Symfony\Component\HttpKernel\DependencyInjection\Extension;
use \Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use \Symfony\Component\DependencyInjection\ContainerBuilder;
use \Symfony\Component\Config\FileLocator;

class NucleusBinderExtension extends Extension implements PrependExtensionInterface
{
    /**
     * Handles the knp_menu configuration.
     *
     * @param array            $configs   The configurations being loaded
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $fileLocator = new FileLocator(__DIR__.'/../Resources/config');
        $loader = new XmlFileLoader($container, $fileLocator);
        $loader->load('binder.xml');
    }

    public function getAlias()
    {
        return 'nucleus_binder';
    }

    /**
     * Allow an extension to prepend the extension configurations.
     *
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig(
            'nucleus_core',
            array(
                'annotation_container_generators' => array(
                    'bound' => array(
                        'annotationClass' => 'Nucleus\Binder\Bound',
                        'generatorClass' => 'Nucleus\Bundle\BinderBundle\BoundingAnnotationContainerGenerator'
                    ),
                )
            )
        );
    }
}