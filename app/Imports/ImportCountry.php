<?php

namespace App\Imports;

use App\Country;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportCountry implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if($row[0] != null){
            return new Country([
                'name' => $row[0],
                'code' => $row[1],
            ]);
        }
    }
}
