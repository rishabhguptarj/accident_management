<?php

namespace App\Imports;

use App\Models\CsvModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class csvImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CsvModel([
            'name'     => $row['name'],
            'email'    => $row['email'], 
            // 'country' => $row['country'],
            // 'state' => $row['state'],
            // 'city' => $row['city'],
            // 'pincode' => $row['pincode'],
            // 'fatalities' => $row['fatalities'],
            // 'age' => $row['age'],
            // 'gender' => $row['gender'],
            // 'vehicle' => $row['vehicle'],
            // 'insured_status' => $row['insured_status'],
        ]);
    }
}
