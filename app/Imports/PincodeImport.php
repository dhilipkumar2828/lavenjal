<?php
namespace App\Imports;
use App\Models\Pincode;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;

class PincodeImport implements ToModel,WithHeadingRow
{
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        $pincode=Pincode::where('pincode',$row['pincode'])->first();    

      if(empty($pincode)){
        $pincode=new Pincode();
        $pincode->city = '1';
        $pincode->status = 'active';
        $pincode->pincode= $row['pincode'];
        $pincode->save();
      }

    }
    
   
}