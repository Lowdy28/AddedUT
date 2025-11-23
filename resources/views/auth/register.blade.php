<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario | AddedUT</title>
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <style>
        body { background: linear-gradient(135deg, #0a233a, #20426d); font-family: 'Poppins', sans-serif; }
        .header { position: absolute; top:20px; left:25px; display:flex; align-items:center; gap:10px; }
        .header img { width:60px; height:60px; border-radius:12px; box-shadow:0 0 10px rgba(255,255,255,0.4); }
        .header h2 { color:white; font-weight:600; text-shadow:0 0 8px rgba(255,255,255,0.4); }
        .container { width:400px; margin:140px auto; background:rgba(255,255,255,0.15); padding:30px; border-radius:15px; box-shadow:0 0 20px rgba(255,255,255,0.2); backdrop-filter:blur(8px); }
        h1 { color:white; text-align:center; margin-bottom:25px; text-shadow:0 0 8px rgba(255,255,255,0.3); }
        label { display:block; color:white; margin-top:10px; font-weight:500; }
        input, select { width:100%; padding:10px; margin-top:5px; margin-bottom:10px; border-radius:8px; border:none; outline:none; }
        button { width:100%; padding:12px; border:none; border-radius:10px; background-color:#007bff; color:white; font-weight:bold; cursor:pointer; margin-top:10px; transition:0.3s; }
        button:hover { background-color:#0056b3; }
        .mensaje-error { color:#ffbaba; background: rgba(255,0,0,0.2); padding:8px; border-radius:8px; margin-top:10px; }
        .link-login { display:block; margin-top:15px; color:#d4e4ff; text-decoration:none; }
        .link-login:hover { text-decoration:underline; }
    </style>
</head>
<body>

<div class="header">
    <img src="{{ asset('imagenes/logo_AddedUT.png') }}" alt="Logo AddedUT">
    <h2>AddedUT</h2>
</div>

<div class="container">
    <h1>Registro de Usuario</h1>

    <!-- Cambiado a la ruta de RegistroController -->
    <form action="{{ route('registro') }}" method="POST">
        @csrf

        <label for="nombre">Nombre completo:</label>
        <input type="text" name="nombre" id="nombre" required value="{{ old('nombre') }}">

        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" id="email" required value="{{ old('email') }}">

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>

        <label for="password_confirmation">Confirmar contraseña:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>

        <label for="rol">Rol:</label>
        <select name="rol" id="rol" required>
            <option value="">Seleccione rol</option>
            <option value="estudiante" {{ old('rol')=='estudiante' ? 'selected':'' }}>Estudiante</option>
            <option value="profesor" {{ old('rol')=='profesor' ? 'selected':'' }}>Profesor</option>
            <option value="admin" {{ old('rol')=='admin' ? 'selected':'' }}>Admin</option>
        </select>

        <button type="submit">Registrar</button>
    </form>

    @if($errors->any())
        <div class="mensaje-error">{{ $errors->first() }}</div>
    @endif

    <a href="{{ route('login') }}" class="link-login">¿Ya tienes cuenta? Inicia sesión</a>
</div>

</body>
</html>
