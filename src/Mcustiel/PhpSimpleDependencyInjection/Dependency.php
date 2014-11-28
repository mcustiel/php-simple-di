<?php
namespace Mcustiel\PhpSimpleDependencyInjection;

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

    public function __construct(callable $loader, $singleton = true)
    {
        $this->singleton = (boolean) $singleton;
        $this->loader = $loader;
    }

    public function get()
    {
        if (!$this->singleton) {
            return call_user_func($this->loader);
        }
        if ($this->object === null ) {
            $this->object = call_user_func($this->loader);
        }

        return $this->object;
    }
}
