<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;

class TestExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $contracts;
    protected $company;
    protected $from;
    protected $to;

    public function __construct($contracts, $company, $from, $to)
    {
        $this->contracts    = $contracts;
        $this->company      = $company;
        $this->from         = $from;
        $this->to           = $to;

    }

    public function view(): View
    {
        return \view('Exports.testExport', [
            'contracts'     => $this->contracts,
            'company'       => $this->company,
            'from'          => $this->from,
            'to'            => $this->to
        ]);
    }
}
