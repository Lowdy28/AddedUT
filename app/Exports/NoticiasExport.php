<?php

namespace App\Exports;

use App\Models\Noticia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NoticiasExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Noticia::with('autor')->get()->map(function ($n) {
            return [
                'id_noticia'   => $n->id_noticia,
                'titulo'       => $n->titulo,
                'categoria'    => $n->categoria,
                'publicada'    => $n->publicada ? 'Sí' : 'No',
                'autor'        => $n->autor?->nombre ?? 'N/A',
                'likes'        => $n->totalLikes(),
                'comentarios'  => $n->comentarios()->count(),
                'created_at'   => $n->created_at?->format('Y-m-d H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Título', 'Categoría', 'Publicada', 'Autor', 'Likes', 'Comentarios', 'Fecha'];
    }
}
