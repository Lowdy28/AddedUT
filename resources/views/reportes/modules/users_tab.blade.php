<div class="row">
    <div class="col-md-6">
        <canvas id="usersChart"></canvas>
    </div>
    <div class="col-md-6">
        <div class="mb-2">
            <a href="{{ route('reportes.export',['tipo'=>'usuarios','formato'=>'excel']) }}" class="btn btn-sm btn-success">Exportar Excel</a>
            <a href="{{ route('reportes.export',['tipo'=>'usuarios','formato'=>'pdf']) }}" class="btn btn-sm btn-danger">Exportar PDF</a>
        </div>
        <pre id="usersContainer">Cargando tabla de usuarios...</pre>
    </div>
</div>
