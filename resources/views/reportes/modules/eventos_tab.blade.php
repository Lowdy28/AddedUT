<div class="row">
    <div class="col-md-6">
        <canvas id="eventosChart"></canvas>
    </div>
    <div class="col-md-6">
        <div class="mb-2">
            <a href="{{ route('reportes.export',['tipo'=>'eventos','formato'=>'excel']) }}" class="btn btn-sm btn-success">Exportar Excel</a>
            <a href="{{ route('reportes.export',['tipo'=>'eventos','formato'=>'pdf']) }}" class="btn btn-sm btn-danger">Exportar PDF</a>
        </div>
        <pre id="eventosContainer">Cargando tabla de eventos...</pre>
    </div>
</div>
<script>
fetchAndRender('/reportes/data/eventos', 'eventosContainer', function(data){
    const labels = data.porMes.map(m=>m.mes);
    const vals = data.porMes.map(m=>m.total);
    new Chart(document.getElementById('eventosChart').getContext('2d'), {type:'line', data:{labels:labels,datasets:[{data:vals, fill:false}]}});
});
</script>
