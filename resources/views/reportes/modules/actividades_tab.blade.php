<div class="row">
    <div class="col-md-6">
        <canvas id="actividadesChart"></canvas>
    </div>
    <div class="col-md-6">
        <div class="mb-2">
            <a href="{{ route('reportes.export',['tipo'=>'actividades','formato'=>'excel']) }}" class="btn btn-sm btn-success">Exportar Excel</a>
            <a href="{{ route('reportes.export',['tipo'=>'actividades','formato'=>'pdf']) }}" class="btn btn-sm btn-danger">Exportar PDF</a>
        </div>
        <pre id="actividadesContainer">Cargando tabla de actividades...</pre>
    </div>
</div>
<script>
fetchAndRender('/reportes/data/actividades', 'actividadesContainer', function(data){
    const labels = data.byCategory.map(c=>c.categoria);
    const vals = data.byCategory.map(c=>c.total);
    new Chart(document.getElementById('actividadesChart').getContext('2d'), {type:'bar', data:{labels:labels,datasets:[{data:vals}]}});
});
</script>
