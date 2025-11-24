<!DOCTYPE html>
<html lang="es">
    
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión | AddeUT</title>
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <style>
        /* Encabezado con logo */
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

        /* Contenedor principal */
        .container {
            width: 400px;
            margin: 140px auto;
            background: rgba(255, 255, 255, 0.15);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
            text-align: center;
            backdrop-filter: blur(8px);
        }

        .container h1 {
            color: white;
            margin-bottom: 25px;
            text-shadow: 0 0 8px rgba(255, 255, 255, 0.3);
        }

        label {
            color: white;
            display: block;
            text-align: left;
            margin-top: 10px;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: none;
            margin-top: 5px;
            margin-bottom: 10px;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background-color: #007bff;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .mensaje-error {
            color: #ffbaba;
            background: rgba(255, 0, 0, 0.2);
            padding: 8px;
            border-radius: 8px;
            margin-top: 10px;
            font-size: 0.9rem;
        }

        .link-registro {
            display: block;
            margin-top: 15px;
            color: #d4e4ff;
            text-decoration: none;
        }

        .link-registro:hover {
            text-decoration: underline;
        }

        body {
            background: linear-gradient(135deg, #0a233a, #20426d);
            font-family: 'Poppins', sans-serif;
        }
    </style>

</head>

<body>

    <div class="header">
        <img src="{{ asset('imagenes/Logo AddedUT.png') }}" alt="Logo AddeUT">
        <h2>AddeUT</h2>
    </div>

    <div class="container">
        <h1>Iniciar Sesión</h1>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <label for="email">Correo electrónico:</label>
            <input type="email" name="email" id="email" required value="{{ old('email') }}">

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Ingresar</button>
        </form>

        <!-- Errores -->
        @if($errors->any())
            <div class="mensaje-error">{{ $errors->first() }}</div>
        @endif

        <a href="{{ route('registro') }}" class="link-registro">¿No tienes cuenta? Regístrate aquí</a>
    </div>

</body>
</html>
