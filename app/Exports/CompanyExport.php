<?php

namespace App\Exports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompanyExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'id',
            'name',
            'email',
            'address',
            'created_at',
            'updated_at' 
        ];
    } 

    protected $text;

    function __construct($text) {
            $this->text = $text;
    }

    
    public function collection()
    {
        $searchText = $this->text;
        return Company::where("name", "LIKE", "%".$searchText."%")
        ->orwhere("address", "LIKE", "%".$searchText."%")
        ->orwhere("email", "LIKE", "%".$searchText."%")
        ->get();

    }
}