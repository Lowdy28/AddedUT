<?php

namespace App\Exports;

use App\Models\Evento;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventosExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Evento::select('id_evento','nombre','categoria','cupos','fecha_inicio','fecha_fin','creado_por')->get();
    }


    public function headings(): array
    {
        return ['ID','Nombre','Categoría','Cupos','Fecha Inicio','Fecha Fin','Creado Por'];
    }
}