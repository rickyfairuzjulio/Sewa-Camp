@extends('layouts.admin')

@section('title', 'Pengembalian Alat')
@section('page_title', 'Pengembalian Alat')

@section('content')
    <div class="card-panel">
        <div class="card-header">Daftar Penyewaan yang Masih Berjalan</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID Sewa</th>
                            <th>Pelanggan</th>
                            <th>Jadwal Kembali</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penyewaans as $sewa)
                            <tr>
                                <td>{{ $sewa->id_sewa }}</td>
                                <td>{{ $sewa->pelanggan?->nama ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($sewa->tgl_kembali_rencana)->translatedFormat('d M Y') }}</td>
                                <td><span class="badge {{ $sewa->tgl_kembali_rencana < now()->toDateString() ? 'bg-danger' : 'bg-warning text-dark' }}">{{ $sewa->tgl_kembali_rencana < now()->toDateString() ? 'Terlambat' : 'Berjalan' }}</span></td>
                                <td><a href="{{ route('admin.pengembalian.proses', $sewa->id_sewa) }}" class="btn btn-sm btn-camp">Proses</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada penyewaan yang perlu dikembalikan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $penyewaans->links() }}</div>
        </div>
    </div>
@endsection
