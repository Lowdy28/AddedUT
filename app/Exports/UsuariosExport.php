<?php

namespace App\Exports;

use App\Models\Usuario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsuariosExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Usuario::select('id_usuario','nombre','email','rol','activo','fecha_registro')->get();
    }

    public function headings(): array
    {
        return ['ID','Nombre','Email','Rol','Activo','Fecha Registro'];
    }
}