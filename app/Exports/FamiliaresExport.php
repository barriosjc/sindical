<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings ;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class FamiliaresExport implements FromCollection, WithHeadings, WithEvents
{
    public function collection()
    {
        $familiares = DB::table('v_familiares_padron')
                        ->select(
                            'nro_grupo_fam', 'apellido_nombres', 'tipo_documento', 'nro_doc', 'fecha_nac', 'sexo', 'edad', 'cuil', 
                            'domicilio', 'localidad', 'provincia', 'nacionalidad', 'telefonos', 'fecha_ingreso_sind', 'fecha_egreso_sind',  
                            'motivo_egreso', 'discapacitado', 'fecha_venc_disca', "tipo_parentesco"
                            )
                        ->where("tipo_parentesco_id", "160")->get();
        return $familiares;
    }

    public function headings() :array
    {
        return ["Nro Afiliado",
            "Nombre y apellido", 
            "Tipo doc.",
            "Nro doc", 
            "Fecha nac.", 
            "Sexo", 
            "edad",
            "Cuil", 
            "direccion", 
            "localidad",
            "Provincia",
            "Nacionalidad", 
            "Telefono", 
            "Fecha ingreso", 
            "Fecha egreso", 
            "Motivo egreso", 
            "Discapacitado", 
            "Fecha venc. Certif.",    
            "Tipo parentesco" ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
  
                $event->sheet->getDelegate()->getStyle('A1:S1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('D0D4FC');
  
            },
        ];
    }

}