<?php 
namespace App\Exports;
 
use App\Models\Pincode;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
class PincodeExport implements FromCollection,WithHeadings,WithColumnWidths
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
            'D' => 15,

        ];
    }
    public function headings():array{
        return[
            'Pincode Id',
            'City',
            'Pincode',
            'Status',
            
            
        ];
    } 
    public function collection()
    {
        $pincode=Pincode::select('id','city','pincode','status')->where('status','active')->get();

        return $pincode;
    }
}