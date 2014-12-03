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
namespace Mcustiel\PhpSimpleDependencyInjection;

use Mcustiel\PhpSimpleDependencyInjection\Util\PropertyInjectionParser;
/**
 * Represents a dependency, with a loader that is the generator of the dependency object
 * and the object itself. If the object is treated as a singleton the same instance
 * is always returned.
 *
 * @author mcustiel
 */
class Dependency
{
    private $object;
    private $singleton;
    private $loader;
    private $injectionParser;

    public function __construct(callable $loader, $singleton = true)
    {
        $this->singleton = (boolean) $singleton;
        $this->loader = $loader;
        $this->injectionParser = new PropertyInjectionParser();
    }

    public function get()
    {
        if (! $this->singleton) {
            return $this->getObjectFromLoader();
        }
        if ($this->object === null ) {
            $this->object = $this->getObjectFromLoader();
        }

        return $this->object;
    }

    private function getObjectFromLoader()
    {
        $object = call_user_func($this->loader);
        $this->parseInjection($object);
        return $object;
    }

    private function parseInjection($object)
    {
        if (is_object($object)) {
            $reflection = new \ReflectionObject($object);
            foreach ($reflection->getProperties() as $property) {
                $this->injectionParser->parseProperty($property, $object);
            }
        }
    }
}
