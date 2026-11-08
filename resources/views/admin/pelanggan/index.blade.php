@extends('layouts.admin')

@section('title', 'Data Pelanggan')
@section('page_title', 'Data Pelanggan')

@section('content')
    <div class="card-panel">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Daftar Pelanggan</span>
            <a href="{{ route('admin.pelanggan.create') }}" class="btn btn-camp btn-sm">+ Tambah Pelanggan</a>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-2 mb-4">
                <div class="col-md-6">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama, nomor HP, atau identitas">
                </div>
                <div class="col-md-4">
                    <select name="status_verifikasi" class="form-select">
                        <option value="">Semua Status Verifikasi</option>
                        <option value="belum_verifikasi" {{ request('status_verifikasi') === 'belum_verifikasi' ? 'selected' : '' }}>Belum Verifikasi (Menunggu Upgrade Member)</option>
                        <option value="terverifikasi" {{ request('status_verifikasi') === 'terverifikasi' ? 'selected' : '' }}>Terverifikasi (Priority Member)</option>
                        <option value="diblokir" {{ request('status_verifikasi') === 'diblokir' ? 'selected' : '' }}>Diblokir</option>
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-camp">Filter</button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Nomor HP</th>
                            <th>No. Identitas</th>
                            <th>Verifikasi</th>
                            <th>Transaksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggans as $pelanggan)
                            <tr>
                                <td>{{ $pelanggan->nama }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span>{{ $pelanggan->no_hp }}</span>
                                        @if($pelanggan->whatsappUrl())
                                            <a href="{{ $pelanggan->whatsappUrl('Halo Kak ' . $pelanggan->nama . ', kami dari Admin CampSewa.') }}" target="_blank" class="btn-wa-icon" title="Chat WhatsApp">
                                                <i class="bi bi-whatsapp"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $pelanggan->no_identitas }}</td>
                                <td>
                                    <span class="badge {{ $pelanggan->status_verifikasi === 'terverifikasi' ? 'bg-success' : ($pelanggan->isBlocked() ? 'bg-danger' : 'bg-warning text-dark') }}">
                                        {{ ucwords(str_replace('_', ' ', $pelanggan->status_verifikasi ?? 'belum_verifikasi')) }}
                                    </span>
                                </td>
                                <td>{{ $pelanggan->penyewaan_count }}</td>
                                <td>
                                    <div class="d-flex flex-column gap-1" style="width: max-content;">
                                        @if($pelanggan->status_verifikasi !== 'terverifikasi' && !$pelanggan->isBlocked())
                                            <form action="{{ route('admin.pelanggan.verify', $pelanggan->id_pelanggan) }}" method="POST" class="mb-1">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success py-1 px-2 w-100" style="font-size: 0.72rem;" title="Konfirmasi & Verifikasi Member">
                                                    <i class="bi bi-check-circle me-1"></i> Verifikasi
                                                </button>
                                            </form>
                                        @endif
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('admin.pelanggan.show', $pelanggan->id_pelanggan) }}" class="btn-table-action btn-table-detail">Detail</a>
                                            <a href="{{ route('admin.pelanggan.edit', $pelanggan->id_pelanggan) }}" class="btn-table-action btn-table-edit">Edit</a>
                                        </div>
                                        <form action="{{ route('admin.pelanggan.destroy', $pelanggan->id_pelanggan) }}" method="POST" onsubmit="return confirm('Hapus pelanggan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-table-action btn-table-delete w-100">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">Belum ada pelanggan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $pelanggans->links() }}</div>
        </div>
    </div>
@endsection
