@extends('layouts.app')

@section('content')
    <!-- OVERLAY LAYAR KUNCI (Hidden by default) -->
    <div id="lock-screen"
        class="d-none position-fixed top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center bg-dark text-white"
        style="z-index: 9999;">
        <div class="text-center">
            <div class="spinner-border text-success mb-3" style="width: 3rem; height: 3rem;" role="status"></div>
            <h1 class="display-3 fw-bold">TERIMA KASIH!</h1>
            <p class="fs-4">Suara Anda telah direkam secara rahasia.</p>
            <hr class="w-50 mx-auto">
            <p class="text-secondary">Sistem akan siap kembali untuk pemilih berikutnya dalam:</p>
            <h2 id="countdown-timer" class="display-1 fw-bold text-warning">20</h2>
        </div>
    </div>

    <div class="container pb-5">
        <h2 class="text-center mb-5 fw-bold">PILIHAN ANDA MENENTUKAN MASA DEPAN</h2>

        <div class="row justify-content-center g-4">
            @foreach ($candidates as $c)
                <div class="col-md-4">
                    <div class="card candidate-card h-100 shadow border-0" data-id="{{ $c->id }}">
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $c->photo) }}" class="card-img-top"
                                style="">
                            <div class="selected-badge position-absolute top-0 end-0 m-3 d-none">
                                <span class="badge bg-success p-2 px-3">TERPILIH</span>
                            </div>
                        </div>
                        <div class="card-body text-center bg-white">
                            <h3 class="fw-bold m-0 text-uppercase">{{ $c->name }}</h3>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="fixed-bottom bg-white p-4 shadow-lg border-top">
            <div class="container text-center">
                <button id="btn-vote" class="btn btn-success btn-lg px-5 py-3 fw-bold shadow" style="font-size: 1.5rem;"
                    disabled>
                    KONFIRMASI PILIHAN SAYA
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let selectedId = null;

        // 1. Pilih Calon
        $('.candidate-card').click(function() {
            $('.candidate-card').removeClass('selected border-success shadow-lg');
            $('.selected-badge').addClass('d-none');

            $(this).addClass('selected border-success shadow-lg');
            $(this).find('.selected-badge').removeClass('d-none');

            selectedId = $(this).data('id');
            $('#btn-vote').prop('disabled', false).addClass('animate__animated animate__pulse animate__infinite');
        });

        // 2. Klik Vote
        $('#btn-vote').click(function() {
            if (!selectedId) return;

            // Cegah klik ganda di frontend
            const btn = $(this);
            btn.prop('disabled', true).text('Memproses...');

            $.ajax({
                url: '/vote',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    candidate_id: selectedId
                },
                success: function(response) {
                    if (response.status === 'success') {
                        startLockScreen();
                    }
                },
                error: function(xhr) {
                    // Jika kena limit (Cureng Protection)
                    alert(xhr.responseJSON.message || 'Terjadi kesalahan');
                    location.reload();
                }
            });
        });

        // 3. Fungsi Layar Kunci & Timer
        function startLockScreen() {
            $('#lock-screen').removeClass('d-none');
            let count = 20;

            const timer = setInterval(function() {
                count--;
                $('#countdown-timer').text(count);

                if (count <= 0) {
                    clearInterval(timer);
                    // Reset semua state dan refresh halaman untuk pemilih baru
                    window.location.reload();
                }
            }, 1000);
        }
    </script>

    <style>
        .candidate-card {
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 6px solid transparent;
        }

        .candidate-card:hover {
            transform: scale(1.02);
        }

        .candidate-card.selected {
            border-color: #198754 !important;
        }

        body {
            background-color: #f8f9fa;
        }
    </style>
@endsection
