<?php

namespace App\Http\Controllers;

use App\Jobs\SendReport;

class ReportController extends Controller
{
    public function toExcel($type, $id)
    {

        SendReport::dispatch($type, $id);

        return 'success';
    }
}
