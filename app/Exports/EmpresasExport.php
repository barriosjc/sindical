<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings ;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class EmpresasExport implements FromCollection, WithHeadings, WithEvents
{
    public function collection()
    {
        $empresas = DB::table('v_empresas')->where("razon_social", "like", '%' . "met" . '%' )->get();
        return $empresas;
    }

    public function headings() :array
    {
        return [	"id", 
        "Seccional", 
        "Razon Social", 
        "Domicilio", 
        "Domicilio Adm", 
        "Localidad",
        "C.P.",
        "Localidad Adm",
        "C.P. Adm",
        "CUIT", 
        "Telefonos", 
        "Fec. Alta", 
        "Fec. Baja", 
        "Tipo de Baja",
        "Novedades",  
        "Email", 
        "Fec. ult. inspección",
        "Observaciones", 
        "cant_empleados", 
        "Cod. Empresa", 
        "tiene_delegado", 
        "est. empresa" ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
  
                $event->sheet->getDelegate()->getStyle('A1:V1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('D0D4FC');
  
            },
        ];
    }
}