<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLeapYear()
    {
        $response = $this->get('/2020-01-01/2021-01-01');

        $response->assertSeeText(366);
    }

    public function testYearThatIsNotLeapYear()
    {
        $response = $this->get('/2019-01-01/2020-01-01');

        $response->assertSeeText(365);
    }

    public function testEndDateGreaterThanStartDate()
    {
        $response = $this->get('/2020-01-20/2020-01-01');

        $response->assertSeeText(-19);
    }
}
