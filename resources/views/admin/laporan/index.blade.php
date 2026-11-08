@extends('layouts.admin')

@section('title', 'Ringkasan Laporan')
@section('page_title', 'Ringkasan Laporan')

@section('content')
    <div class="row g-4">
        <div class="col-md-6 col-xl-3">
            <div class="card-panel h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small">Laporan Alat</span>
                        <i class="bi bi-backpack text-success fs-4"></i>
                    </div>
                    <a href="{{ route('admin.laporan.alat') }}" class="btn btn-camp w-100">Buka</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card-panel h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small">Transaksi</span>
                        <i class="bi bi-cart-check text-primary fs-4"></i>
                    </div>
                    <a href="{{ route('admin.laporan.penyewaan') }}" class="btn btn-camp w-100">Buka</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card-panel h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small">Pembayaran</span>
                        <i class="bi bi-wallet2 text-warning fs-4"></i>
                    </div>
                    <a href="{{ route('admin.laporan.pembayaran') }}" class="btn btn-camp w-100">Buka</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card-panel h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small">Belum Kembali</span>
                        <i class="bi bi-clock-history text-danger fs-4"></i>
                    </div>
                    <a href="{{ route('admin.laporan.belum_kembali') }}" class="btn btn-camp w-100">Buka</a>
                </div>
            </div>
        </div>
    </div>
@endsection
