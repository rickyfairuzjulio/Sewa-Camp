@extends('layouts.admin')

@section('title', 'Buat Transaksi Sewa')
@section('page_title', 'Buat Transaksi Sewa')

@section('content')
    <div class="card-panel">
        <div class="card-header">Form Penyewaan Baru</div>
        <div class="card-body">
            <form action="{{ route('admin.penyewaan.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Tipe Pelanggan</label>
                        <select name="pelanggan_type" id="pelanggan-type" class="form-select" required>
                            <option value="existing" {{ old('pelanggan_type', 'existing') === 'existing' ? 'selected' : '' }}>Pelanggan Terdaftar</option>
                            <option value="new" {{ old('pelanggan_type') === 'new' ? 'selected' : '' }}>Pelanggan Baru</option>
                        </select>
                    </div>
                    <div class="col-md-4" id="existing-customer-group">
                        <label class="form-label">Pilih Pelanggan</label>
                        <select name="id_pelanggan" class="form-select">
                            <option value="">Pilih pelanggan</option>
                            @foreach($pelanggans as $p)
                                <option value="{{ $p->id_pelanggan }}" {{ old('id_pelanggan') == $p->id_pelanggan ? 'selected' : '' }}>{{ $p->nama }} - {{ $p->no_hp }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Petugas</label>
                        <select name="id_petugas" class="form-select">
                            <option value="">Pilih petugas</option>
                            @foreach($petugass as $petugas)
                                <option value="{{ $petugas->id_petugas }}" {{ old('id_petugas') == $petugas->id_petugas ? 'selected' : '' }}>{{ $petugas->nama_petugas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 d-none" id="new-customer-fields">
                        <div class="row g-3 p-3 border rounded bg-light">
                            <div class="col-md-3">
                                <label class="form-label">Nama Pelanggan Baru</label>
                                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Nomor HP</label>
                                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Nomor Identitas (KTP/SIM)</label>
                                <input type="text" name="no_identitas" class="form-control" value="{{ old('no_identitas') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Sewa</label>
                        <input type="date" name="tgl_sewa" class="form-control" value="{{ old('tgl_sewa', today()->toDateString()) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Rencana Kembali</label>
                        <input type="date" name="tgl_kembali_rencana" class="form-control" value="{{ old('tgl_kembali_rencana', today()->addDay()->toDateString()) }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Pilih Alat Camping</label>
                        <div class="row g-2">
                            @foreach($alats as $index => $alat)
                                <div class="col-md-6">
                                    <div class="border rounded p-3 bg-white">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="items[{{ $index }}][id_alat]" value="{{ $alat->id_alat }}" id="alat-check-{{ $index }}">
                                            <label class="form-check-label fw-semibold" for="alat-check-{{ $index }}">
                                                {{ $alat->nama_alat }} — Rp {{ number_format($alat->harga_sewa_per_hari, 0, ',', '.') }}/hari (stok: {{ $alat->stok }})
                                            </label>
                                        </div>
                                        <div class="mt-2">
                                            <input type="number" name="items[{{ $index }}][jumlah]" class="form-control form-control-sm" min="1" max="{{ $alat->stok }}" value="1" placeholder="Jumlah unit">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Pembayaran Awal (Opsional)</label>
                        <input type="number" name="jumlah_bayar" class="form-control" min="0" value="{{ old('jumlah_bayar') }}" placeholder="Kosongkan jika belum bayar">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Metode Pembayaran Awal</label>
                        <select name="metode_bayar" class="form-select">
                            <option value="Tunai">Tunai</option>
                            <option value="Midtrans">Midtrans</option>
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="QRIS">QRIS</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-camp">Simpan Transaksi</button>
                    <a href="{{ route('admin.penyewaan.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    const typeSelect = document.getElementById('pelanggan-type');
    const existingGroup = document.getElementById('existing-customer-group');
    const newFields = document.getElementById('new-customer-fields');

    function syncCustomerType() {
        if (!typeSelect) return;
        const isNew = typeSelect.value === 'new';
        newFields.classList.toggle('d-none', !isNew);
        existingGroup.classList.toggle('d-none', isNew);
    }

    if (typeSelect) {
        typeSelect.addEventListener('change', syncCustomerType);
        syncCustomerType();
    }
</script>
@endsection
