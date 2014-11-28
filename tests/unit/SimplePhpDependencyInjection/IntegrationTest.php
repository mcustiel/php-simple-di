<?php
namespace Tests\SimplePhpDependencyInjection;

use Mcustiel\PhpSimpleDependencyInjection\DependencyContainer;
use Fixtures\FakeDependency;

class IntegrationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The unit under test.
     *
     * @var \Mcustiel\PhpSimpleDependencyInjection\DependencyContainer
     */
    private $dependencyContainer;

    public function setUp()
    {
        $this->dependencyContainer = DependencyContainer::getInstance();
    }

    public function testDependencyContainerWhenDependencyExists()
    {
        $this->dependencyContainer->add('dependency', function() {
            return new FakeDependency('someValue');
        });

        $this->assertInstanceOf(
            '\Fixtures\FakeDependency',
            $this->dependencyContainer->get('dependency')
        );
        $this->assertEquals(
            'someValue',
            $this->dependencyContainer->get('dependency')->getAValue()
        );
    }

    public function testDependencyContainerSingleton()
    {
        $this->dependencyContainer->add('dependency', function() {
            return new FakeDependency('someValue');
        });

        $instance1 = $this->dependencyContainer->get('dependency');
        $instance2 = $this->dependencyContainer->get('dependency');
        $this->assertInstanceOf(
            '\Fixtures\FakeDependency',
            $instance1
        );
        $this->assertInstanceOf(
            '\Fixtures\FakeDependency',
            $instance2
        );

        $this->assertSame($instance1, $instance2);
    }

    public function testDependencyContainerNoSingleton()
    {
        $this->dependencyContainer->add('dependency', function() {
            return new FakeDependency('someValue');
        }, false);

        $instance1 = $this->dependencyContainer->get('dependency');
        $instance2 = $this->dependencyContainer->get('dependency');
        $this->assertInstanceOf(
            '\Fixtures\FakeDependency',
            $instance1
        );
        $this->assertInstanceOf(
            '\Fixtures\FakeDependency',
            $instance2
        );

        $this->assertFalse($this->areTheSame($instance1, $instance2));
    }

    /**
     * @expectedException
     *  \Mcustiel\PhpSimpleDependencyInjection\Exception\DependencyDoesNotExistException
     * @expectedExceptionMessage
     *  Dependency identified by 'dependency' does not exist
     */
    public function testDependencyContainerWhenDependencyDoesNotExist()
    {
        $this->dependencyContainer->get('dependency');
    }

    private function areTheSame(&$object1, &$object2)
    {
        return $object1 === $object2;
    }
}
