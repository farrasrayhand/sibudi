@extends('layouts.app')

@section('title', 'Edit Data Tamu')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="mb-0">
            <i class="bi bi-pencil-square"></i> Edit Data Tamu
        </h2>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="main-content">
            <form action="{{ route('guestbook.update', $guestbook->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                           placeholder="Nama lengkap pengunjung" required value="{{ old('name', $guestbook->name) }}">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   placeholder="email@example.com" required value="{{ old('email', $guestbook->email) }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="tel" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   placeholder="08XXXXXXXXXX" required value="{{ old('phone', $guestbook->phone) }}">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="organization" class="form-label fw-semibold">Organisasi/Perusahaan <span class="text-danger">*</span></label>
                    <input type="text" id="organization" name="organization" class="form-control @error('organization') is-invalid @enderror" 
                           placeholder="Nama organisasi" required value="{{ old('organization', $guestbook->organization) }}">
                    @error('organization')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="visit_date" class="form-label fw-semibold">Tanggal Kunjungan <span class="text-danger">*</span></label>
                    <input type="date" id="visit_date" name="visit_date" class="form-control @error('visit_date') is-invalid @enderror" 
                           required value="{{ old('visit_date', $guestbook->visit_date) }}">
                    @error('visit_date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label fw-semibold">Keperluan/Pesan <span class="text-danger">*</span></label>
                    <textarea id="message" name="message" class="form-control @error('message') is-invalid @enderror" 
                              rows="4" placeholder="Tuliskan keperluan atau pesan Anda" required>{{ old('message', $guestbook->message) }}</textarea>
                    @error('message')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="pending" {{ old('status', $guestbook->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ old('status', $guestbook->status) == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ old('status', $guestbook->status) == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    @error('status')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-custom">
                        <i class="bi bi-check-circle"></i> Perbarui
                    </button>
                    <a href="{{ route('guestbook.index') }}" class="btn btn-secondary btn-custom">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="sidebar">
            <h5 class="fw-bold mb-3">
                <i class="bi bi-info-circle"></i> Informasi
            </h5>
            <p class="small text-muted mb-3">
                Perbarui data tamu sesuai kebutuhan.
            </p>
            <hr>
            <div class="small">
                <p><strong>Dibuat:</strong><br>
                <span class="text-muted">{{ $guestbook->created_at->format('d-m-Y H:i') }}</span></p>
                <p><strong>Diperbarui:</strong><br>
                <span class="text-muted">{{ $guestbook->updated_at->format('d-m-Y H:i') }}</span></p>
            </div>
        </div>
    </div>
</div>
@endsection
