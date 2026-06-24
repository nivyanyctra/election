@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Log Voting Real-Time</h3>
    <span class="badge bg-danger" id="status-indicator">● Live Monitoring</span>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Waktu Relatif</th>
                    <th>Pilihan Calon</th>
                    <th>Detail Waktu</th>
                </tr>
            </thead>
            <tbody id="log-table-body">
                <tr>
                    <td colspan="3" class="text-center">Memuat data...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function updateLogs() {
        $.get('/api/admin/logs', function(data) {
            let html = '';

            if (data.length === 0) {
                html = '<tr><td colspan="3" class="text-center">Belum ada voting masuk.</td></tr>';
            } else {
                data.forEach(log => {
                    html += `
                    <tr>
                        <td><span class="text-muted small">${log.time_ago}</span></td>
                        <td>
                            <strong class="text-primary">${log.candidate_name}</strong>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                ${log.formatted_time} WIB
                            </span>
                        </td>
                    </tr>
                    `;
                });
            }

            // Masukkan ke dalam tabel
            $('#log-table-body').html(html);
        });
    }

    // Jalankan pertama kali saat halaman dibuka
    updateLogs();

    // Jalankan setiap 2 detik (2000 ms)
    setInterval(updateLogs, 2000);
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
