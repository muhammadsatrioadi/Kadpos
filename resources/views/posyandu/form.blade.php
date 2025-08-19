@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title mb-0">
                    <i class="bi bi-plus-circle me-2"></i>
                    Form Input Data Posyandu
                </h4>
                <p class="card-text mb-0 mt-2 opacity-75">
                    Lengkapi semua informasi kesehatan dengan teliti. Kolom bertanda <span class="text-warning">*</span> wajib diisi.
                </p>
            </div>
            <div class="card-body">
                <form action="{{ route('posyandu.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <!-- Dusun -->
                        <div class="col-md-6 mb-3">
                            <label for="dusun" class="form-label">Dusun <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('dusun') is-invalid @enderror" 
                                   id="dusun" name="dusun" value="{{ old('dusun') }}" 
                                   placeholder="Masukkan nama dusun" required>
                            @error('dusun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama -->
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                   id="nama" name="nama" value="{{ old('nama') }}" 
                                   placeholder="Masukkan nama lengkap" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="col-md-6 mb-3">
                            <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('kategori') is-invalid @enderror" 
                                    id="kategori" name="kategori" required>
                                <option value="">Pilih kategori</option>
                                @foreach($kategori_options as $kategori)
                                    <option value="{{ $kategori }}" {{ old('kategori') == $kategori ? 'selected' : '' }}>
                                        {{ $kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="col-md-6 mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                                    id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="">Pilih jenis kelamin</option>
                                @foreach($jenis_kelamin_options as $jk)
                                    <option value="{{ $jk }}" {{ old('jenis_kelamin') == $jk ? 'selected' : '' }}>
                                        {{ $jk }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                   id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Umur -->
                        <div class="col-md-6 mb-3">
                            <label for="umur" class="form-label">Umur<span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('umur') is-invalid @enderror" 
                                   id="umur" name="umur" value="{{ old('umur') }}" 
                                   placeholder="Masukkan umur" min="0" max="150" required>
                            @error('umur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div class="col-12 mb-3">
                            <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" name="alamat" rows="3" 
                                      placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nomor KTP -->
                        <div class="col-md-6 mb-3">
                            <label for="nomor_ktp" class="form-label">Nomor KTP</label>
                            <input type="text" class="form-control @error('nomor_ktp') is-invalid @enderror" 
                                   id="nomor_ktp" name="nomor_ktp" value="{{ old('nomor_ktp') }}" 
                                   placeholder="16 digit nomor KTP" maxlength="16">
                            @error('nomor_ktp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nomor BPJS -->
                        <div class="col-md-6 mb-3">
                            <label for="nomor_bpjs" class="form-label">Nomor BPJS</label>
                            <input type="text" class="form-control @error('nomor_bpjs') is-invalid @enderror" 
                                   id="nomor_bpjs" name="nomor_bpjs" value="{{ old('nomor_bpjs') }}" 
                                   placeholder="Masukkan nomor BPJS">
                            @error('nomor_bpjs')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Berat Badan -->
                        <div class="col-md-4 mb-3">
                            <label for="berat_badan" class="form-label">Berat Badan (kg) <span class="text-danger">*</span></label>
                            <input type="number" step="0.1" class="form-control @error('berat_badan') is-invalid @enderror" 
                                   id="berat_badan" name="berat_badan" value="{{ old('berat_badan') }}" 
                                   placeholder="0.0" min="0.1" max="500" required>
                            @error('berat_badan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tinggi Badan -->
                        <div class="col-md-4 mb-3">
                            <label for="tinggi_badan" class="form-label">Tinggi Badan (cm) <span class="text-danger">*</span></label>
                            <input type="number" step="0.1" class="form-control @error('tinggi_badan') is-invalid @enderror" 
                                   id="tinggi_badan" name="tinggi_badan" value="{{ old('tinggi_badan') }}" 
                                   placeholder="0.0" min="10" max="300" required>
                            @error('tinggi_badan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- IMT -->
                        <div class="col-md-4 mb-3">
                            <label for="imt" class="form-label">IMT (otomatis)</label>
                            <input type="number" step="0.1" class="form-control" 
                                   id="imt" name="imt" value="{{ old('imt') }}" 
                                   placeholder="0.0" readonly>
                            <div class="form-text">Akan dihitung otomatis dari BB dan TB</div>
                        </div>

                        <!-- Lingkar Perut -->
                        <div class="col-md-6 mb-3">
                            <label for="lingkar_perut" class="form-label">Lingkar Perut (cm)</label>
                            <input type="number" step="0.1" class="form-control @error('lingkar_perut') is-invalid @enderror" 
                                   id="lingkar_perut" name="lingkar_perut" value="{{ old('lingkar_perut') }}" 
                                   placeholder="0.0" min="0" max="200">
                            @error('lingkar_perut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Lingkar Kepala -->
                        <div class="col-md-6 mb-3">
                            <label for="lingkar_kepala" class="form-label">Lingkar Kepala (cm)</label>
                            <input type="number" step="0.1" class="form-control @error('lingkar_kepala') is-invalid @enderror" 
                                   id="lingkar_kepala" name="lingkar_kepala" value="{{ old('lingkar_kepala') }}" 
                                   placeholder="cm" min="0" max="100">
                            @error('lingkar_kepala')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- LILA -->
                        <div class="col-md-6 mb-3">
                            <label for="lila" class="form-label">LILA (Lingkar Lengan Atas, cm)</label>
                            <input type="number" step="0.1" class="form-control @error('lila') is-invalid @enderror" 
                                   id="lila" name="lila" value="{{ old('lila') }}" 
                                   placeholder="cm" min="0" max="100">
                            @error('lila')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tekanan Darah -->
                        <div class="col-md-6 mb-3">
                            <label for="tekanan_darah" class="form-label">Tekanan Darah (mmHg)</label>
                            <input type="text" class="form-control @error('tekanan_darah') is-invalid @enderror" 
                                   id="tekanan_darah" name="tekanan_darah" value="{{ old('tekanan_darah') }}" 
                                   placeholder="120/80">
                            @error('tekanan_darah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mental dan Emosional -->
                        <div class="col-12 mb-3">
                            <label for="mental_dan_emosional" class="form-label">Kondisi Mental & Emosional</label>
                            <textarea class="form-control @error('mental_dan_emosional') is-invalid @enderror" 
                                      id="mental_dan_emosional" name="mental_dan_emosional" rows="3" 
                                      placeholder="Deskripsikan kondisi mental dan emosional">{{ old('mental_dan_emosional') }}</textarea>
                            @error('mental_dan_emosional')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="col-12 mb-3">
                            <label for="keterangan" class="form-label">Keterangan Tambahan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                      id="keterangan" name="keterangan" rows="3" 
                                      placeholder="Keterangan atau catatan tambahan">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="reset" class="btn btn-outline-secondary me-md-2">
                            <i class="bi bi-arrow-clockwise me-1"></i>
                            Reset Form
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
