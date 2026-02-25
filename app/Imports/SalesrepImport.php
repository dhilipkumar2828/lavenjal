<?php
namespace App\Imports;
use App\Models\User;
use App\Models\User_address;
use App\Models\Sales_rep;
use App\Models\Owner_meta_data;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class SalesrepImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
 
 
        $sales=Sales_rep::where('unique_id',$row['unique_id'])->first();
if(empty($sales)){
  $sales=new Sales_rep();
  $sales->name=$row['name'];
  $sales->email=$row['email'];
  $sales->phone=(string)$row['phone'];
  $sales->save();
}else{
      $sales_values=array(
      'name'=>$row['name'],
      'email'=>$row['email'],
      'phone'=>(string)$row['phone'],
     );
    Sales_rep::where('id',$sales->id)->update($sales_values);
}










    }
}