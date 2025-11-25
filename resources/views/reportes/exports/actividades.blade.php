<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr style="background:#eaeaea;">
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Categoría</th>
            <th>Cupos</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $r)
        <tr>
            <td>{{ $r->id_actividad }}</td>
            <td>{{ $r->nombre }}</td>
            <td>{{ $r->descripcion }}</td>
            <td>{{ $r->categoria }}</td>
            <td>{{ $r->cupos }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
