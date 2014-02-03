<?php

namespace Nucleus\Bundle\BinderBundle;

use Nucleus\Binder\Bounding;
use Nucleus\Bundle\CoreBundle\Annotation\IAnnotationContainerGenerator;
use Nucleus\Bundle\CoreBundle\GenerationContext;

class BoundingAnnotationContainerGenerator implements IAnnotationContainerGenerator
{
    public function processContainerBuilder(GenerationContext $context)
    {
        $definition = $context->getServiceDefinition();
        $serviceName = $context->getServiceName();
        $annotation = $context->getAnnotation();

        /* @var $annotation \Nucleus\Binder\Bounding */
        $code = \Nucleus\Bundle\CoreBundle\Definition::getCodeInitalization($definition);

        $annotation->scope;

        if(!is_null($annotation->variableName)) {
            $variableName = $annotation->variableName;
        } else {
            $variableName = $context->getParsingContextName();
        }

        if(!is_null($annotation->scope)) {
            $scope = $annotation->scope;
        } else {
            $scope = $serviceName;
        }

        $namespace = $annotation->namespace;

        $serviceBinderAssignation = '
    $sessionServiceBinder = $serviceContainer->getServiceByName("sessionServiceBinder");
';
        if (strpos($code, $serviceBinderAssignation) === false) {
            $code .= $serviceBinderAssignation;
        }
        $code .= '
    $sessionServiceBinder->restore($service,"' . $variableName . '","' . $scope . '","' . $namespace . '");
';

        \Nucleus\Bundle\CoreBundle\Definition::setCodeInitialization($definition,$code);
    }
}