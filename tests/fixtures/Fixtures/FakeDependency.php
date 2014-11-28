<?php
namespace Fixtures;

/**
 * @codeCoverageIgnore
 */
class FakeDependency
{
    private $aValue;

    public function __construct($initializer)
    {
        $this->aValue = $initializer;
    }

    public function getAValue()
    {
        return $this->aValue;
    }
}
