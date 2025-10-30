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

        h1 {
            font-size: 3rem;
            font-weight: 600;
            margin-bottom: 1rem;
            animation: fadeInDown 1s ease;
        }

        h2 {
            font-weight: 300;
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            animation: fadeIn 1.5s ease;
        }

        .btn {
            display: inline-block;
            background: #fff;
            color: #004aad;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
            animation: fadeInUp 2s ease;
        }

        .btn:hover {
            background: #004aad;
            color: #fff;
            transform: scale(1.05);
        }

        footer {
            position: absolute;
            bottom: 10px;
            font-size: 0.9rem;
            opacity: 0.7;
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

        .logo {
            font-size: 4rem;
            margin-bottom: 1rem;
            animation: fadeIn 1s ease;
        }

        .highlight {
            color: #ffdd57;
        }
    </style>
</head>
<body>
    <div class="logo">🎓</div>
    <h1>Bienvenido a <span class="highlight">AddedUT</span></h1>
    <h2>Plataforma de Actividades Extracurriculares<br>Universidad Tecnológica de Tecámac</h2>

    <a href="#" class="btn">Explorar Actividades</a>

    <footer>
        © {{ date('Y') }} | Proyecto académico desarrollado bajo metodología SCRUM.
    </footer>
</body>
</html>
