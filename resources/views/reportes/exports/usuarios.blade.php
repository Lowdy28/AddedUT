<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr style="background:#eaeaea;">
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Activo</th>
            <th>Fecha Registro</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $r)
        <tr>
            <td>{{ $r->id_usuario }}</td>
            <td>{{ $r->nombre }}</td>
            <td>{{ $r->email }}</td>
            <td>{{ $r->rol }}</td>
            <td>{{ $r->activo ? 'Sí' : 'No' }}</td>
            <td>{{ $r->fecha_registro }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
