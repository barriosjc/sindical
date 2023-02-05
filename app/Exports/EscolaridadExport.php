<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings ;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class EscolaridadExport implements FromCollection, WithHeadings, WithEvents
{
    public function collection()
    {
        $familiares = DB::table('v_escolaridad')
                        ->select(
                            'nro_grupo_fam', 'apellido_nombres', 'tipo_documento', 'nro_doc', 'sexo', 'edad',
                            "tipo_parentesco", 'ciclo_lectivo', 'nivel', 'tipo_educacion','mochila', 'kit_escolar', 
                            'delantal', 'talle', 'obs', 'fec_entrega', 'deleted_at', 'usuario_id_del' )
                        ->get();
        return $familiares;
    }

    public function headings() :array
    {
        return ["Nro Afiliado",
            "Nombre y apellido", 
            "Tipo doc.",
            "Nro doc", 
            "Sexo", 
            "edad",
            "Tipo parentesco",
            'ciclo_lectivo',
            'nivel',
            'tipo_educacion',
            'mochila',
            'kit_escolar',
            'delantal',
            'talle',
            'obs',
            'fec_entrega',
            'borrado', 
            'usuario que borro' ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
  
                $event->sheet->getDelegate()->getStyle('A1:R1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('D0D4FC');
  
            },
        ];
    }

}