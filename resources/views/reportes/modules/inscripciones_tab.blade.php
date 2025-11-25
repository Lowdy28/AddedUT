<div class="row">
    <div class="col-md-6">
        <canvas id="inscripcionesChart"></canvas>
    </div>
    <div class="col-md-6">
        <div class="mb-2">
            <a href="{{ route('reportes.export',['tipo'=>'inscripciones','formato'=>'excel']) }}" class="btn btn-sm btn-success">Exportar Excel</a>
            <a href="{{ route('reportes.export',['tipo'=>'inscripciones','formato'=>'pdf']) }}" class="btn btn-sm btn-danger">Exportar PDF</a>
        </div>
        <pre id="inscripcionesContainer">Cargando tabla de inscripciones...</pre>
    </div>
</div>
<script>
fetchAndRender('/reportes/data/inscripciones', 'inscripcionesContainer', function(data){
    const labels = data.porEvento.map(e=>e.id_evento);
    const vals = data.porEvento.map(e=>e.total);
    new Chart(document.getElementById('inscripcionesChart').getContext('2d'), {type:'bar', data:{labels:labels,datasets:[{data:vals}]}});
});
</script>
