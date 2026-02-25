<?php 
namespace App\Exports;
 
use App\Models\Order;
use App\Models\Orderproducts;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use App\Models\Sales_rep;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
class SalesrepListExport implements FromCollection,WithHeadings,WithColumnWidths
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
 
            'Sales Id',
            'Sales name',
            'Phone number',
            'Email'
            


            
        ];
    } 
    public function collection()
    {
        $sales=Sales_rep::select('unique_id','name','phone','email')->get();

        return $sales;
    }
}