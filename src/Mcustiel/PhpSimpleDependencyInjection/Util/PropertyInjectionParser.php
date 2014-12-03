<?php
namespace Mcustiel\PhpSimpleDependencyInjection\Util;

use Doctrine\Common\Annotations\AnnotationReader;
use Mcustiel\PhpSimpleDependencyInjection\Annotation\Inject;
use Mcustiel\PhpSimpleDependencyInjection\DependencyContainer;

class PropertyInjectionParser
{
    private $annotationReader;
    private $container;

    public function __construct()
    {
        $this->annotationReader = new AnnotationReader();
        $this->container = DependencyContainer::getInstance();
    }

    public function parseProperty(\ReflectionProperty $property, $object)
    {
        $annotation = $this->annotationReader->getPropertyAnnotation($property, Inject::class);
        if ($annotation !== null) {
            $this->setDependencyInProperty(
                $property,
                $object,
                $this->container->get($annotation->value)
            );
        }
    }

    private function setDependencyInProperty(\ReflectionProperty $property, $object, $dependency)
    {
        if (! $property->isPublic()) {
            $property->setAccessible(true);
            $property->setValue($object, $dependency);
        }
    }
}