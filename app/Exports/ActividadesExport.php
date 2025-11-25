<?php

namespace App\Exports;

use App\Models\Actividad;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActividadesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Actividad::select('id_actividad','nombre','descripcion','categoria','cupos')->get();
    }


    public function headings(): array
    {
        return ['ID','Nombre','Descripción','Categoría','Cupos'];
    }
}