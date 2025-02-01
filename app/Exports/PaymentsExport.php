<?php

namespace App\Exports;

use App\Models\OrderPayment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PaymentsExport implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public $searchBy;
    public $query;

    public function __construct($query, $searchBy = null)
    {
        $this->query = $query;
        $this->searchBy = $searchBy;
    }

    public function collection()
    {
        //
    }
    public function view(): View
    {
        return view('backend.pages.payments.export', [
            'payments' => $this->query,
            'searchBy' => $this->searchBy
        ]);
    }
}
