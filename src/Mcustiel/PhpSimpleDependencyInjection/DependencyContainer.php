<?php
namespace Mcustiel\PhpSimpleDependencyInjection;

use Mcustiel\PhpSimpleDependencyInjection\Exception\DependencyDoesNotExistException;

class DependencyContainer
{
    private static $instance;
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

    public function add($identifier, callable $loader, $singleton = true)
    {
        $this->dependencies[$identifier] = new Dependency($loader, $singleton);
    }

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
