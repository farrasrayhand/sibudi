@extends('layouts.app')

@php
    $isPublicGuestForm = $isPublicGuestForm ?? false;
    $pageTitle = $pageTitle ?? 'Tambah Data Tamu';
    $formAction = $formAction ?? route('guestbook.store');
@endphp

@section('title', $pageTitle)

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="mb-0">
            <i class="bi bi-person-plus"></i> {{ $pageTitle }}
        </h2>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="main-content">
            <form action="{{ $formAction }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                           placeholder="Nama lengkap pengunjung" required value="{{ old('name') }}">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   placeholder="email@example.com" required value="{{ old('email') }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="tel" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   placeholder="08XXXXXXXXXX" required value="{{ old('phone') }}">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="organization" class="form-label fw-semibold">Organisasi/Perusahaan <span class="text-danger">*</span></label>
                    <input type="text" id="organization" name="organization" class="form-control @error('organization') is-invalid @enderror" 
                           placeholder="Nama organisasi" required value="{{ old('organization') }}">
                    @error('organization')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="visit_date" class="form-label fw-semibold">Tanggal Kunjungan <span class="text-danger">*</span></label>
                    <input type="date" id="visit_date" name="visit_date" class="form-control @error('visit_date') is-invalid @enderror" 
                           required value="{{ old('visit_date', date('Y-m-d')) }}">
                    @error('visit_date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label fw-semibold">Keperluan/Pesan <span class="text-danger">*</span></label>
                    <textarea id="message" name="message" class="form-control @error('message') is-invalid @enderror" 
                              rows="4" placeholder="Tuliskan keperluan atau pesan Anda" required>{{ old('message') }}</textarea>
                    @error('message')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Foto Tamu</label>
                    <input type="hidden" id="photo" name="photo" value="{{ old('photo') }}">

                    <div class="camera-panel border rounded p-3">
                        <div class="camera-preview mb-3">
                            <video id="cameraStream" class="w-100 rounded d-none" autoplay playsinline></video>
                            <img id="photoPreview" class="w-100 rounded {{ old('photo') ? '' : 'd-none' }}" src="{{ old('photo') }}" alt="Preview foto tamu">
                            <div id="cameraPlaceholder" class="camera-placeholder rounded {{ old('photo') ? 'd-none' : '' }}">
                                <i class="bi bi-camera fs-1"></i>
                                <span>Belum ada foto</span>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" id="startCamera" class="btn btn-outline-primary btn-custom">
                                <i class="bi bi-camera-video"></i> Buka Kamera
                            </button>
                            <button type="button" id="capturePhoto" class="btn btn-primary btn-custom d-none">
                                <i class="bi bi-camera"></i> Ambil Foto
                            </button>
                            <button type="button" id="retakePhoto" class="btn btn-outline-secondary btn-custom {{ old('photo') ? '' : 'd-none' }}">
                                <i class="bi bi-arrow-repeat"></i> Ambil Ulang
                            </button>
                        </div>
                        <small id="cameraMessage" class="text-muted d-block mt-2">
                            Browser akan meminta izin kamera Windows saat tombol dibuka.
                        </small>
                    </div>

                    @error('photo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-custom">
                        <i class="bi bi-check-circle"></i> Simpan
                    </button>
                    @unless($isPublicGuestForm)
                        <a href="{{ route('guestbook.index') }}" class="btn btn-secondary btn-custom">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                    @endunless
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
                Silakan isi semua field dengan data yang akurat. Data ini akan membantu kami melayani Anda dengan lebih baik.
            </p>
            <hr>
            <p class="small text-muted">
                <strong>Catatan:</strong> Semua data yang diisi akan disimpan dan hanya dapat dilihat oleh admin.
            </p>
        </div>
    </div>
</div>
@endsection

@section('extra_css')
<style>
    .camera-preview {
        aspect-ratio: 4 / 3;
        background: #eef2f7;
        overflow: hidden;
    }

    .camera-preview video,
    .camera-preview img,
    .camera-placeholder {
        height: 100%;
        object-fit: cover;
    }

    .camera-placeholder {
        align-items: center;
        color: #6c757d;
        display: flex;
        flex-direction: column;
        gap: 8px;
        justify-content: center;
        min-height: 220px;
    }
</style>
@endsection

@section('extra_js')
<script>
    const startCameraButton = document.getElementById('startCamera');
    const capturePhotoButton = document.getElementById('capturePhoto');
    const retakePhotoButton = document.getElementById('retakePhoto');
    const cameraStream = document.getElementById('cameraStream');
    const photoPreview = document.getElementById('photoPreview');
    const cameraPlaceholder = document.getElementById('cameraPlaceholder');
    const cameraMessage = document.getElementById('cameraMessage');
    const photoInput = document.getElementById('photo');
    let activeStream = null;

    async function startCamera() {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            cameraMessage.textContent = 'Browser ini tidak mendukung akses kamera.';
            cameraMessage.className = 'text-danger d-block mt-2';
            return;
        }

        try {
            activeStream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'user',
                    width: { ideal: 1280 },
                    height: { ideal: 960 }
                },
                audio: false
            });

            cameraStream.srcObject = activeStream;
            cameraStream.classList.remove('d-none');
            photoPreview.classList.add('d-none');
            cameraPlaceholder.classList.add('d-none');
            capturePhotoButton.classList.remove('d-none');
            retakePhotoButton.classList.add('d-none');
            cameraMessage.textContent = 'Kamera aktif. Posisikan wajah lalu klik Ambil Foto.';
            cameraMessage.className = 'text-muted d-block mt-2';
        } catch (error) {
            cameraMessage.textContent = 'Izin kamera ditolak atau kamera tidak tersedia.';
            cameraMessage.className = 'text-danger d-block mt-2';
        }
    }

    function stopCamera() {
        if (activeStream) {
            activeStream.getTracks().forEach(track => track.stop());
            activeStream = null;
        }
    }

    function capturePhoto() {
        const canvas = document.createElement('canvas');
        canvas.width = cameraStream.videoWidth || 1280;
        canvas.height = cameraStream.videoHeight || 960;

        canvas.getContext('2d').drawImage(cameraStream, 0, 0, canvas.width, canvas.height);
        const photoData = canvas.toDataURL('image/jpeg', 0.9);

        photoInput.value = photoData;
        photoPreview.src = photoData;
        photoPreview.classList.remove('d-none');
        cameraStream.classList.add('d-none');
        capturePhotoButton.classList.add('d-none');
        retakePhotoButton.classList.remove('d-none');
        cameraMessage.textContent = 'Foto sudah diambil dan akan ikut tersimpan.';
        cameraMessage.className = 'text-success d-block mt-2';
        stopCamera();
    }

    startCameraButton.addEventListener('click', startCamera);
    retakePhotoButton.addEventListener('click', startCamera);
    capturePhotoButton.addEventListener('click', capturePhoto);
    window.addEventListener('beforeunload', stopCamera);
</script>
@endsection
