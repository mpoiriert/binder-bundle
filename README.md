binder-bundle
=============

[![Build Status](https://api.travis-ci.org/mpoiriert/binder-bundle.png?branch=master)](http://travis-ci.org/mpoiriert/binder-bundle)

A Symfony bundle to use the binder library.

The main purpose is to hide the usage of the session to the user (developer).

To use it in your application you must register 2 bundles since there is a dependency on [nucleus-bundle](https://github.com/mpoiriert/nucleus-bundle).

    <?php

    // in AppKernel::registerBundles()
    $bundles = array(
        // ...
        new Nucleus\Bundle\CoreBundle\NucleusCoreBundle(),
        new Nucleus\Bundle\BinderBundle\NucleusBinderBundle(),
        // ...
    );

The system does use the [kernel.terminate](http://symfony.com/doc/current/components/http_kernel/introduction.html)
event to work. Don't forget to use the [Symfony/Component/HttpKernel/TerminableInterface](http://api.symfony.com/2.4/Symfony/Component/HttpKernel/TerminableInterface.html)
on your kernel.

In any service you can put a annotation above a property and this property will be automatically save to the session and
restore on the next call.

    <?php

    class TheService
    {
        /**
         * @\Nucleus\Binder\Bounding
         */
        protected $variable = 'default';

        public function getVariable()
        {
            return $this->variable;
        }

        public function setVariable($value)
        {
            $this->variable = $value;
        }

        //...
    }

That's all !!

The default value of the property will be use if the proper variable in not available in the Binder service.

By calling the TheService::setVariable() the value will be change and at the end of the request on kernel.terminate.

If you need to access the value of this variable in "AnotherService" you need to inject "TheService" in "AnotherService"
and call the TheService::getVariable(). The service who have the Bounded property is in charge of all the access to it.

This approach also help for unit test since you don't need to use the session anymore. It also force to have a separation
of concern in your service since no other service can change the value in the session by manipulating it directly since
it's inner working are hidden.