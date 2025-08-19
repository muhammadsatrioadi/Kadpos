@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-success text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-0">
                            <i class="bi bi-table me-2"></i>
                            Riwayat Data Posyandu
                        </h4>
                        <p class="card-text mb-0 mt-2 opacity-75">
                            Total: {{ $data->total() }} data
                            @if($currentSearch || $currentKategori)
                                (dari {{ $totalData }} total data)
                            @endif
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('posyandu.index') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-plus-circle me-1"></i>
                            Tambah Data
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-download me-1"></i>
                                Export
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('posyandu.export.csv', request()->query()) }}">
                                        <i class="bi bi-file-earmark-spreadsheet me-2"></i>
                                        Export CSV
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('posyandu.export.pdf', request()->query()) }}">
                                        <i class="bi bi-file-earmark-pdf me-2"></i>
                                        Export PDF
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('posyandu.riwayat') }}" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control" name="search" 
                                       value="{{ $currentSearch }}" 
                                       placeholder="Cari berdasarkan nama, kategori, dusun, atau alamat...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="kategori">
                                <option value="">Semua Kategori</option>
                                @foreach($kategori_options as $kategori)
                                    <option value="{{ $kategori }}" {{ $currentKategori == $kategori ? 'selected' : '' }}>
                                        {{ $kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="d-grid gap-2 d-md-flex">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search me-1"></i>
                                    Cari
                                </button>
                                <a href="{{ route('posyandu.riwayat') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-clockwise me-1"></i>
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                @if($data->count() > 0)
                    <!-- Data Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Dusun</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Umur</th>
                                    <th>BB/TB</th>
                                    <th>IMT</th>
                                    <th>Tekanan Darah</th>
                                    <th>Tanggal Input</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $index => $item)
                                    <tr>
                                        <td>{{ $data->firstItem() + $index }}</td>
                                        <td class="fw-bold">{{ $item->nama }}</td>
                                        <td>
                                            <span class="badge bg-{{ $item->kategori == 'Balita' ? 'primary' : ($item->kategori == 'Ibu Hamil' ? 'danger' : ($item->kategori == 'Ibu Menyusui' ? 'warning' : 'info')) }}">
                                                {{ $item->kategori }}
                                            </span>
                                        </td>
                                        <td>{{ $item->dusun }}</td>
                                        <td>{{ $item->jenis_kelamin }}</td>
                                        <td>{{ $item->umur }}</td>
                                        <td>{{ $item->berat_badan }}kg / {{ $item->tinggi_badan }}cm</td>
                                        <td>
                                            @if($item->imt)
                                                <span class="badge bg-{{ $item->imt_color }}">
                                                    {{ $item->imt }}
                                                </span>
                                                <small class="d-block text-muted">{{ $item->imt_status }}</small>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $item->tekanan_darah ?: '-' }}</td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $item->created_at->format('d/m/Y H:i') }}
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('posyandu.edit', $item->id) }}" 
                                                   class="btn btn-outline-primary" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('posyandu.destroy', $item->id) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirmDelete('{{ $item->nama }}')">
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

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $data->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <h5 class="mt-3 text-muted">
                            @if($currentSearch || $currentKategori)
                                Tidak ada data yang sesuai dengan pencarian
                            @else
                                Belum ada data posyandu
                            @endif
                        </h5>
                        <p class="text-muted">
                            @if($currentSearch || $currentKategori)
                                Coba ubah kata kunci pencarian atau filter kategori
                            @else
                                Tambahkan data pertama untuk memulai
                            @endif
                        </p>
                        <a href="{{ route('posyandu.index') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>
                            Tambah Data Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
