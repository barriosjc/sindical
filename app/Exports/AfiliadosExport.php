<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings ;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AfiliadosExport implements FromCollection, WithHeadings, WithEvents
{
    public function collection()
    {
        $afiliados = DB::table('v_afiliados_padron')->where("email","<>", "")->get();
        return $afiliados;
    }

    public function headings() :array
    {
        return ["Nombre y apellido", 
        "direccion", 
        "localidad",
        "provincia", 
        "Tipo doc.",
        "Nro doc", 
        "Fecha nac.", 
        "Telefono", 
        "Email", 
        "Sexo", 
        "Nacionalidad", 
        "Estado civil",
        "Nro afil sind.", 
        "Fecha vigencia", 
        "Fecha ingreso", 
        "Fecha egreso", 
        "Motivo egreso", 
        "Empresa", 
        "Cuil", 
        "Seccional", 
        "Discapacitado", 
        "Estado ficha", 
        "Fecha jubilacion", 
        "Fecha ing empr", 
        "Fecha egr empr", 
        "Delegado desde", 
        "Delegado hasta"  ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
  
                $event->sheet->getDelegate()->getStyle('A1:AA1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('D0D4FC');
  
            },
        ];
    }

}