@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Dashboard de Monitoramento</h1>
    <div class="row">
        <div class="col-md-6">
            <canvas id="temperatureChart"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="humidityChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const temperatureData = @json($dados->pluck('temperatura'));
    const humidityData = @json($dados->pluck('umidade'));

    const ctxTemp = document.getElementById('temperatureChart').getContext('2d');
    const ctxHumidity = document.getElementById('humidityChart').getContext('2d');

    new Chart(ctxTemp, {
        type: 'line',
        data: {
            labels: Array.from({ length: temperatureData.length }, (_, i) => i + 1),
            datasets: [{
                label: 'Temperatura',
                data: temperatureData,
                borderColor: 'rgba(255, 99, 132, 1)',
                fill: false,
            }]
        }
    });

    new Chart(ctxHumidity, {
        type: 'line',
        data: {
            labels: Array.from({ length: humidityData.length }, (_, i) => i + 1),
            datasets: [{
                label: 'Umidade',
                data: humidityData,
                borderColor: 'rgba(54, 162, 235, 1)',
                fill: false,
            }]
        }
    });
</script>
@endpush
