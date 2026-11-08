@extends('layouts.admin')

@section('title', 'Detail Pelanggan')
@section('page_title', 'Detail Pelanggan')

@section('content')
    <div class="row g-4">
        <div class="col-xl-4">
            <div class="card-panel">
                <div class="card-header">Profil Pelanggan</div>
                <div class="card-body">
                    <h5>{{ $pelanggan->nama }}</h5>
                    <p class="mb-1"><strong>HP:</strong> {{ $pelanggan->no_hp }}</p>
                    <p class="mb-1"><strong>Identitas:</strong> {{ $pelanggan->no_identitas }}</p>
                    <p class="mb-1"><strong>Alamat:</strong> {{ $pelanggan->alamat ?? '-' }}</p>
                    <p class="mb-1">
                        <strong>Status verifikasi:</strong>
                        <span class="badge {{ $pelanggan->status_verifikasi === 'terverifikasi' ? 'bg-success' : ($pelanggan->isBlocked() ? 'bg-danger' : 'bg-warning text-dark') }}">
                            {{ ucwords(str_replace('_', ' ', $pelanggan->status_verifikasi ?? 'belum_verifikasi')) }}
                        </span>
                    </p>
                    <p class="mb-3"><strong>Akun:</strong> {{ $pelanggan->user?->email ?? 'Belum terhubung' }}</p>
                    <div class="d-flex flex-wrap gap-2">
                        @if($pelanggan->status_verifikasi !== 'terverifikasi' && !$pelanggan->isBlocked())
                            <form action="{{ route('admin.pelanggan.verify', $pelanggan) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="bi bi-check-circle me-1"></i> Verifikasi akun (Member)
                                </button>
                            </form>
                        @endif
                        @if($pelanggan->whatsappUrl())
                            <a href="{{ $pelanggan->whatsappUrl('Halo Kak ' . $pelanggan->nama . ', kami dari Admin CampSewa.') }}" target="_blank" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-whatsapp me-1"></i> Chat WhatsApp
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card-panel">
                <div class="card-header">Riwayat Penyewaan</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>ID Sewa</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Biaya</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pelanggan->penyewaan as $sewa)
                                    <tr>
                                        <td>{{ $sewa->id_sewa }}</td>
                                        <td>{{ \Carbon\Carbon::parse($sewa->tgl_sewa)->translatedFormat('d M Y') }}</td>
                                        <td><span class="badge {{ $sewa->status === 'Berjalan' ? 'bg-warning text-dark' : 'bg-success' }}">{{ $sewa->status }}</span></td>
                                        <td>Rp {{ number_format($sewa->total_biaya ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada transaksi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
