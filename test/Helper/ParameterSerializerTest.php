<?php

namespace CarboneumTest\NestedState\Helper;

use Carboneum\NestedState\Helper\ParameterSerializer;

class ParameterSerializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array $expectedParams
     * @param string $string
     *
     * @dataProvider provideTestGetParametersByString
     */
    public function testGetParametersByString($expectedParams, $string)
    {
        $this->assertEquals($expectedParams, (new ParameterSerializer)->getParametersByString($string));
    }

    /**
     * @return array
     */
    public function provideTestGetParametersByString()
    {
        return [
            [['foo' => 1, 'bar' => 2], 'foo=1&bar=2'],
            [[], ''],
            [[], 'default'],
            [[], 'foobar'],
        ];
    }
}
