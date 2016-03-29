<?php

namespace CarboneumTest\NestedState;

use Carboneum\NestedState\ImmutableState;
use Carboneum\NestedState\State;

/**
 * Class StateTest
 * @package CarboneumTest\NestedState
 */
class ImmutableStateTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testGetParameters()
    {
        $state = new State(['foo' => 1, 'bar' => true, 'olo' => null]);
        $immutable = new ImmutableState($state);

        $this->assertSame(['bar' => true, 'olo' => null], $immutable->getParameters(['bar', 'olo']));
    }

    /**
     * @param string $key
     *
     * @dataProvider providerTestHasParameters
     */
    public function testHasParameters($key)
    {
        $state = new State(['foo' => 1, 'bar' => true, 'olo' => null]);
        $immutable = new ImmutableState($state);

        $this->assertSame($state->hasParameter($key), $immutable->hasParameter($key));
    }

    /**
     * @return array
     */
    public function providerTestHasParameters()
    {
        return [
            ['bar'],
            ['olo'],
            ['pish']
        ];
    }
}
