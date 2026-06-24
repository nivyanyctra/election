@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Quick Count</h3>
    <span class="badge bg-danger" id="status-indicator">● Live Monitoring</span>
</div>
<div class="row justify-content-center">
    <div class="">
            <h5 class="text-center">Total Suara: <span id="total-suara">0</span></h5>
            <hr>
            <div id="stats-container"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function updateStats() {
        $.get('/api/stats', function(data) {
            $('#total-suara').text(data.total);
            let html = '';
            data.results.forEach(res => {
                html += `
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <strong>${res.name}</strong>
                            <span>${res.votes} Suara (${res.percent}%)</span>
                        </div>
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar bg-info" style="width: ${res.percent}%"></div>
                        </div>
                    </div>
                `;
            });
            $('#stats-container').html(html);
        });
    }
    setInterval(updateStats, 2000);
    updateStats();
</script>

<style>
    #status-indicator {
        animation: blink 1s infinite;
    }
    @keyframes blink {
        0% { opacity: 1; }
        50% { opacity: 0.3; }
        100% { opacity: 1; }
    }
</style>
@endsection
