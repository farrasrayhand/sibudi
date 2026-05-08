@extends('layouts.app')

@section('title', 'Daftar Tamu')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="mb-0">
            <i class="bi bi-book-half"></i> Daftar Tamu
        </h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('guestbook.create') }}" class="btn btn-primary btn-custom">
            <i class="bi bi-plus-circle"></i> Tambah Data Tamu
        </a>
        <a href="{{ route('guestbook.export') }}" class="btn btn-success btn-custom">
            <i class="bi bi-download"></i> Export CSV
        </a>
    </div>
</div>

<div class="main-content">
    @if($guestbooks->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Organisasi</th>
                        <th>Tanggal Kunjungan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($guestbooks as $index => $entry)
                        <tr>
                            <td class="fw-bold">{{ ($guestbooks->currentPage() - 1) * $guestbooks->perPage() + $loop->iteration }}</td>
                            <td>
                                @if($entry->photo)
                                    <img src="{{ asset('storage/' . $entry->photo) }}" alt="Foto {{ $entry->name }}" class="rounded object-fit-cover" width="48" height="48">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $entry->name }}</td>
                            <td>{{ $entry->email }}</td>
                            <td>{{ $entry->phone }}</td>
                            <td>{{ $entry->organization }}</td>
                            <td>{{ \Carbon\Carbon::parse($entry->visit_date)->format('d-m-Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('guestbook.edit', $entry->id) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('guestbook.destroy', $entry->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
                <small class="text-muted">
                    Menampilkan {{ $guestbooks->firstItem() }} sampai {{ $guestbooks->lastItem() }} dari {{ $guestbooks->total() }} data
                </small>
            </div>
            <nav>
                {{ $guestbooks->links('pagination::bootstrap-5') }}
            </nav>
        </div>
    @else
        <div class="alert alert-info text-center py-5">
            <i class="bi bi-info-circle" style="font-size: 2rem;"></i>
            <p class="mt-3 mb-0">Belum ada data tamu. <a href="{{ route('guestbook.create') }}">Tambah data baru</a></p>
        </div>
    @endif
</div>
@endsection
