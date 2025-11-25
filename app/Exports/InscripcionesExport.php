<?php

namespace App\Exports;

use App\Models\Inscripcion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InscripcionesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Inscripcion::with(['usuario','evento'])->get()->map(function($i){
        return [
        'id_inscripcion' => $i->id_inscripcion,
        'estudiante' => $i->usuario?->nombre,
        'evento' => $i->evento?->nombre,
        'estado' => $i->estado,
        ];
        });
    }


    public function headings(): array
    {
        return ['ID','Estudiante','Evento','Estado'];
    }
}