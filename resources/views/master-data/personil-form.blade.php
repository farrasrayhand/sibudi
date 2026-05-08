@extends('layouts.app')

@section('title', $pageTitle)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">
                <i class="bi bi-person-plus"></i> {{ $pageTitle }}
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
                    <label for="name" class="form-label fw-semibold">Nama Personil <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $personil->name) }}" placeholder="Nama lengkap personil" required autofocus>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-7">
                        <div class="mb-3">
                            <label for="bidang_id" class="form-label fw-semibold">Bidang <span class="text-danger">*</span></label>
                            <select id="bidang_id" name="bidang_id" class="form-select @error('bidang_id') is-invalid @enderror" required>
                                <option value="">Pilih bidang</option>
                                @foreach($bidangs as $bidang)
                                    <option value="{{ $bidang->id }}" {{ (string) old('bidang_id', $personil->bidang_id) === (string) $bidang->id ? 'selected' : '' }}>
                                        {{ $bidang->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bidang_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="mb-3">
                            <label for="employment_status_id" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <select id="employment_status_id" name="employment_status_id" class="form-select @error('employment_status_id') is-invalid @enderror" required>
                                <option value="">Pilih status</option>
                                @foreach($employmentStatuses as $status)
                                    <option value="{{ $status->id }}" {{ (string) old('employment_status_id', $personil->employment_status_id) === (string) $status->id ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('employment_status_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
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
