@extends('layouts.admin')

@section('title', 'Proses Pengembalian')
@section('page_title', 'Proses Pengembalian')

@section('content')
    <div class="card-panel">
        <div class="card-header">Form Pengembalian {{ $penyewaan->id_sewa }}</div>
        <div class="card-body">
            <form action="{{ route('admin.pengembalian.simpan', $penyewaan->id_sewa) }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Kembali Aktual</label>
                        <input type="date" name="tgl_kembali_aktual" class="form-control" value="{{ today()->toDateString() }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Denda</label>
                        <input type="number" name="denda" class="form-control" min="0" value="{{ $estimasiDenda ?? 0 }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pelanggan</label>
                        <input type="text" class="form-control" value="{{ $penyewaan->pelanggan?->nama ?? '-' }}" readonly>
                    </div>
                </div>
                <div class="mt-4">
                    <h6>Daftar Alat</h6>
                    @foreach($penyewaan->details as $detail)
                        <div class="border rounded p-3 mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>{{ $detail->alat?->nama_alat ?? '-' }}</strong>
                                <span class="badge bg-secondary">{{ $detail->jumlah }} unit</span>
                            </div>
                            <input type="text" name="kondisi_alat[{{ $detail->id_alat }}]" class="form-control mt-2" placeholder="Kondisi alat (Baik/Rusak)" value="Baik">
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-camp">Simpan Pengembalian</button>
                    <a href="{{ route('admin.pengembalian.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
