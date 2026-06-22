@extends('layouts.app')

@section('title', 'Manajemen Barang | AKA Rental')

@section('content')

{{-- Header --}}
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-extrabold text-gray-800">Manajemen Barang 📦</h1>
    <button onclick="openModal('modalTambahBarang')" class="bg-purple-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-purple-700 transition">
        <i class="fas fa-plus mr-2"></i> Tambah Barang
    </button>
</div>

{{-- Tabel Barang --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left">
        <thead>
            <tr class="bg-gray-50 text-gray-600 text-xs uppercase">
                <th class="px-6 py-4">Foto</th>
                <th class="px-6 py-4">Nama Barang</th>
                <th class="px-6 py-4">Kategori</th>
                <th class="px-6 py-4">Harga</th>
                <th class="px-6 py-4">Stok</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($barangs as $item)
            <tr class="hover:bg-purple-50/20 transition-colors">
                <td class="px-6 py-4">
                    <img src="{{ asset($item->foto) }}" alt="{{ $item->nama_barang }}" class="w-12 h-12 object-cover rounded-lg">
                </td>
                <td class="px-6 py-4 font-bold text-gray-800">{{ $item->nama_barang }}</td>
                <td class="px-6 py-4">{{ $item->kategori }}</td>
                <td class="px-6 py-4">Rp{{ number_format($item->harga_sewa, 0, ',', '.') }}</td>
                <td class="px-6 py-4">{{ $item->stok }}</td>
                <td class="px-6 py-4 text-center">
                    <button onclick="openModal('modalEditBarang{{ $item->id }}')" class="text-amber-500 hover:text-amber-600 transition" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('admin.barang.delete', $item->id) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Yakin hapus?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-rose-500 hover:text-rose-600 transition" title="Hapus">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>

            {{-- Modal Edit --}}
            <div id="modalEditBarang{{ $item->id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 backdrop-blur-md p-4 transition-all duration-300">
                <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl border border-gray-100 overflow-hidden transform scale-100 transition-all">
                    <!-- Decorate top line -->
                    <div class="h-1.5 w-full bg-gradient-to-r from-purple-500 to-indigo-500"></div>
                    
                    <!-- Header -->
                    <div class="relative bg-white px-8 pt-6 pb-4">
                        <button type="button" onclick="closeModal('modalEditBarang{{ $item->id }}')" class="absolute top-5 right-6 text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-2 rounded-full transition-all duration-200">
                            <i class="fas fa-times text-lg"></i>
                        </button>
                        
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-500 shadow-sm border border-amber-100">
                                <i class="fas fa-edit text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Edit Barang</h3>
                                <p class="text-sm text-gray-500">Perbarui informasi barang: {{ $item->nama_barang }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('admin.barang.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="px-8 py-5 space-y-4 border-t border-gray-50">
                            <!-- Nama Barang -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Barang</label>
                                <div class="relative rounded-xl shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <input type="text" name="nama_barang" value="{{ $item->nama_barang }}" required class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:border-purple-500 focus:ring-4 focus:ring-purple-100/50 transition duration-200 text-sm">
                                </div>
                            </div>
                            
                            <!-- Deskripsi -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                                <textarea name="deskripsi" rows="3" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:border-purple-500 focus:ring-4 focus:ring-purple-100/50 transition duration-200 text-sm">{{ $item->deskripsi }}</textarea>
                            </div>

                            <!-- Kategori & Stok Grid -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori</label>
                                    <div class="relative rounded-xl shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                            <i class="fas fa-layer-group"></i>
                                        </div>
                                        <select name="kategori" class="w-full pl-10 pr-10 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-800 focus:border-purple-500 focus:ring-4 focus:ring-purple-100/50 transition duration-200 text-sm">
                                            <option value="Kamera" {{ $item->kategori == 'Kamera' ? 'selected' : '' }}>Kamera</option>
                                            <option value="Alat Camping" {{ $item->kategori == 'Alat Camping' ? 'selected' : '' }}>Alat Camping</option>
                                            <option value="Paket" {{ $item->kategori == 'Paket' ? 'selected' : '' }}>Paket</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Stok</label>
                                    <div class="relative rounded-xl shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                            <i class="fas fa-warehouse"></i>
                                        </div>
                                        <input type="number" name="stok" value="{{ $item->stok }}" required class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:border-purple-500 focus:ring-4 focus:ring-purple-100/50 transition duration-200 text-sm">
                                    </div>
                                </div>
                            </div>

                            <!-- Harga Sewa -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Harga Sewa per Hari</label>
                                <div class="relative rounded-xl shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-500 font-semibold text-sm">
                                        <span>Rp</span>
                                    </div>
                                    <input type="number" name="harga_sewa" value="{{ $item->harga_sewa }}" required class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:border-purple-500 focus:ring-4 focus:ring-purple-100/50 transition duration-200 text-sm">
                                </div>
                            </div>

                            <!-- Foto Barang -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Foto Barang</label>
                                <div class="flex items-center gap-4 p-4 border border-dashed border-gray-200 rounded-2xl bg-gray-50/50">
                                    <div class="relative group w-20 h-20 flex-shrink-0 bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm">
                                        <img id="edit-img-preview-{{ $item->id }}" src="{{ asset($item->foto) }}" alt="Foto Lama" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                            <span class="text-[10px] text-white font-semibold">Foto Saat Ini</span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <input type="file" name="foto" id="input-foto-{{ $item->id }}" onchange="previewImage(this, 'edit-img-preview-{{ $item->id }}')" class="hidden">
                                        <button type="button" onclick="document.getElementById('input-foto-{{ $item->id }}').click()" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl font-bold text-xs text-gray-700 shadow-sm hover:bg-gray-50 hover:text-purple-600 transition duration-200">
                                            <i class="fas fa-cloud-upload-alt mr-2 text-purple-500 text-sm"></i> Ganti Foto
                                        </button>
                                        <p class="mt-1 text-[11px] text-gray-400 truncate">Format: JPG, PNG (Max 2MB)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="bg-gray-50 px-8 py-5 flex justify-end gap-3 border-t border-gray-100">
                            <button type="button" onclick="closeModal('modalEditBarang{{ $item->id }}')" class="px-5 py-2.5 bg-white border border-gray-200 rounded-xl font-bold text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition duration-200">Batal</button>
                            <button type="submit" class="px-5 py-2.5 bg-purple-600 text-white rounded-xl font-bold text-sm hover:bg-purple-700 transition duration-200 shadow-md shadow-purple-100">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Modal Tambah --}}
<div id="modalTambahBarang" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 backdrop-blur-md p-4 transition-all duration-300">
    <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl border border-gray-100 overflow-hidden transform scale-100 transition-all">
        <!-- Decorate top line -->
        <div class="h-1.5 w-full bg-gradient-to-r from-purple-500 to-indigo-500"></div>
        
        <!-- Header -->
        <div class="relative bg-white px-8 pt-6 pb-4">
            <button type="button" onclick="closeModal('modalTambahBarang')" class="absolute top-5 right-6 text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-2 rounded-full transition-all duration-200">
                <i class="fas fa-times text-lg"></i>
            </button>
            
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-600 shadow-sm border border-purple-100">
                    <i class="fas fa-plus text-lg"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Tambah Barang Baru</h3>
                    <p class="text-sm text-gray-500">Isi detail dan foto untuk menambahkan barang baru</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="px-8 py-5 space-y-4 border-t border-gray-50">
                <!-- Nama Barang -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Barang</label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i class="fas fa-box"></i>
                        </div>
                        <input type="text" name="nama_barang" placeholder="Masukkan nama barang..." required class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:border-purple-500 focus:ring-4 focus:ring-purple-100/50 transition duration-200 text-sm">
                    </div>
                </div>
                
                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" placeholder="Masukkan deskripsi barang..." class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:border-purple-500 focus:ring-4 focus:ring-purple-100/50 transition duration-200 text-sm"></textarea>
                </div>

                <!-- Kategori & Stok Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <select name="kategori" class="w-full pl-10 pr-10 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-800 focus:border-purple-500 focus:ring-4 focus:ring-purple-100/50 transition duration-200 text-sm">
                                <option value="Kamera">Kamera</option>
                                <option value="Alat Camping">Alat Camping</option>
                                <option value="Paket">Paket</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Stok</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-warehouse"></i>
                            </div>
                            <input type="number" name="stok" placeholder="0" required class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:border-purple-500 focus:ring-4 focus:ring-purple-100/50 transition duration-200 text-sm">
                        </div>
                    </div>
                </div>

                <!-- Harga Sewa -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Harga Sewa per Hari</label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-500 font-semibold text-sm">
                            <span>Rp</span>
                        </div>
                        <input type="number" name="harga_sewa" placeholder="0" required class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:border-purple-500 focus:ring-4 focus:ring-purple-100/50 transition duration-200 text-sm">
                    </div>
                </div>

                <!-- Foto Barang -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Foto Barang</label>
                    <div class="p-4 border border-dashed border-purple-200 hover:border-purple-400 rounded-2xl bg-purple-50/30 hover:bg-purple-50/50 transition-all duration-200">
                        <input type="file" name="foto" id="tambah-foto-input" onchange="previewImage(this, 'tambah-img-preview-box', 'tambah-upload-placeholder')" required class="hidden">
                        <div onclick="document.getElementById('tambah-foto-input').click()" class="cursor-pointer flex flex-col items-center justify-center py-2 text-center">
                            <div id="tambah-upload-placeholder" class="space-y-2">
                                <div class="w-10 h-10 mx-auto rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                                    <i class="fas fa-image text-lg"></i>
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-purple-600 hover:text-purple-700">Pilih berkas</span>
                                    <span class="text-xs text-gray-500"> atau seret ke sini</span>
                                </div>
                                <p class="text-[10px] text-gray-400">PNG, JPG, JPEG hingga 2MB</p>
                            </div>
                            
                            <!-- Image preview container inside upload area -->
                            <div id="tambah-img-preview-box" class="hidden mt-1 relative w-32 h-32 rounded-xl overflow-hidden border border-purple-200 bg-white shadow-sm">
                                <img id="tambah-img-preview" src="#" alt="Preview" class="w-full h-full object-cover">
                                <button type="button" onclick="event.stopPropagation(); removePreview('tambah-foto-input', 'tambah-img-preview-box', 'tambah-upload-placeholder')" class="absolute top-1.5 right-1.5 w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center shadow-md transition duration-150">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-5 flex justify-end gap-3 border-t border-gray-100">
                <button type="button" onclick="closeModal('modalTambahBarang')" class="px-5 py-2.5 bg-white border border-gray-200 rounded-xl font-bold text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition duration-200">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-purple-600 text-white rounded-xl font-bold text-sm hover:bg-purple-700 transition duration-200 shadow-md shadow-purple-100">Tambah Barang</button>
            </div>
        </form>
    </div>
</div>

<script>
    // JS helper functions for live image previews
    function previewImage(input, previewElementId, placeholderId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var previewEl = document.getElementById(previewElementId);
                if (previewEl) {
                    if (previewEl.tagName === 'IMG') {
                        previewEl.src = e.target.result;
                    } else {
                        var img = previewEl.querySelector('img');
                        if (img) img.src = e.target.result;
                        previewEl.classList.remove('hidden');
                        if (placeholderId) {
                            document.getElementById(placeholderId).classList.add('hidden');
                        }
                    }
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removePreview(inputId, previewBoxId, placeholderId) {
        var input = document.getElementById(inputId);
        if (input) input.value = '';
        
        var previewBox = document.getElementById(previewBoxId);
        if (previewBox) previewBox.classList.add('hidden');
        
        var placeholder = document.getElementById(placeholderId);
        if (placeholder) placeholder.classList.remove('hidden');
    }
</script>
@endsection
