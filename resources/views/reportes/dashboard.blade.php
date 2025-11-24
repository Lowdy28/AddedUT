@extends('layouts.admin')

@section('content')

<h1 class="text-3xl font-bold text-white mb-8">Panel de Reportes - AddedUT</h1>

<!-- ========================== -->
<!-- TARJETAS DE RESUMEN -->
<!-- ========================== -->

<div class="grid grid-cols-1 md:grid-cols-5 gap-5 mb-10">
    
    <div class="bg-white rounded-xl shadow p-5">
        <h5 class="text-gray-500 text-sm">Usuarios</h5>
        <h2 class="text-3xl font-bold text-gray-800">{{ $totalUsuarios }}</h2>
    </div>
    
    <div class="bg-white rounded-xl shadow p-5">
        <h5 class="text-gray-500 text-sm">Profesores</h5>
        <h2 class="text-3xl font-bold text-gray-800">{{ $totalProfesores }}</h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <h5 class="text-gray-500 text-sm">Estudiantes</h5>
        <h2 class="text-3xl font-bold text-gray-800">{{ $totalEstudiantes }}</h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <h5 class="text-gray-500 text-sm">Inscripciones</h5>
        <h2 class="text-3xl font-bold text-gray-800">{{ $totalInscripciones }}</h2>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <h5 class="text-gray-500 text-sm">Eventos</h5>
        <h2 class="text-3xl font-bold text-gray-800">{{ $totalEventos }}</h2>
    </div>

</div>

<!-- ========================== -->
<!-- TABS DE SECCIONES -->
<!-- ========================== -->

<div class="bg-white rounded-xl shadow p-4 mb-6 mt-6">

    <div class="flex gap-4 border-b pb-2">

        <button class="tab-btn text-gray-700 font-semibold px-4 py-2 active" data-tab="usuarios">
            Usuarios
        </button>

        <button class="tab-btn text-gray-700 font-semibold px-4 py-2" data-tab="eventos">
            Eventos
        </button>

        <button class="tab-btn text-gray-700 font-semibold px-4 py-2" data-tab="inscripciones">
            Inscripciones
        </button>

    </div>
</div>


<!-- ========================== -->
<!-- CONTENIDO DE CADA TAB -->
<!-- ========================== -->

<div id="tabContent" class="text-black">

    <!-- ======= USUARIOS ======= -->
    <div class="tab-section block" id="usuarios">

        <div class="bg-white rounded-xl shadow p-6 mb-10">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Reporte de Usuarios</h2>

                <div class="flex gap-2">
                    <a href="{{ route('reportes.export', ['tipo' => 'usuarios', 'formato' => 'pdf']) }}"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Exportar PDF
                    </a>

                    <a href="{{ route('reportes.export', ['tipo' => 'usuarios', 'formato' => 'xlsx']) }}"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Exportar Excel
                    </a>
                </div>
            </div>

            <canvas id="chartUsuarios" class="my-6" style="max-width: 1000px; height: 900px;"></canvas>
            <div id="tablaUsuarios" class="mt-4 text-sm bg-gray-100 p-4 rounded"></div>
        </div>

    </div>

    <!-- ======= EVENTOS ======= -->
    <div class="tab-section hidden" id="eventos">

        <div class="bg-white rounded-xl shadow p-6 mb-10">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Reporte de Eventos</h2>

                <div class="flex gap-2">
                    <a href="{{ route('reportes.export', ['tipo' => 'eventos', 'formato' => 'pdf']) }}"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Exportar PDF
                    </a>

                    <a href="{{ route('reportes.export', ['tipo' => 'eventos', 'formato' => 'xlsx']) }}"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Exportar Excel
                    </a>
                </div>
            </div>

            <canvas id="chartEventos" class="my-6" style="max-width: 1000px; height: 900px;"></canvas>
            <div id="tablaEventos" class="mt-4 text-sm bg-gray-100 p-4 rounded"></div>
        </div>

    </div>

    <!-- ======= INSCRIPCIONES ======= -->
    <div class="tab-section hidden" id="inscripciones">

        <div class="bg-white rounded-xl shadow p-6 mb-10">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Reporte de Inscripciones</h2>

                <div class="flex gap-2">
                    <a href="{{ route('reportes.export', ['tipo' => 'inscripciones', 'formato' => 'pdf']) }}"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Exportar PDF
                    </a>

                    <a href="{{ route('reportes.export', ['tipo' => 'inscripciones', 'formato' => 'xlsx']) }}"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Exportar Excel
                    </a>
                </div>
            </div>

            <canvas id="chartInscripciones" class="my-6" style="max-width: 1000px; height: 900px;"></canvas>
            <div id="tablaInscripciones" class="mt-4 text-sm bg-gray-100 p-4 rounded"></div>
        </div>

    </div>

</div>

<!-- ========================== -->
<!-- SCRIPT DE TABS Y GRÁFICAS -->
<!-- ========================== -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.querySelectorAll(".tab-btn").forEach(btn => {
    btn.addEventListener("click", () => {
        document.querySelectorAll(".tab-btn").forEach(b => b.classList.remove("active"));
        document.querySelectorAll(".tab-section").forEach(s => s.classList.add("hidden"));

        btn.classList.add("active");
        document.getElementById(btn.dataset.tab).classList.remove("hidden");
    });
});

// ==============================
// FUNCIÓN PARA GRÁFICAS
// ==============================
function cargarDatos(url, container, chartId) {
    fetch(url)
        .then(response => response.json())
        .then(data => {

            // Mostrar tabla
            document.getElementById(container).innerHTML =
                "<pre>" + JSON.stringify(data.table.data || data.table, null, 2) + "</pre>";


            // -------- Detectar AUTOMÁTICAMENTE qué estructura trae --------
            let labels = [];
            let values = [];

            if (data.byRole) {
                labels = data.byRole.map(x => x.rol);
                values = data.byRole.map(x => x.total);
            }

            else if (data.byCategory) {
                labels = data.byCategory.map(x => x.categoria);
                values = data.byCategory.map(x => x.total);
            }

            else if (data.porEvento) {
                labels = data.porEvento.map(x => "Evento " + x.id_evento);
                values = data.porEvento.map(x => x.total);
            }

            else if (data.porMes) {
                labels = data.porMes.map(x => x.mes);
                values = data.porMes.map(x => x.total);
            }

            else {
                labels = ["Datos"];
                values = [1];
            }


            // -------- EVITAR QUE SE SUPERPONGAN GRÁFICAS --------
            const oldCanvas = document.getElementById(chartId);
            const newCanvas = oldCanvas.cloneNode(true);
            oldCanvas.parentNode.replaceChild(newCanvas, oldCanvas);

            // -------- Dibujar gráfica --------
            new Chart(newCanvas, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values
                    }]
                }
            });

        });
}

// Cargar datos
cargarDatos('/reportes/data/usuarios', 'tablaUsuarios', 'chartUsuarios');
cargarDatos('/reportes/data/eventos', 'tablaEventos', 'chartEventos');
cargarDatos('/reportes/data/inscripciones', 'tablaInscripciones', 'chartInscripciones');

</script>

@endsection
