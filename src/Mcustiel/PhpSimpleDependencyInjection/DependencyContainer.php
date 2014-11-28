<?php
namespace Mcustiel\PhpSimpleDependencyInjection;

use Mcustiel\PhpSimpleDependencyInjection\Exception\DependencyDoesNotExistException;

/**
 * A minimalistic dependency container.
 *
 * @author mcustiel
 */
class DependencyContainer
{
    /**
     * The singleton instance of this class
     * @var DependencyContainer
     */
    private static $instance;
    /**
     * The collection of dependencies contained.
     * @var Dependency[]
     */
    private $dependencies;

    private function __construct()
    {
        $this->dependencies = [];
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Adds an object generator and the identifier for that object, with the option
     * of make the object 'singleton' or not.
     *
     * @param string   $identifier The identifier of the dependency
     * @param callable $loader     The generator for the dependency object
     * @param string   $singleton  Whether or not to return always the same instance of the object
     */
    public function add($identifier, callable $loader, $singleton = true)
    {
        $this->dependencies[$identifier] = new Dependency($loader, $singleton);
    }

    /**
     * Gets the dependency identified by the given identifier.
     *
     * @param string $identifier The identifier of the dependency
     *
     * @return object The object identified by the given id
     * @throws DependencyDoesNotExistException If there's not dependency with the given id
     */
    public function get($identifier)
    {
        if (!isset($this->dependencies[$identifier])) {
            throw new DependencyDoesNotExistException(
                "Dependency identified by '$identifier' does not exist"
            );
        }
        return $this->dependencies[$identifier]->get();
    }
}
