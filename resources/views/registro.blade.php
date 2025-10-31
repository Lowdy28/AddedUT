<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Estudiante</title>
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <style>
        /* Estilo del encabezado y logo */
        .header {
            position: absolute;
            top: 20px;
            left: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.4);
            transition: transform 0.3s ease;
        }

        .header img:hover {
            transform: scale(1.05);
        }

        .header h2 {
            color: white;
            font-weight: 600;
            letter-spacing: 1px;
            text-shadow: 0 0 8px rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ asset('imagenes/logo_AddedUT.png') }}" alt="Logo AddeUT">
        <h2>AddeUT</h2>
    </div>

    <div class="container">
        <h1>Registro de Estudiante</h1>

        <form action="{{ route('registrar') }}" method="POST">
            @csrf

            <label>Nombre completo:</label>
            <input type="text" name="nombre" required>

            <label>Matrícula:</label>
            <input type="text" name="matricula" required>

            <label>Área Académica:</label>
            <select name="area_academica" required>
                <option value="">Seleccione una opción</option>
                <option value="TSU">TSU</option>
                <option value="Ingeniería">Ingeniería</option>
            </select>

            <label>Cuatrimestre:</label>
            <select name="cuatrimestre" required>
                <option value="">Seleccione</option>
                @for($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}">{{ $i }}°</option>
                @endfor
            </select>

            <label>Turno:</label>
            <select name="turno" required>
                <option value="">Seleccione</option>
                <option value="Matutino">Matutino</option>
                <option value="Vespertino">Vespertino</option>
                <option value="Mixto">Mixto</option>
            </select>

            <label>Género:</label>
            <select name="genero" required>
                <option value="">Seleccione</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
                <option value="Otro">Otro</option>
            </select>

            <label>Edad:</label>
            <input type="number" name="edad" min="18" max="40" required>

            <button type="submit">Registrar</button>
        </form>

        @if(session('mensaje'))
            <p class="mensaje">{{ session('mensaje') }}</p>
        @endif
    </div>
</body>
</html>