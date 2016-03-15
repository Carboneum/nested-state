<?php

namespace CarboneumTest\NestedState;

use Carboneum\NestedState\ImmutableState;
use Carboneum\NestedState\State;

/**
 * Class StateTest
 * @package CarboneumTest\NestedState
 */
class StateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array $parametersToCheck
     * @param bool $expectedMatch
     *
     * @dataProvider provideTestMatches
     */
    public function testMatches(array $parametersToCheck, $expectedMatch)
    {
        $state = new State(['foo' => 1, 'bar' => true, 'olo' => null]);
        $immutable = new ImmutableState($state);

        $this->assertEquals($expectedMatch, $state->matches($parametersToCheck));
        $this->assertEquals($expectedMatch, $immutable->matches($parametersToCheck));
    }

    /**
     * @return array
     */
    public function provideTestMatches()
    {
        return [
            [
                'parametersToCheck' => ['foo' => 1],
                'expectedMatch' => true
            ],
            [
                'parametersToCheck' => ['foo' => '1'],
                'expectedMatch' => false
            ],
            [
                'parametersToCheck' => ['foo' => 1, 'olo' => 3],
                'expectedMatch' => false
            ],
            [
                'parametersToCheck' => ['foo' => 1, 'bar' => false],
                'expectedMatch' => false
            ],
            [
                'parametersToCheck' => ['foo' => 1, 'bar' => 1],
                'expectedMatch' => false
            ],
            [
                'parametersToCheck' => [],
                'expectedMatch' => true
            ]
        ];
    }

    /**
     *
     */
    public function testSetParameter()
    {
        $state = new State(['foo' => 1, 'bar' => 2]);
        $immutable = new ImmutableState($state);

        $this->assertEquals(2, $state->getParameter('bar'));
        $this->assertEquals(2, $immutable->getParameter('bar'));

        $state->setParameter('bar', 3);

        $this->assertEquals(['foo' => 1, 'bar' => 3], $state->getAllParameters());
        $this->assertEquals(['foo' => 1, 'bar' => 3], $immutable->getAllParameters());
    }

    /**
     * @param string $method
     * @param array $args
     *
     * @expectedException \Carboneum\NestedState\Exception\ParameterMissingException
     *
     * @dataProvider provideTestMissingParameterException
     */
    public function testMissingParameterException($method, $args)
    {
        $state = new State(['foo' => 1, 'bar' => 2]);

        call_user_func_array([$state, $method], $args);
    }

    /**
     * @return array
     */
    public function provideTestMissingParameterException()
    {
        return [
            'getting missing parameter' => [
                'method' => 'getParameter',
                'args' => ['boo']
            ],

            'setting missing parameter' => [
                'method' => 'setParameter',
                'args' => ['boo', 2]
            ],

            'missing parameter in array' => [
                'method' => 'getParameters',
                'args' => [['boo', 'foo', 'bar']]
            ],
        ];
    }

    /**
     * @param array $lessWeight
     * @param array $moreWeight
     *
     * @dataProvider provideTestGetMatchWeight
     */
    public function testGetMatchWeight($lessWeight, $moreWeight)
    {
        $state = new State(['env' => 'dev', 'foo' => 1, 'bar' => true, 'olo' => 2]);
        $immutable = new ImmutableState($state);

        $this->assertTrue($state->getMatchWeight($lessWeight) < $state->getMatchWeight($moreWeight));
        $this->assertTrue($immutable->getMatchWeight($lessWeight) < $immutable->getMatchWeight($moreWeight));
    }

    /**
     * @return array
     */
    public function provideTestGetMatchWeight()
    {
        return [
            [
                'lessWeight' => ['bar' => true],
                'moreWeight' => ['foo' => 1],
            ],
            [
                'lessWeight' => ['foo' => 1],
                'moreWeight' => ['foo' => 1, 'bar' => true],
            ],
            [
                'lessWeight' => ['foo' => 1, 'bar' => true, 'olo' => 2],
                'moreWeight' => ['env' => 'dev'],
            ],

        ];
    }

    /**
     *
     */
    public function testGetMatchWeightFalse()
    {
        $state = new State(['env' => 'dev', 'foo' => 1, 'bar' => true, 'olo' => 2]);
        $immutable = new ImmutableState($state);

        $this->assertSame(false, $state->getMatchWeight(['env' => 'dev', 'bar' => false]));
        $this->assertSame(false, $immutable->getMatchWeight(['env' => 'dev', 'bar' => false]));
    }

    /**
     * @param array $expectedParams
     * @param string $string
     *
     * @dataProvider provideTestGetParametersByString
     */
    public function testGetParametersByString($expectedParams, $string)
    {
        $this->assertEquals($expectedParams, State::getParametersByString($string));
    }

    /**
     * @return array
     */
    public function provideTestGetParametersByString()
    {
        return [
            [['foo' => 1, 'bar' => 2], 'foo=1&bar=2'],
            [[], '']
        ];
    }
}
