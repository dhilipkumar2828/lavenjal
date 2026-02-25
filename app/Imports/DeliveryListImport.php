<?php
namespace App\Imports;
use App\Models\User;
use App\Models\User_address;
use App\Models\Sales_rep;
use App\Models\Owner_meta_data;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class DeliveryListImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
  
      
 if($row['agreement_returned']=="Completed" || $row['agreement_returned']=="pending"){
        $sales=Sales_rep::where('name',$row['sales_executive'])->first();
        $user=User::where('phone',(string)$row['phone'])->where('user_type','delivery_agent')->first();
        $unique_id=User::where('unique_id',$row['unique_id'])->first();
if(empty($sales)){
  $sales=new Sales_rep();
  $sales->name=$row['sales_executive'];
  $sales->save();
}
if(!empty($unique_id)){


  $user=array(
      'unique_id'=>$row['unique_id'],
      'phone'=>(string)$row['phone'],
     );
     User::where('id',$unique_id->id)->update($user);
  $owners=array(

            'name_of_shop'=>$row['name_of_shop'],
            // 'nature_of_shop'=>$row['nature_of_shop'],

             
             //'ownership_type'=>$row['ownership_type'],
             //'name_of_owner'=>$row['name_of_owner'],
             'owner_contact_no'=>(string)$row['phone'],
             //'owner_email'=>$row['owner_email'],
             
             'full_address'=>$row['full_address'],
             'pincode'=>$row['pincode'],
             'lat'=>$row['lat'],
             'lang'=>$row['lang'],
        
             'assign_sales_rep'=>$sales->id,
            //  'landmark'=>$row['landmark'],
             
            //  'delivery_type'=>$row['delivery_type'],
            //  'gst_no'=>(string)$row['gst_number'],
            //  'aadhar_number'=>(string)$row['aadhar_number']
      );
          Owner_meta_data::where('user_id',$unique_id->id)->update($owners);
        
    $address=new User_address();
    $useraddress=array(
        //   'full_name'=>$row['name'],
        //   'door_no'=>$row['door_no'],
          'phone_number'=>(string)$row['phone'],
          'address'=>$row['full_address'],
        //   'city'=>$row['city'],
        //   'state'=>$row['state'],
          //'agreement_date'=>$row['date'],
          'zip_code'=>$row['pincode'],
          'lat'=>$row['lat'],
          'lang'=>$row['lang'],
          'full_address'=>$row['full_address'],
    
    );
     $address->where('user_id',$unique_id->id)->update($useraddress);
   // return  User::all();

}
else if(empty($user)){

        $user=new User();
        // $user->name= $row['name'];
        $user->unique_id= $row['unique_id'];
        $user->phone= (string)$row['phone'];
        $user->user_type= "delivery_agent";
        $user->status= "1";
      //  $user->password= Hash::make((string)$row['phone']);
        $user->save();

  $owners=array(
            'user_id'=>$user->id, 
            'user_type'=>"delivery_agent", 
            'name_of_shop'=>$row['name_of_shop'],
            // 'nature_of_shop'=>$row['nature_of_shop'],

             
             //'ownership_type'=>$row['ownership_type'],
             //'name_of_owner'=>$row['name_of_owner'],
             'owner_contact_no'=>(string)$row['phone'],
             //'owner_email'=>$row['owner_email'],
             
             'full_address'=>$row['full_address'],
             'pincode'=>$row['pincode'],
             'lat'=>$row['lat'],
             'lang'=>$row['lang'],
             'agreement_date'=>$row['date'],
             'assign_sales_rep'=>$sales->id,
            //  'landmark'=>$row['landmark'],
             
            //  'delivery_type'=>$row['delivery_type'],
            //  'gst_no'=>(string)$row['gst_number'],
            //  'aadhar_number'=>(string)$row['aadhar_number']
      );
          Owner_meta_data::create($owners);
        
        return new User_address([
          'user_id'=>$user->id, 
        //   'full_name'=>$row['name'],
        //   'door_no'=>$row['door_no'],
          'phone_number'=>(string)$row['phone'],
          'is_lift'=>"false",
          'is_default'=>"true",
          'address'=>$row['full_address'],
        //   'city'=>$row['city'],
        //   'state'=>$row['state'],
          'zip_code'=>$row['pincode'],
          'lat'=>$row['lat'],
          'lang'=>$row['lang'],
          'full_address'=>$row['full_address'],
          'address_type'=>"home",
        ]);
    }




// $users=User::where('phone', (string)$row['phone_numbers'])->first();
// if(empty($users)){
//         $user=new User();
//         $user->name= $row['name'];
//         // $user->email= $row['email'];
//         $user->phone= (string)$row['phone_numbers'];
//         $user->user_type= "delivery_agent";
//         $user->status= "1";
//         $user->password= Hash::make((string)$row['phone_numbers']);
//         $user->save();

//  return new Owner_meta_data([
//             'user_id'=>$user->id, 
//             'user_type'=>"delivery_agent", 
//             'name_of_shop'=>$row['factory_name'],
//             // 'nature_of_shop'=>$row['nature_of_shop'],

             
//              //'ownership_type'=>$row['ownership_type'],
//              //'name_of_owner'=>$row['name_of_owner'],
//              'owner_contact_no'=>(string)$row['phone_numbers'],
//              //'owner_email'=>$row['owner_email'],
             
//             //  'full_address'=>$row['full_address'],
//             //  'pincode'=>$row['pincode'],
//              'lat'=>$row['lat'],
//              'lang'=>$row['lang'],
//             //  'agreement_date'=>$row['date'],
//             //  'assign_sales_rep'=>$sales->id,
//             //  'landmark'=>$row['landmark'],
             
//             //  'delivery_type'=>$row['delivery_type'],
//             //  'gst_no'=>(string)$row['gst_number'],
//             //  'aadhar_number'=>(string)$row['aadhar_number']
//       ]);
//           //Owner_meta_data::create($owners);
//     }
     }
    }
}