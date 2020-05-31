<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Utils\Date;

class DateTest extends TestCase
{
    /**
     * Test custom date class 
     *
     * @return void
     */
    public function testLeapYear()
    {
        $date = new Date('2020-01-01');
        $result = $date->difference('2021-01-01');

        $this->assertEquals(366, $result);
    }

    public function testYearThatIsNotLeapYear()
    {
        $date = new Date('2019-01-01');
        $result = $date->difference('2020-01-01');

        $this->assertEquals(365, $result);
    }

    public function testEndDateGreaterThanStartDate()
    {
        $date = new Date('2020-01-20');
        $result = $date->difference('2020-01-01');

        $this->assertEquals(-19, $result);
    }
}
