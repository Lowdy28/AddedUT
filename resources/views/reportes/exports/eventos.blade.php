<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr style="background:#eaeaea;">
            <th>ID</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Cupos</th>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Creado por</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $r)
        <tr>
            <td>{{ $r->id_evento }}</td>
            <td>{{ $r->nombre }}</td>
            <td>{{ $r->categoria }}</td>
            <td>{{ $r->cupos }}</td>
            <td>{{ $r->fecha_inicio }}</td>
            <td>{{ $r->fecha_fin }}</td>
            <td>{{ $r->creador->nombre ?? 'N/A' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
