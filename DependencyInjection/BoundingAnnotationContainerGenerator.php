<?php

namespace Nucleus\Bundle\BinderBundle\DependencyInjection;

use Nucleus\Binder\Bounding;
use Nucleus\Binder\IBinder;
use Nucleus\Bundle\CoreBundle\DependencyInjection\IAnnotationContainerGenerator;
use Nucleus\Bundle\CoreBundle\DependencyInjection\GenerationContext;
use Nucleus\Bundle\CoreBundle\DependencyInjection\Definition;

class BoundingAnnotationContainerGenerator implements IAnnotationContainerGenerator
{
    public function processContainerBuilder(GenerationContext $context)
    {
        $definition = $context->getServiceDefinition();
        $serviceName = $context->getServiceName();
        $annotation = $context->getAnnotation();

        /* @var $annotation \Nucleus\Binder\Bounding */
        $code = Definition::getCodeInitalization($definition);

        $annotation->scope;

        if(!is_null($annotation->variableName)) {
            $variableName = $annotation->variableName;
        } else {
            $variableName = $context->getParsingContextName();
        }

        if(!is_null($annotation->namespace)) {
            $namespace = $annotation->namespace;
        } else {
            $namespace = $serviceName;
        }

        $scope = $annotation->scope;

        $serviceBinderAssignation = '
    $sessionServiceBinder = $serviceContainer->get("' . IBinder::NUCLEUS_SERVICE_NAME . '");
';
        if (strpos($code, $serviceBinderAssignation) === false) {
            $code .= $serviceBinderAssignation;
        }
        $code .= '
    $sessionServiceBinder->restore($service,"' . $variableName . '","' . $namespace . '","' . $scope . '");
';

        Definition::setCodeInitialization($definition,$code);
    }
}