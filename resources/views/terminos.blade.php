<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Términos y Condiciones | AddedUT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen" style="background-color: #eef2f7;">

    {{-- HEADER --}}
    <header class="bg-white border-b-4 py-4 px-6 shadow-lg" style="border-color: #0d9488;">
        <div class="max-w-7xl mx-auto flex items-center gap-3">
            <div class="p-2 rounded-xl shadow-md" style="background: linear-gradient(135deg, #0d9488, #0f766e);">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <span class="text-2xl font-black tracking-tight">
                <span style="color: #1e3a8a;">Added</span><span style="color: #0d9488;">UT</span>
            </span>
        </div>
    </header>

    {{-- HERO --}}
    <div class="relative py-16 px-6 text-center overflow-hidden" style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 40%, #0d9488 100%);">
        {{-- Decorative blobs --}}
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <div class="absolute top-0 left-0 w-96 h-96 rounded-full blur-3xl" style="background:#34d399;"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full blur-3xl" style="background:#60a5fa;"></div>
        </div>

        <div class="max-w-4xl mx-auto relative z-10">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl mb-6 border-2" style="background:rgba(255,255,255,0.12);border-color:rgba(255,255,255,0.2);">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:#34d399;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white mb-4">
                Términos y Condiciones de Uso
            </h1>
            <p class="text-lg max-w-2xl mx-auto leading-relaxed" style="color:rgba(255,255,255,0.9);">
                Bienvenido a <strong style="color:#34d399;">AddedUT</strong>. Al registrarte y utilizar esta plataforma,
                aceptas cumplir con los presentes Términos y Condiciones, los cuales regulan el acceso
                y uso del sistema con fines académicos dentro de la comunidad universitaria.
            </p>
            {{-- Decorative line --}}
            <div class="mt-8 flex items-center justify-center gap-2">
                <div class="h-1 w-20 rounded-full" style="background:linear-gradient(to right, transparent, #34d399);"></div>
                <div class="w-2 h-2 rounded-full" style="background:#34d399;"></div>
                <div class="h-1 w-20 rounded-full" style="background:linear-gradient(to left, transparent, #60a5fa);"></div>
            </div>
        </div>
    </div>

    {{-- MAIN LAYOUT: dos columnas --}}
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="flex flex-col lg:flex-row gap-10 items-start">

            {{-- ══════════════════════════════════════
                 COLUMNA IZQUIERDA: Términos
            ══════════════════════════════════════ --}}
            <main class="flex-1 min-w-0">
                <div class="space-y-5">

                    {{-- Sección 1 --}}
                    <div class="group bg-white rounded-xl border-2 p-6 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1" style="border-color:#e2e8f0;">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-14 h-14 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300" style="background:linear-gradient(135deg, #0d9488, #0f766e);">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-lg font-black mb-2" style="color:#1e3a8a;">1. Uso de la Plataforma</h2>
                                <p class="leading-relaxed text-[15px]" style="color:#475569;">
                                    AddedUT está diseñada exclusivamente para actividades académicas y de apoyo educativo.
                                    El usuario se compromete a utilizar la plataforma de manera responsable, ética y conforme
                                    a los valores institucionales.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Sección 2 --}}
                    <div class="group bg-white rounded-xl border-2 p-6 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1" style="border-color:#e2e8f0;">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-14 h-14 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300" style="background:linear-gradient(135deg, #2563eb, #3b82f6);">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-lg font-black mb-2" style="color:#1e3a8a;">2. Información del Usuario</h2>
                                <p class="leading-relaxed text-[15px]" style="color:#475569;">
                                    El usuario garantiza que la información proporcionada durante el registro es verídica,
                                    completa y actualizada. Cualquier dato falso o inexacto podrá derivar en la suspensión
                                    o cancelación de la cuenta.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Sección 3 --}}
                    <div class="group bg-white rounded-xl border-2 p-6 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1" style="border-color:#e2e8f0;">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-14 h-14 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300" style="background:linear-gradient(135deg, #0d9488, #2563eb);">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-lg font-black mb-2" style="color:#1e3a8a;">3. Conducta y Responsabilidad</h2>
                                <p class="leading-relaxed text-[15px] mb-3" style="color:#475569;">El usuario debe mantener una conducta apropiada al usar la plataforma:</p>
                                <ul class="space-y-2.5">
                                    @foreach([
                                        'No realizar actividades que vulneren la seguridad del sistema.',
                                        'No suplantar identidad ni proporcionar información falsa.',
                                        'No utilizar la plataforma con fines ilícitos o ajenos al ámbito académico.'
                                    ] as $item)
                                    <li class="flex items-start gap-2.5" style="color:#475569;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:#0d9488;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-[15px]">{{ $item }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Sección 4 --}}
                    <div class="group bg-white rounded-xl border-2 p-6 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1" style="border-color:#e2e8f0;">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-14 h-14 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300" style="background:linear-gradient(135deg, #2563eb, #0d9488);">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-lg font-black mb-2" style="color:#1e3a8a;">4. Privacidad y Protección de Datos</h2>
                                <p class="leading-relaxed text-[15px]" style="color:#475569;">
                                    AddedUT se compromete a proteger la información personal de sus usuarios.
                                    Los datos recopilados no serán compartidos con terceros sin autorización,
                                    salvo en los casos previstos por la ley.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Sección 5 --}}
                    <div class="group bg-white rounded-xl border-2 p-6 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1" style="border-color:#e2e8f0;">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-14 h-14 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300" style="background:linear-gradient(135deg, #3b82f6, #2563eb);">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-lg font-black mb-2" style="color:#1e3a8a;">5. Modificaciones</h2>
                                <p class="leading-relaxed text-[15px]" style="color:#475569;">
                                    La plataforma podrá actualizar estos términos en cualquier momento.
                                    Se recomienda revisar periódicamente esta sección para mantenerse informado.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Footer note --}}
                <div class="mt-10 rounded-xl p-8 shadow-2xl text-center" style="background:linear-gradient(135deg, #0d9488, #0f766e);">
                    <div class="flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <p class="text-white text-lg leading-relaxed font-medium">
                        Al continuar utilizando <strong class="font-black">AddedUT</strong>, confirmas que has leído, comprendido
                        y aceptado los presentes Términos y Condiciones.
                    </p>
                </div>

                {{-- Back button --}}
                <div class="mt-8 text-center">
                    <a
                        href="{{ url()->previous() }}"
                        class="inline-flex items-center gap-2 text-white font-bold px-8 py-3.5 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105"
                        style="background:linear-gradient(135deg, #0d9488, #0f766e);"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Volver
                    </a>
                </div>
            </main>

            {{-- ══════════════════════════════════════
                 COLUMNA DERECHA: Contáctanos
            ══════════════════════════════════════ --}}
            <aside class="w-full lg:w-72 flex-shrink-0">
                <div class="bg-white rounded-xl border-2 shadow-xl sticky top-8 overflow-hidden" style="border-color:#e2e8f0;">

                    {{-- Header del aside --}}
                    <div class="p-6 text-center" style="background:linear-gradient(135deg, #1e3a8a, #0d9488);">
                        <h2 class="text-2xl font-black text-white tracking-widest uppercase">
                            Contáctanos
                        </h2>
                        <div class="mt-3 flex items-center justify-center gap-2">
                            <div class="h-1 w-12 rounded-full" style="background:#34d399;"></div>
                            <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
                            <div class="h-1 w-12 rounded-full" style="background:#60a5fa;"></div>
                        </div>
                    </div>

                    <div class="p-6 space-y-1">

                        {{-- Chat --}}
                        <div class="group p-4 rounded-lg hover:bg-gray-50 transition-all duration-300">
                            <div class="flex flex-col items-center text-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300" style="background:linear-gradient(135deg, #0d9488, #0f766e);">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-black text-base mb-1" style="color:#1e3a8a;">Chat con soporte</p>
                                    <p class="font-semibold text-sm" style="color:#475569;">Consultas y dudas académicas</p>
                                    <p class="text-xs mt-2 leading-relaxed" style="color:#94a3b8;">
                                        8:00 a. m. a 8:00 p. m.<br>
                                        Lunes a viernes
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="h-px mx-4" style="background:linear-gradient(to right, transparent, #e2e8f0, transparent);"></div>

                        {{-- Teléfono --}}
                        <div class="group p-4 rounded-lg hover:bg-gray-50 transition-all duration-300">
                            <div class="flex flex-col items-center text-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300" style="background:linear-gradient(135deg, #2563eb, #3b82f6);">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-black text-base mb-1" style="color:#1e3a8a;">Llámanos</p>
                                    <p class="font-semibold text-sm" style="color:#475569;">800-AddedUT</p>
                                    <p class="text-xs mt-2 leading-relaxed" style="color:#94a3b8;">
                                        8 a. m. a 8 p. m.<br>
                                        Lunes a viernes
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="h-px mx-4" style="background:linear-gradient(to right, transparent, #e2e8f0, transparent);"></div>

                        {{-- Correo --}}
                        <div class="group p-4 rounded-lg hover:bg-gray-50 transition-all duration-300">
                            <div class="flex flex-col items-center text-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300" style="background:linear-gradient(135deg, #0d9488, #2563eb);">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-black text-base mb-1" style="color:#1e3a8a;">Envíanos un correo</p>
                                    <p class="text-sm" style="color:#475569;">soporte@addedut.edu.mx</p>
                                </div>
                            </div>
                        </div>

                        <div class="h-px mx-4" style="background:linear-gradient(to right, transparent, #e2e8f0, transparent);"></div>

                        {{-- Ubicación --}}
                        <div class="group p-4 rounded-lg hover:bg-gray-50 transition-all duration-300">
                            <div class="flex flex-col items-center text-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300" style="background:linear-gradient(135deg, #2563eb, #0d9488);">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-black text-base mb-1" style="color:#1e3a8a;">Buscar plantel</p>
                                    <a
                                        href="https://maps.google.com"
                                        target="_blank"
                                        class="text-sm font-bold hover:underline mt-1 inline-block"
                                        style="color:#0d9488;"
                                    >
                                        Ver en el mapa →
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Footer accent dots --}}
                    <div class="p-4 flex items-center justify-center gap-2" style="background:linear-gradient(to right, #f0fdf4, #eff6ff);">
                        <div class="w-2 h-2 rounded-full" style="background:#0d9488;"></div>
                        <div class="w-2 h-2 rounded-full" style="background:#2563eb;"></div>
                        <div class="w-2 h-2 rounded-full" style="background:#0f766e;"></div>
                    </div>

                </div>
            </aside>

        </div>
    </div>

</body>
</html>