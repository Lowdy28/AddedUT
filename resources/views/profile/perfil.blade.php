@extends(Auth::user()->rol === 'profesor' ? 'layouts.profesor' : 'layouts.estudiante')

@section('content')
<style>
    .event-detail-container { display: grid; grid-template-columns: 2fr 1fr; gap: 40px; background: #fff; border-radius: 16px; padding: 3rem; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 100%; margin-top: 2rem;}
    .detail-main-content { padding-right: 2rem; border-right: 1px solid rgba(0, 45, 98, 0.1); }
    .detail-main-content h1 { font-size: 3rem; font-weight: 800; color: #002D62; margin-bottom: 0.5rem; }
    .detail-category-tag { display: inline-block; background: #00A86B; color: #fff; padding: 0.4rem 1.5rem; border-radius: 50px; font-weight: 700; text-transform: uppercase; margin-bottom: 1.5rem; }
    .sidebar-box { background: #f9f9f9; border-radius: 12px; padding: 1.8rem; border: 1px solid rgba(0, 45, 98, 0.08); margin-bottom: 25px; }
    .sidebar-box h4 { font-size: 1.2rem; color: #002D62; margin-bottom: 1.2rem; font-weight: 700; border-bottom: 1px dashed #ccc; padding-bottom: 10px;}
    .action-button { font-weight: 700; padding: 1rem; border-radius: 8px; cursor: pointer; border: none; width: 100%; color: white; margin-top: 1rem;}
    .inscrito-btn { background: #00A86B; }
    
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333; }
    .form-control { width: 100%; padding: 0.8rem; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; }
    .alert-success { background: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; }
    
    .foto-perfil-container { display: flex; align-items: center; gap: 20px; margin-bottom: 2rem; }
    .foto-preview { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #002D62; }
    
    .taller-item { padding: 10px; border-bottom: 1px solid #eee; }
    .taller-item:last-child { border-bottom: none; }
    .taller-nombre { font-weight: bold; color: #002D62; display: block; }
    .taller-fecha { font-size: 0.85rem; color: #666; }
</style>

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
    <div class="event-detail-container">
        
        <div class="detail-main-content">
            <h1>Mi Perfil</h1>
            <span class="detail-category-tag">{{ $user->rol }}</span>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li class="font-bold">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Aquí está la ruta dinámica que soluciona el problema --}}
            <form action="{{ Auth::user()->rol === 'profesor' ? route('profesor.profile.update') : route('estudiante.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="foto-perfil-container">
                    @if($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto de perfil" class="foto-preview">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nombre) }}&background=0D8ABC&color=fff" alt="Sin foto" class="foto-preview">
                    @endif
                    
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="foto">Cambiar Fotografía</label>
                        <input type="file" id="foto" name="foto" class="form-control" accept="image/*">
                        <small style="color: #666;">Formatos permitidos: JPG, PNG, WEBP. Max: 2MB.</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" value="{{ old('nombre', $user->nombre) }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="password">Nueva Contraseña (Opcional)</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Escribe aquí solo si deseas cambiarla">
                </div>

                <button type="submit" class="action-button inscrito-btn">Actualizar Perfil</button>
            </form>
        </div>

        <div>
            <div class="sidebar-box">
                <h4>Detalles de la Cuenta</h4>
                <p><strong>Matrícula/ID:</strong> {{ $user->id_usuario }}</p>
                <p><strong>Miembro desde:</strong> {{ \Carbon\Carbon::parse($user->fecha_registro)->format('d/m/Y') }}</p>
            </div>

            <div class="sidebar-box">
                @if($user->rol === 'estudiante')
                    <h4>Mis Talleres Inscritos</h4>
                    
                    {{-- Verificamos si esta inscripto aun taller --}}
                    @if($user->inscripciones->count() > 0)
                        @foreach($user->inscripciones as $inscripcion)
                            <div class="taller-item">
                                <span class="taller-nombre">📌 {{ $inscripcion->evento->nombre ?? 'Evento sin título' }}</span>
                                <span class="taller-fecha">Inscrito el: {{ \Carbon\Carbon::parse($inscripcion->fecha_inscripcion ?? $inscripcion->created_at)->format('d/m/Y') }}</span>
                            </div>
                        @endforeach
                    @else
                        <p style="text-align: center; color: #666; font-style: italic;">Aún no estás inscrito en ningún taller.</p>
                    @endif

                @elseif($user->rol === 'profesor')
                    <h4>Talleres que Imparto</h4>
                    
                    {{-- Verificamos si tiene talleres creados --}}
                    @if($talleres->count() > 0)
                        @foreach($talleres as $taller)
                            <div class="taller-item">
                                <span class="taller-nombre">🎓 {{ $taller->nombre }}</span>
                                <span class="taller-fecha">Inicia: {{ \Carbon\Carbon::parse($taller->fecha_inicio)->format('d/m/Y') }}</span>
                                <span class="taller-fecha" style="display: block; color:#00A86B; font-weight:bold;">Cupos: {{ $taller->inscritos->count() }} / {{ $taller->cupos }}</span>
                            </div>
                        @endforeach
                    @else
                        <p style="text-align: center; color: #666; font-style: italic;">No has creado ningún taller aún.</p>
                    @endif

                @endif
            </div>
        </div>

    </div>
</div>
@endsection