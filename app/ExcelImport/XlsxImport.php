<?php

namespace App\ExcelImport;

use Maatwebsite\Excel\Concerns\ToModel;

class XlsxImport implements ToModel
{
    public function model(array $row)
    {
        // return $row;
        dd($row);
    }
}