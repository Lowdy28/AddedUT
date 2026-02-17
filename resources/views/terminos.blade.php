<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Términos y Condiciones | AddedUT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --color-uttec-blue-dark: #002D62;
            --color-uttec-green: #00DC82;
            --color-text-light: #F1F1F1;
            --color-overlay-dark: rgba(0, 45, 98, 0.75);
            --color-overlay-light: rgba(0, 168, 107, 0.6);
            --color-glass-bg: rgba(255, 255, 255, 0.1);
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
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .container {
            width: 100%;
            max-width: 850px;
            background: var(--color-glass-bg);
            padding: 50px;
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 15px 40px rgba(0,0,0,0.4);
            backdrop-filter: blur(12px);
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 30px;
            text-align: center;
        }

        h2 {
            margin-top: 30px;
            margin-bottom: 10px;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--color-uttec-green);
        }

        p {
            margin-bottom: 15px;
            font-weight: 400;
            opacity: 0.95;
        }

        ul {
            margin-left: 20px;
            margin-bottom: 15px;
        }

        li {
            margin-bottom: 8px;
        }

        .btn-back {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 25px;
            border-radius: 10px;
            background-color: var(--color-uttec-green);
            color: var(--color-uttec-blue-dark);
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background-color: var(--color-uttec-blue-dark);
            color: var(--color-text-light);
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <div class="container">

        <h1>Términos y Condiciones de Uso</h1>

        <p>
            Bienvenido a <strong>AddedUT</strong>. Al registrarte y utilizar esta plataforma,
            aceptas cumplir con los presentes Términos y Condiciones, los cuales regulan el acceso
            y uso del sistema con fines académicos dentro de la comunidad universitaria.
        </p>

        <h2>1. Uso de la Plataforma</h2>
        <p>
            AddedUT está diseñada exclusivamente para actividades académicas y de apoyo educativo.
            El usuario se compromete a utilizar la plataforma de manera responsable, ética y conforme
            a los valores institucionales.
        </p>

        <h2>2. Información del Usuario</h2>
        <p>
            El usuario garantiza que la información proporcionada durante el registro es verídica,
            completa y actualizada. Cualquier dato falso o inexacto podrá derivar en la suspensión
            o cancelación de la cuenta.
        </p>

        <h2>3. Conducta y Responsabilidad</h2>
        <ul>
            <li>No realizar actividades que vulneren la seguridad del sistema.</li>
            <li>No suplantar identidad ni proporcionar información falsa.</li>
            <li>No utilizar la plataforma con fines ilícitos o ajenos al ámbito académico.</li>
        </ul>

        <h2>4. Privacidad y Protección de Datos</h2>
        <p>
            AddedUT se compromete a proteger la información personal de sus usuarios.
            Los datos recopilados no serán compartidos con terceros sin autorización,
            salvo en los casos previstos por la ley.
        </p>

        <h2>5. Modificaciones</h2>
        <p>
            La plataforma podrá actualizar estos términos en cualquier momento.
            Se recomienda revisar periódicamente esta sección para mantenerse informado.
        </p>

        <p>
            Al continuar utilizando AddedUT, confirmas que has leído, comprendido
            y aceptado los presentes Términos y Condiciones.
        </p>

        <a href="{{ url()->previous() }}" class="btn-back">Volver</a>

    </div>

</body>
</html>
