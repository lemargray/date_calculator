<?php
/**
 * Author: Lemar Gray
 * Created: 2020-30-05
 * Date class to perform date operations
 */

namespace App\Utils;

class Date {
    protected $year;
    protected $month;
    protected $day;

    protected $monthDays = [
        1 => 31,
        2 => 28,
        3 => 31,
        4 => 30,
        5 => 31,
        6 => 30,
        7 => 31,
        8 => 31,
        9 => 30,
        10 => 31,
        11 => 30,
        12 => 31
    ];

    public function __construct(string $date)
    {
        list($this->year, $this->month, $this->day) = explode('-', $date);
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function difference(string $date) 
    {
        list($year, $month, $day) = explode('-', $date);        

        if ($year == $this->year && $month == $this->month) {
            return $day - $this->day;
        }

        $totalDays = 0;
        $biggerMonth = $month;
        $biggerYear = $year;
        $biggerDay = $day;
        $smallerMonth = $this->month;
        $smallerYear = $this->year;
        $smallerDay = $this->day;
        $sign = 1;
        
        if ($date < $this->getDate()) {
            $biggerMonth = $this->month;
            $biggerYear = $this->year;
            $biggerDay = $this->day;
            $smallerYear = $year;
            $smallerMonth = $month;
            $smallerDay = $day;
            $sign = -1;
        }

        $totalDays += $this->monthDays[(int) $smallerMonth] - $smallerDay + ( $smallerMonth == 2 && Date::checkLeapYear($smallerYear) ? 1: 0 );

        if ($smallerMonth == 12) {
            $smallerMonth = 1;
            $smallerYear++;
        } else {
            $smallerMonth++;
        }
        
        do {                
            if ($biggerYear == $smallerYear && $smallerMonth == $biggerMonth) {
                $totalDays += $biggerDay;
                break;
            } else {
                $totalDays += $this->monthDays[(int) $smallerMonth] + ( $smallerMonth == 2 && Date::checkLeapYear($smallerYear) ? 1: 0 );
            }

            if ($smallerMonth == 12) {
                $smallerMonth = 1;
                $smallerYear++;
            } else {
                $smallerMonth++;
            }
        } while ( true );

        return $sign * $totalDays;
    }

    public function getDate()
    {
        return $this->year . '-' . $this->month . '-' . $this->day;
    }

    public function isLeapYear()
    {
        return ((($this->year % 4) == 0) && ((($this->year % 100) != 0) || (($this->year % 400) == 0)));
    }

    public static function checkLeapYear($year) 
    {
        return ((($year % 4) == 0) && ((($year % 100) != 0) || (($year % 400) == 0)));
    }    
}