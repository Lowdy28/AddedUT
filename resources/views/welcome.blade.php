<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AddedUT | Actividades UTT</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #004aad, #00bcd4);
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            overflow: hidden;
        }

        .logo {
            font-size: 4rem;
            margin-bottom: 1rem;
            animation: fadeIn 1s ease, float 3s ease-in-out infinite;
        }

        h1 {
            font-size: 3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            animation: fadeInDown 1s ease;
        }

        h2 {
            font-weight: 300;
            font-size: 1.2rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            animation: fadeIn 1.5s ease;
        }

        .btn-container {
            display: flex;
            gap: 20px;
            animation: fadeInUp 2s ease;
        }

        .btn {
            background: #fff;
            color: #004aad;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn:hover {
            background: #004aad;
            color: #fff;
            transform: scale(1.05);
        }

        footer {
            position: absolute;
            bottom: 15px;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .highlight {
            color: #ffdd57;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @media (max-width: 600px) {
            h1 { font-size: 2.2rem; }
            .btn-container { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="logo">🎓</div>

    <h1>Bienvenido a <span class="highlight">AddedUT</span></h1>
    <h2>Plataforma de Actividades Extracurriculares<br>Universidad Tecnológica de Tecámac</h2>

    <div class="btn-container">
        <a href="{{ route('login') }}" class="btn">Iniciar Sesión</a>
        <a href="{{ route('register') }}" class="btn">Registrarse</a>
    </div>

    <footer>
        © {{ date('Y') }} | Proyecto académico desarrollado bajo metodología <b>SCRUM</b>.
    </footer>
</body>
</html>
