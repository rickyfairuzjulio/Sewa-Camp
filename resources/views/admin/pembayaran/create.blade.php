@extends('layouts.admin')

@section('title', 'Catat Pembayaran')
@section('page_title', 'Catat Pembayaran')

@section('content')
    <div class="card-panel">
        <div class="card-header">Form Pembayaran</div>
        <div class="card-body">
            <form action="{{ route('admin.pembayaran.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Transaksi Sewa</label>
                        <select name="id_sewa" class="form-select" required>
                            <option value="">Pilih penyewaan</option>
                            @foreach($penyewaans as $sewa)
                                <option value="{{ $sewa->id_sewa }}" {{ old('id_sewa', $selectedSewa?->id_sewa) == $sewa->id_sewa ? 'selected' : '' }}>
                                    {{ $sewa->id_sewa }} - {{ $sewa->pelanggan?->nama ?? '-' }} (Sisa: Rp {{ number_format($sewa->sisa_tagihan, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Bayar</label>
                        <input type="date" name="tgl_bayar" class="form-control" value="{{ old('tgl_bayar', today()->toDateString()) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jumlah Bayar</label>
                        <input type="number" name="jumlah_bayar" class="form-control" min="1000" value="{{ old('jumlah_bayar', $selectedSewa ? (int) $selectedSewa->sisa_tagihan : '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Metode</label>
                        <select name="metode" class="form-select" required>
                            <option value="Tunai" {{ old('metode') === 'Tunai' ? 'selected' : '' }}>Tunai</option>
                            <option value="Midtrans" {{ old('metode') === 'Midtrans' ? 'selected' : '' }}>Midtrans</option>
                            <option value="Transfer Bank" {{ old('metode') === 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                            <option value="QRIS" {{ old('metode') === 'QRIS' ? 'selected' : '' }}>QRIS</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-camp">Simpan</button>
                    <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
