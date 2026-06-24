@extends('layouts.admin')
@section('content')
    <div class="container">
        <h3>Quick Count Realtime</h3>
        <div class="card p-4 shadow">
            <div id="stats-container"></div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function updateStats() {
        $.get('/api/stats', function(data) {
            let html = '';
            data.results.forEach(res => {
                html += `<div class="mb-3">
                    <label>${res.name} (${res.percent}%)</label>
                    <div class="progress"><div class="progress-bar bg-success" style="width: ${res.percent}%"></div></div>
                </div>`;
            });
            $('#stats-container').html(html);
        });
    }
    setInterval(updateStats, 2000);
    updateStats();
</script>
@endsection
