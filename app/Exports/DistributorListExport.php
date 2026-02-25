<?php 
namespace App\Exports;
 
use App\Models\Order;
use App\Models\Orderproducts;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
class DistributorListExport implements FromCollection,WithHeadings,WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */ 
    protected $start_date;
    protected $end_date;

    function __construct() {

    }
  public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 20,    
            'C' => 15,
            'D' =>20,
            'E' =>20,

        ];
    }
    public function headings():array{
        return[
 
            'Distributor Id',
            'Distributor name',
            'Phone number',
            'Email',
            'User Type',
            'Status'
            


            
        ];
    } 
    public function collection()
    {
        $orders=User::select('id','name','phone','email','user_type','status')->where('user_type','distributor')->where('status','active')->get();

        return $orders;
    }
}