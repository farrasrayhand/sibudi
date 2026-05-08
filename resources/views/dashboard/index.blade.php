@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="mb-0">
            <i class="bi bi-speedometer2"></i> Dashboard Admin
        </h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('guestbook.create') }}" class="btn btn-primary btn-custom">
            <i class="bi bi-plus-circle"></i> Tambah Tamu
        </a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="summary-card">
            <div class="summary-icon bg-primary-subtle text-primary">
                <i class="bi bi-person-badge"></i>
            </div>
            <div>
                <small class="text-muted">Status Pegawai</small>
                <h3>{{ $employmentStatuses->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="summary-card">
            <div class="summary-icon bg-success-subtle text-success">
                <i class="bi bi-diagram-3"></i>
            </div>
            <div>
                <small class="text-muted">Bidang</small>
                <h3>{{ $bidangs->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="summary-card">
            <div class="summary-icon bg-warning-subtle text-warning">
                <i class="bi bi-people"></i>
            </div>
            <div>
                <small class="text-muted">Nama Personil</small>
                <h3>{{ $personils->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="summary-card">
            <div class="summary-icon bg-info-subtle text-info">
                <i class="bi bi-journal-text"></i>
            </div>
            <div>
                <small class="text-muted">Data Tamu</small>
                <h3>{{ $guestbooks->count() }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="main-content">
    <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="status-tab" data-bs-toggle="tab" data-bs-target="#status-pane" type="button" role="tab">
                <i class="bi bi-person-badge"></i> PNS & P3K
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="bidang-tab" data-bs-toggle="tab" data-bs-target="#bidang-pane" type="button" role="tab">
                <i class="bi bi-diagram-3"></i> Bidang
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="personil-tab" data-bs-toggle="tab" data-bs-target="#personil-pane" type="button" role="tab">
                <i class="bi bi-people"></i> Nama
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tamu-tab" data-bs-toggle="tab" data-bs-target="#tamu-pane" type="button" role="tab">
                <i class="bi bi-journal-text"></i> Data Tamu
            </button>
        </li>
    </ul>

    <div class="tab-content pt-4" id="dashboardTabsContent">
        <div class="tab-pane fade show active" id="status-pane" role="tabpanel" aria-labelledby="status-tab" tabindex="0">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Table PNS dan P3K</h5>
                <span class="badge bg-primary">{{ $employmentStatuses->sum('personils_count') }} personil</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Status</th>
                            <th class="text-end">Jumlah Personil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employmentStatuses as $status)
                            <tr>
                                <td class="fw-bold">{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge {{ $status->name === 'PNS' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $status->name }}
                                    </span>
                                </td>
                                <td class="text-end">{{ $status->personils_count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">Belum ada data status pegawai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="bidang-pane" role="tabpanel" aria-labelledby="bidang-tab" tabindex="0">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Table Bidang</h5>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-success">{{ $bidangs->count() }} bidang</span>
                    <a href="{{ route('bidang.create') }}" class="btn btn-sm btn-primary btn-custom">
                        <i class="bi bi-plus-circle"></i> Tambah Bidang
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama Bidang</th>
                            <th class="text-end">Jumlah Personil</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bidangs as $bidang)
                            <tr>
                                <td class="fw-bold">{{ $loop->iteration }}</td>
                                <td>{{ $bidang->name }}</td>
                                <td class="text-end">{{ $bidang->personils_count }}</td>
                                <td class="text-end">
                                    <a href="{{ route('bidang.edit', $bidang) }}" class="btn btn-sm btn-outline-primary" title="Edit bidang">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Belum ada data bidang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="personil-pane" role="tabpanel" aria-labelledby="personil-tab" tabindex="0">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Table Nama Personil</h5>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-warning text-dark">{{ $personils->count() }} nama</span>
                    <a href="{{ route('personil.create') }}" class="btn btn-sm btn-primary btn-custom">
                        <i class="bi bi-plus-circle"></i> Tambah Nama
                    </a>
                </div>
            </div>
            <div class="table-responsive dashboard-table">
                <table class="table table-hover table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Bidang</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($personils as $personil)
                            <tr>
                                <td class="fw-bold">{{ $loop->iteration }}</td>
                                <td>{{ $personil->name }}</td>
                                <td>{{ $personil->bidang?->name ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $personil->employmentStatus?->name === 'PNS' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $personil->employmentStatus?->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('personil.edit', $personil) }}" class="btn btn-sm btn-outline-primary" title="Edit nama">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada data personil.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="tamu-pane" role="tabpanel" aria-labelledby="tamu-tab" tabindex="0">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <h5 class="fw-bold mb-0">Table Data Tamu</h5>
                <span class="badge bg-info text-dark">{{ $guestbooks->count() }} data ditampung</span>
            </div>
            <div class="table-responsive dashboard-table">
                <table class="table table-hover table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Organisasi</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guestbooks as $guestbook)
                            <tr>
                                <td class="fw-bold">{{ $loop->iteration }}</td>
                                <td>
                                    @if($guestbook->photo)
                                        <img src="{{ asset('storage/' . $guestbook->photo) }}" alt="Foto {{ $guestbook->name }}" class="rounded object-fit-cover" width="42" height="42">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $guestbook->name }}</td>
                                <td>{{ $guestbook->email }}</td>
                                <td>{{ $guestbook->phone }}</td>
                                <td>{{ $guestbook->organization }}</td>
                                <td>{{ \Carbon\Carbon::parse($guestbook->visit_date)->format('d-m-Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada data tamu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_css')
<style>
    .summary-card {
        align-items: center;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
        gap: 14px;
        min-height: 104px;
        padding: 18px;
    }

    .summary-card h3 {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
        margin: 6px 0 0;
    }

    .summary-icon {
        align-items: center;
        border-radius: 8px;
        display: flex;
        flex: 0 0 52px;
        font-size: 1.6rem;
        height: 52px;
        justify-content: center;
        width: 52px;
    }

    .dashboard-table {
        max-height: 560px;
        overflow: auto;
    }

    .dashboard-table thead th {
        position: sticky;
        top: 0;
        z-index: 1;
    }
</style>
@endsection
