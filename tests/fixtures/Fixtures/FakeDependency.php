<?php
namespace Fixtures;

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

    public function setAValue($aValue)
    {
        $this->aValue = $aValue;
        return $this;
    }
}
