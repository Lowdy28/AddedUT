@extends('layouts.estudiante')
@section('title', 'Dashboard Premium')

@section('content')
<div class="max-w-7xl mx-auto space-y-16">

    {{-- Hero Banner --}}
    <section class="text-center py-20 bg-white/10 backdrop-blur-lg rounded-3xl shadow-xl">
        <h2 class="text-5xl font-extrabold mb-4 animate-bounce">¡Bienvenido, {{ auth()->user()->nombre }}! 🎉</h2>
        <p class="text-xl text-white/80 mb-6 animate-pulse">Descubre eventos, inscríbete y gestiona tu aprendizaje con estilo.</p>
        <a href="#eventos" class="px-8 py-4 bg-yellow-400 text-indigo-900 font-bold rounded-full shadow-lg hover:scale-105 transition-transform">Explorar eventos</a>
    </section>

    {{-- Eventos disponibles --}}
    <section id="eventos">
        <h3 class="text-3xl font-bold mb-8">Eventos Disponibles</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($eventos as $evento)
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 shadow-lg hover:scale-105 transition-transform hover:shadow-2xl">
                    <h4 class="font-bold text-2xl mb-2">{{ $evento->nombre }}</h4>
                    <p class="text-white/80 mb-3">{{ Str::limit($evento->descripcion, 120) }}</p>
                    <p class="mb-1"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('d/m/Y') }}</p>
                    <p class="mb-3"><strong>Cupos:</strong> {{ $evento->cupo_disponible ?? $evento->cupos }}</p>

                    <form method="POST" action="{{ route('estudiante.inscripciones.store', $evento->id_evento) }}">
                        @csrf
                        <input type="hidden" name="id_usuario" value="{{ auth()->user()->id_usuario }}">
                        <input type="hidden" name="id_evento" value="{{ $evento->id_evento }}">
                        <button type="submit" class="w-full py-2 mt-2 rounded-full bg-green-500 text-white font-semibold hover:bg-green-600 transition-colors shadow-md">
                            Inscribirme
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $eventos->links() }}
        </div>
    </section>

    {{-- Mis inscripciones --}}
    <section class="mt-16">
        <h3 class="text-3xl font-bold mb-6">Mis Inscripciones</h3>
        <ul class="space-y-4">
            @forelse($misInscripciones as $insc)
                <li class="bg-white/10 backdrop-blur-md rounded-xl p-4 flex justify-between items-center shadow-md hover:shadow-xl transition-shadow">
                    <div>
                        <h4 class="font-semibold text-lg">{{ $insc->evento->nombre ?? 'Evento eliminado' }}</h4>
                        <p class="text-white/80 text-sm">{{ \Carbon\Carbon::parse($insc->fecha_inscripcion)->format('d/m/Y H:i') }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full font-semibold {{ $insc->estado == 'confirmada' ? 'bg-green-500' : 'bg-yellow-500' }}">
                        {{ ucfirst($insc->estado) }}
                    </span>
                </li>
            @empty
                <li class="text-white/80">Aún no tienes inscripciones.</li>
            @endforelse
        </ul>
    </section>

</div>
@endsection
