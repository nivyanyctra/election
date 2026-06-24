@extends('layouts.app')
@section('content')
    <h2 class="text-center mb-4">Silakan Pilih Calon</h2>
    <div class="row justify-content-center">
        @foreach ($candidates as $c)
            <div class="col-md-4 mb-4">
                <div class="card candidate-card h-100 shadow-sm" data-id="{{ $c->id }}">
                    <img src="{{ asset('storage/' . $c->photo) }}" class="card-img-top"
                        style="object-fit: cover;">
                    <div class="card-body text-center">
                        <h4 class="fw-bold">{{ $c->name }}</h4>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="text-center mt-4 mb-5">
        <button id="btn-vote" class="btn btn-success btn-lg px-5" disabled>VOTE SEKARANG</button>
    </div>
@endsection

@section('scripts')
    <script>
        let selectedId = null;
        $('.candidate-card').click(function() {
            $('.candidate-card').removeClass('selected');
            $(this).addClass('selected');
            selectedId = $(this).data('id');
            $('#btn-vote').prop('disabled', false);
        });

        $('#btn-vote').click(function() {
            $.post('/vote', {
                _token: $('meta[name="csrf-token"]').attr('content'),
                candidate_id: selectedId
            }, function() {
                Swal.fire('Berhasil!', 'Terima kasih sudah voting!', 'success').then(() => {
                    location.reload();
                });
            });
        });
    </script>
@endsection
