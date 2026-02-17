<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario | AddedUT</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        :root {
            --color-uttec-blue-dark: #002D62;
            --color-uttec-green: #00DC82;
            --color-text-light: #F1F1F1;
            --color-overlay-dark: rgba(0, 45, 98, 0.75);
            --color-overlay-light: rgba(0, 168, 107, 0.6);
            --color-glass-bg: rgba(255, 255, 255, 0.1);
            --color-error: #FF5252;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--color-overlay-dark), var(--color-overlay-light)),
                        url('{{ asset('imagenes/background.jpg') }}') center/cover no-repeat fixed;
            color: var(--color-text-light);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            animation: fadeZoomIn 1.2s ease both; 
            padding: 20px 0;
        }

        .header {
            position: absolute;
            top: 25px;
            left: 25px;
            display: flex;
            align-items: center;
        }

        .logo-title {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -1px;
            color: var(--color-text-light);
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: opacity 0.3s ease;
        }
        
        .logo-title:hover {
            opacity: 0.8;
        }

        .logo-title .feather {
            width: 30px;
            height: 30px;
            color: var(--color-uttec-green);
        }

        .logo-title span {
            color: var(--color-uttec-green);
        }

        .container {
            width: 100%;
            max-width: 450px;
            background: var(--color-glass-bg);
            padding: 40px;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            text-align: center;
            backdrop-filter: blur(10px);
            animation: fadeInScale 0.8s ease both;
        }

        .container h1 {
            color: var(--color-text-light);
            margin-bottom: 25px;
            font-size: 2.2rem;
            font-weight: 700;
        }

        label {
            color: var(--color-text-light);
            display: block;
            text-align: left;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: 600;
            font-size: 0.95rem;
            opacity: 0.9;
        }

        /* 🔥 AQUÍ ESTÁ LA CORRECCIÓN */
        input:not([type="checkbox"]), select {
            width: 100%;
            padding: 12px 15px;
            border-radius: 10px;
            border: none;
            background: rgba(255, 255, 255, 0.95);
            color: var(--color-uttec-blue-dark);
            outline: none;
            transition: box-shadow 0.3s ease;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        input:focus, select:focus {
            box-shadow: 0 0 0 3px var(--color-uttec-green);
        }

        select {
             background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="%23002D62" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>');
             background-repeat: no-repeat;
             background-position: right 10px center;
             padding-right: 30px;
             cursor: pointer;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background-color: var(--color-uttec-green);
            color: var(--color-uttec-blue-dark);
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 25px;
            font-size: 1.1rem;
            box-shadow: 0 5px 15px rgba(0, 220, 130, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        button:hover {
            background-color: var(--color-uttec-blue-dark);
            color: var(--color-text-light);
            box-shadow: 0 7px 20px rgba(0, 45, 98, 0.6);
            transform: translateY(-2px);
        }

        .mensaje-error {
            color: var(--color-error);
            background: rgba(255, 82, 82, 0.2);
            border: 1px solid var(--color-error);
            padding: 10px;
            border-radius: 10px;
            margin-top: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .link-login {
            display: block;
            margin-top: 25px;
            color: var(--color-text-light);
            text-decoration: none;
            font-size: 0.95rem;
            opacity: 0.8;
            transition: color 0.3s, opacity 0.3s;
        }

        .link-login:hover {
            opacity: 1;
            color: var(--color-uttec-green);
        }
    </style>
</head>

<body>

    <div class="header">
        <a href="/" class="logo-title"> 
            <i data-feather="book-open" class="feather"></i>
            Added<span>UT</span>
        </a>
    </div>

    <div class="container">
        <h1>Registro de Usuario</h1>

        <form action="{{ route('registro') }}" method="POST">
            @csrf

            <label for="nombre">Nombre completo:</label>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre Apellido" required value="{{ old('nombre') }}" autofocus>

            <label for="email">Correo electrónico:</label>
            <input type="email" name="email" id="email" placeholder="matricula@uttec.edu.mx" required value="{{ old('email') }}">

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" placeholder="••••••••" required>

            <label for="password_confirmation">Confirmar contraseña:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" required>

            <label for="rol">Rol:</label>
            <select name="rol" id="rol" required>
                <option value="" disabled {{ old('rol') == '' ? 'selected' : '' }}>Seleccione su rol</option>
                <option value="estudiante" {{ old('rol')=='estudiante' ? 'selected':'' }}>Estudiante</option>
                <option value="profesor" {{ old('rol')=='profesor' ? 'selected':'' }}>Profesor</option>
            </select>

            <div style="margin-top:20px; text-align:left; font-size:0.9rem;">
                <input type="checkbox" name="terms" id="terms">
                <label for="terms" style="display:inline; font-weight:400;">
                    Acepto los 
                     <a href="{{ route('terminos') }}" style="color: var(--color-uttec-green); font-weight:600;">
                        Términos y Condiciones
                    </a>
                </label>
            </div>

            <button type="submit">
                <i data-feather="user-plus" style="width: 18px; stroke-width: 3;"></i> Registrar
            </button>
        </form>

        @if($errors->any())
            <div class="mensaje-error">
                <i data-feather="alert-triangle" style="width: 18px; margin-right: 5px;"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <a href="{{ route('login') }}" class="link-login">
            ¿Ya tienes cuenta? <span style="font-weight: 700;">Inicia sesión aquí</span>
        </a>
    </div>

    <script>
        feather.replace();
    </script>
</body>
</html>
