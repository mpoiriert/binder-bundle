<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Martin
 * Date: 14-01-29
 * Time: 13:42
 * To change this template use File | Settings | File Templates.
 */

namespace Nucleus\Bundle\BinderBundle\Tests\DependencyInjection;

use Nucleus\Bundle\BinderBundle\DependencyInjection\NucleusBinderExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class NucleusBinderExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testDefault()
    {
        $container = new ContainerBuilder();
        $loader = new NucleusBinderExtension();
        $loader->load(array(array()), $container);

        $this->assertTrue($container->hasDefinition('nucleus.binder'), 'Nucleus binder is not loaded');
    }
}