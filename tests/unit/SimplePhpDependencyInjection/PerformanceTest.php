<?php
namespace Tests\SimplePhpDependencyInjection;

use Mcustiel\PhpSimpleDependencyInjection\DependencyContainer;
use Fixtures\FakeDependency;
use Fixtures\AnnotatedDependency;
use Fixtures\AnotherDependency;

class PerformanceTest extends \PHPUnit_Framework_TestCase
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

    public function testInstantiation()
    {
        $this->dependencyContainer->add(
            'fakeDependency',
            function ()
            {
                return new FakeDependency('someValue');
            },
            false
        );
        $this->dependencyContainer->add(
            'anotherDependency',
            function ()
            {
                return new AnotherDependency('otherValue');
            },
            false
        );
        $this->dependencyContainer->add(
            'annotatedDependency',
            function ()
            {
                return new AnnotatedDependency();
            },
            false
        );
        foreach ([5000, 15000, 25000, 50000] as $cycles) {
            $start = microtime(true);
            for ($i = $cycles; $i > 0; $i--) {
                $this->dependencyContainer->get('annotatedDependency');
            }
            echo "\n$cycles cycles executed in " . (microtime(true) - $start) . " microseconds\n";
        }
    }
}
