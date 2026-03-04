@extends(Auth::user()->rol === 'profesor' ? 'layouts.profesor' : 'layouts.estudiante')
@section('title', 'Mi Perfil')

@section('content')
<style>
    .perfil-wrap {
        max-width: 1100px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 2rem;
        align-items: start;
    }

    /* ── Tarjeta lateral (avatar + info) ── */
    .perfil-card-lateral {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,45,98,0.1);
        overflow: hidden;
        position: sticky;
        top: 110px;
    }

    .perfil-card-header {
        background: linear-gradient(135deg, #002D62 0%, #004C99 100%);
        padding: 2.5rem 1.5rem 4rem;
        text-align: center;
        position: relative;
    }

    .perfil-avatar-ring {
        position: relative;
        display: inline-block;
        margin-bottom: 1rem;
    }

    .perfil-avatar {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 8px 24px rgba(0,0,0,0.25);
        display: block;
        cursor: pointer;
        transition: filter 0.25s;
    }

    .perfil-avatar:hover {
        filter: brightness(0.82);
    }

    .avatar-edit-badge {
        position: absolute;
        bottom: 4px;
        right: 4px;
        background: #00A86B;
        color: #fff;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #fff;
        cursor: pointer;
        transition: background 0.2s;
        pointer-events: none;
    }

    .perfil-card-header h2 {
        color: #fff;
        font-size: 1.3rem;
        font-weight: 800;
        margin-bottom: 0.2rem;
    }

    .perfil-rol-badge {
        display: inline-block;
        background: rgba(255,255,255,0.18);
        color: #fff;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 0.3rem 0.9rem;
        border-radius: 50px;
        border: 1px solid rgba(255,255,255,0.3);
    }

    .perfil-card-body {
        padding: 1.5rem;
        margin-top: -2rem;
    }

    .perfil-meta-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f4f8;
        font-size: 0.9rem;
        color: #555;
    }

    .perfil-meta-item:last-child { border-bottom: none; }

    .perfil-meta-item i {
        color: #00A86B;
        flex-shrink: 0;
    }

    .perfil-meta-item strong {
        color: #002D62;
        margin-right: 4px;
    }

    /* ── Talleres sidebar ── */
    .talleres-lista {
        margin-top: 1.2rem;
    }

    .taller-chip {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 0.8rem;
        border-radius: 10px;
        background: #f4f8fd;
        margin-bottom: 0.6rem;
        border-left: 3px solid #00A86B;
        transition: background 0.2s;
    }

    .taller-chip:hover { background: #e6f9f2; }

    .taller-chip-icon {
        font-size: 1.1rem;
        margin-top: 1px;
    }

    .taller-chip-nombre {
        font-weight: 700;
        font-size: 0.9rem;
        color: #002D62;
        display: block;
    }

    .taller-chip-meta {
        font-size: 0.78rem;
        color: #888;
    }

    /* ── Sección formulario ── */
    .perfil-form-section {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,45,98,0.1);
        overflow: hidden;
    }

    .perfil-form-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #f0f4f8;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .perfil-form-header h3 {
        font-size: 1.2rem;
        font-weight: 800;
        color: #002D62;
    }

    .perfil-form-header .header-icon {
        background: linear-gradient(135deg, #002D62, #00A86B);
        color: #fff;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .perfil-form-body {
        padding: 2rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.2rem;
        margin-bottom: 1.2rem;
    }

    .form-row.full { grid-template-columns: 1fr; }

    .field-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .field-group label {
        font-size: 0.82rem;
        font-weight: 700;
        color: #002D62;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .field-input {
        padding: 0.75rem 1rem;
        border: 2px solid #e8eef5;
        border-radius: 10px;
        font-size: 0.95rem;
        color: #333;
        background: #fafcff;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
        width: 100%;
        font-family: inherit;
    }

    .field-input:focus {
        border-color: #00A86B;
        box-shadow: 0 0 0 3px rgba(0,168,107,0.12);
        background: #fff;
    }

    /* ── Zona de foto ── */
    .foto-drop-zone {
        border: 2px dashed #c8d8e8;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s;
        background: #f8fbff;
        position: relative;
    }

    .foto-drop-zone:hover, .foto-drop-zone.drag-over {
        border-color: #00A86B;
        background: #f0fdf8;
    }

    .foto-drop-zone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .foto-drop-preview {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #00A86B;
        margin: 0 auto 0.8rem;
        display: block;
        box-shadow: 0 4px 12px rgba(0,168,107,0.2);
    }

    .foto-drop-text {
        font-size: 0.88rem;
        color: #666;
    }

    .foto-drop-text strong {
        color: #002D62;
        display: block;
        margin-bottom: 2px;
    }

    /* ── Botón guardar ── */
    .btn-guardar {
        background: linear-gradient(135deg, #00A86B, #008855);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 0.9rem 2.5rem;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,168,107,0.35);
    }

    .btn-guardar:hover {
        background: linear-gradient(135deg, #002D62, #004C99);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,45,98,0.35);
    }

    .alert-success {
        background: linear-gradient(135deg, #e6f9f2, #d0f5e8);
        color: #006644;
        border: 1px solid #a3e6cc;
        padding: 1rem 1.2rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .alert-error {
        background: #fff5f5;
        color: #c0392b;
        border: 1px solid #f5b7b1;
        padding: 1rem 1.2rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }

    @media (max-width: 900px) {
        .perfil-wrap { grid-template-columns: 1fr; }
        .perfil-card-lateral { position: static; }
        .form-row { grid-template-columns: 1fr; }
    }
</style>

<div class="perfil-wrap">

    {{-- ── Tarjeta lateral ── --}}
    <aside class="perfil-card-lateral">
        <div class="perfil-card-header">
            <div class="perfil-avatar-ring">
                <img id="avatarPreviewLateral"
                     src="{{ $user->foto ? asset('storage/' . $user->foto) : 'https://ui-avatars.com/api/?name='.urlencode($user->nombre).'&background=002D62&color=fff&size=200' }}"
                     alt="Foto de perfil"
                     class="perfil-avatar">
                <div class="avatar-edit-badge">
                    <i data-feather="camera" style="width:13px; height:13px;"></i>
                </div>
            </div>
            <h2>{{ $user->nombre }}</h2>
            <span class="perfil-rol-badge">
                {{ $user->rol === 'estudiante' ? '🎓 Estudiante' : '👨‍🏫 Profesor' }}
            </span>
        </div>

        <div class="perfil-card-body">
            <div class="perfil-meta-item">
                <i data-feather="mail" style="width:15px; height:15px;"></i>
                <span><strong>Email:</strong> {{ $user->email }}</span>
            </div>
            @if($user->matricula)
            <div class="perfil-meta-item">
                <i data-feather="credit-card" style="width:15px; height:15px;"></i>
                <span><strong>Matrícula:</strong> {{ $user->matricula }}</span>
            </div>
            @endif
            <div class="perfil-meta-item">
                <i data-feather="calendar" style="width:15px; height:15px;"></i>
                <span><strong>Miembro desde:</strong> {{ \Carbon\Carbon::parse($user->fecha_registro)->isoFormat('DD MMM YYYY') }}</span>
            </div>

            <hr style="border: none; border-top: 1px solid #f0f4f8; margin: 1rem 0;">

            @if($user->rol === 'estudiante')
                <p style="font-size:0.8rem; font-weight:700; color:#002D62; text-transform:uppercase; letter-spacing:.5px; margin-bottom:.8rem;">
                    Mis talleres inscritos
                </p>
                <div class="talleres-lista">
                    @if($user->inscripciones && $user->inscripciones->count() > 0)
                        @foreach($user->inscripciones as $inscripcion)
                        <div class="taller-chip">
                            <span class="taller-chip-icon">📌</span>
                            <div>
                                <span class="taller-chip-nombre">{{ $inscripcion->evento->nombre ?? 'Taller' }}</span>
                                <span class="taller-chip-meta">Inscrito el {{ \Carbon\Carbon::parse($inscripcion->fecha_inscripcion ?? $inscripcion->created_at)->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p style="font-size:0.85rem; color:#aaa; font-style:italic; text-align:center; padding: 1rem 0;">
                            Aún no estás inscrito en ningún taller.
                        </p>
                    @endif
                </div>

            @elseif($user->rol === 'profesor')
                <p style="font-size:0.8rem; font-weight:700; color:#002D62; text-transform:uppercase; letter-spacing:.5px; margin-bottom:.8rem;">
                    Talleres que imparto
                </p>
                <div class="talleres-lista">
                    @if($talleres && $talleres->count() > 0)
                        @foreach($talleres as $taller)
                        <div class="taller-chip">
                            <span class="taller-chip-icon">🎓</span>
                            <div>
                                <span class="taller-chip-nombre">{{ $taller->nombre }}</span>
                                <span class="taller-chip-meta">Inicia {{ \Carbon\Carbon::parse($taller->fecha_inicio)->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p style="font-size:0.85rem; color:#aaa; font-style:italic; text-align:center; padding: 1rem 0;">
                            No has creado ningún taller aún.
                        </p>
                    @endif
                </div>
            @endif
        </div>
    </aside>

    {{-- ── Formulario principal ── --}}
    <section class="perfil-form-section">
        <div class="perfil-form-header">
            <div class="header-icon">
                <i data-feather="edit-3" style="width:18px; height:18px;"></i>
            </div>
            <h3>Editar información</h3>
        </div>

        <div class="perfil-form-body">

            @if(session('success'))
                <div class="alert-success">
                    <i data-feather="check-circle" style="width:18px; height:18px; flex-shrink:0;"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert-error">
                    @foreach($errors->all() as $error)
                        <div>• {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ Auth::user()->rol === 'profesor' ? route('profesor.profile.update') : route('estudiante.profile.update') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="perfilForm">
                @csrf
                @method('PATCH')

                {{-- Foto --}}
                <div style="margin-bottom: 1.5rem;">
                    <label style="font-size:0.82rem; font-weight:700; color:#002D62; text-transform:uppercase; letter-spacing:.5px; display:block; margin-bottom:8px;">
                        Fotografía de perfil
                    </label>
                    <div class="foto-drop-zone" id="dropZone">
                        <input type="file" name="foto" id="fotoInput" accept="image/jpeg,image/png,image/webp">
                        <img id="fotoDropPreview"
                             src="{{ $user->foto ? asset('storage/' . $user->foto) : 'https://ui-avatars.com/api/?name='.urlencode($user->nombre).'&background=002D62&color=fff&size=200' }}"
                             class="foto-drop-preview">
                        <div class="foto-drop-text">
                            <strong id="dropLabel">Haz clic o arrastra una imagen aquí</strong>
                            JPG, PNG o WEBP · Máx. 2 MB
                        </div>
                    </div>
                </div>

                {{-- Nombre y email --}}
                <div class="form-row">
                    <div class="field-group">
                        <label for="nombre">Nombre completo</label>
                        <input type="text" id="nombre" name="nombre" class="field-input"
                               value="{{ old('nombre', $user->nombre) }}" required>
                    </div>
                    <div class="field-group">
                        <label for="email">Correo electrónico</label>
                        <input type="email" id="email" name="email" class="field-input"
                               value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>

                {{-- Contraseña --}}
                <div class="form-row full">
                    <div class="field-group">
                        <label for="password">Nueva contraseña <span style="font-weight:400; text-transform:none; color:#aaa;">(dejar vacío para no cambiarla)</span></label>
                        <input type="password" id="password" name="password" class="field-input"
                               placeholder="••••••••">
                    </div>
                </div>

                <div style="display:flex; justify-content:flex-end; margin-top: 0.5rem;">
                    <button type="submit" class="btn-guardar">
                        <i data-feather="save" style="width:16px; height:16px;"></i>
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </section>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof feather !== 'undefined') feather.replace();

    const fotoInput       = document.getElementById('fotoInput');
    const dropPreview     = document.getElementById('fotoDropPreview');
    const lateralPreview  = document.getElementById('avatarPreviewLateral');
    const dropLabel       = document.getElementById('dropLabel');
    const dropZone        = document.getElementById('dropZone');

    function mostrarPreview(file) {
        if (!file || !file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            dropPreview.src    = e.target.result;
            lateralPreview.src = e.target.result;
            dropLabel.textContent = file.name;
        };
        reader.readAsDataURL(file);
    }

    fotoInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            mostrarPreview(this.files[0]);
        }
    });

    dropZone.addEventListener('dragover', function (e) {
        e.preventDefault();
        this.classList.add('drag-over');
    });

    dropZone.addEventListener('dragleave', function () {
        this.classList.remove('drag-over');
    });

    dropZone.addEventListener('drop', function (e) {
        e.preventDefault();
        this.classList.remove('drag-over');
        const file = e.dataTransfer.files[0];
        if (file) {
            const dt = new DataTransfer();
            dt.items.add(file);
            fotoInput.files = dt.files;
            mostrarPreview(file);
        }
    });
});
</script>

@endsection
