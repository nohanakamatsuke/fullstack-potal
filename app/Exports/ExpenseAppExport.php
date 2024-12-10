<?php

namespace App\Exports;

use App\Models\ExpenseApp;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExpenseAppExport implements FromCollection
{
    public function collection()
    {
        return ExpenseApp::all();
    }
}
