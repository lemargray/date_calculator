<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DateController extends Controller
{
    public function index() {
        return view('index');
    }

    public function calculateDifference($start_date, $end_date) {
        $date = new \App\Utils\Date($start_date);

        $result = $date->difference($end_date);

        $dateCalculation = new \App\DateCalculation();
        $dateCalculation->start_date = $start_date;
        $dateCalculation->end_date = $end_date;
        $dateCalculation->result = $result;
        $dateCalculation->save();

        return $result;
    }
}
