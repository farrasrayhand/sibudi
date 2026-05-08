@extends('layouts.app')

@section('title', $pageTitle)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">
                <i class="bi bi-diagram-3"></i> {{ $pageTitle }}
            </h2>
            <a href="{{ route('dashboard.index') }}" class="btn btn-outline-secondary btn-custom">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="main-content">
            <form action="{{ $formAction }}" method="POST">
                @csrf
                @if($formMethod === 'PUT')
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nama Bidang <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $bidang->name) }}" placeholder="Contoh: BIDANG PEMBINAAN SMA" required autofocus>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-custom">
                        <i class="bi bi-check-circle"></i> Simpan
                    </button>
                    <a href="{{ route('dashboard.index') }}" class="btn btn-secondary btn-custom">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
