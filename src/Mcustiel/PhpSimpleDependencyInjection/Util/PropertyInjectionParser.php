<?php
/**
 * This file is part of php-simple-di.
 *
 * php-simple-di is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * php-simple-di is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with php-simple-di.  If not, see <http://www.gnu.org/licenses/>.
 */
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