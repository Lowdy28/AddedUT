<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr style="background:#002D62; color:#fff;">
            <th>ID</th>
            <th>Estudiante</th>
            <th>Evento</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $r)
        <tr style="background: {{ $loop->even ? '#f9f9f9' : '#fff' }};">
            <td>{{ $r['id_inscripcion'] }}</td>
            <td>{{ $r['estudiante'] }}</td>
            <td>{{ $r['evento'] }}</td>
            <td>{{ $r['estado'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
