<?php

namespace Nucleus\Bundle\BinderBundle;

use Nucleus\Binder\Bounding;
use Nucleus\Binder\IBinder;
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

        if(!is_null($annotation->namespace)) {
            $namespace = $annotation->namespace;
        } else {
            $namespace = $serviceName;
        }

        $scope = $annotation->scope;

        $serviceBinderAssignation = '
    $sessionServiceBinder = $serviceContainer->getServiceByName("' . IBinder::NUCLEUS_SERVICE_NAME . '");
';
        if (strpos($code, $serviceBinderAssignation) === false) {
            $code .= $serviceBinderAssignation;
        }
        $code .= '
    $sessionServiceBinder->restore($service,"' . $variableName . '","' . $namespace . '","' . $scope . '");
';

        \Nucleus\Bundle\CoreBundle\Definition::setCodeInitialization($definition,$code);
    }
}