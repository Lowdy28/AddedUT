<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr style="background:#002D62; color:#fff;">
            <th>ID</th>
            <th>Título</th>
            <th>Categoría</th>
            <th>Publicada</th>
            <th>Autor</th>
            <th>Likes</th>
            <th>Comentarios</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $r)
        <tr style="background: {{ $loop->even ? '#f9f9f9' : '#fff' }};">
            <td>{{ $r['id_noticia'] }}</td>
            <td>{{ $r['titulo'] }}</td>
            <td>{{ $r['categoria'] }}</td>
            <td>{{ $r['publicada'] }}</td>
            <td>{{ $r['autor'] }}</td>
            <td>{{ $r['likes'] }}</td>
            <td>{{ $r['comentarios'] }}</td>
            <td>{{ $r['created_at'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
