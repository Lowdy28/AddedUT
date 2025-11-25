<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr style="background:#eaeaea;">
            <th>ID</th>
            <th>Usuario</th>
            <th>Evento</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $r)
        <tr>
            <td>{{ $r->id_inscripcion }}</td>
            <td>{{ $r->usuario->nombre }}</td>
            <td>{{ $r->evento->nombre }}</td>
            <td>{{ $r->estado }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
