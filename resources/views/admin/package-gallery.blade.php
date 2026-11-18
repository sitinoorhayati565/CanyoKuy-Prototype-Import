
@extends('layouts.admin')

@section('title', 'Kelola Galeri Paket')

@section('content')

<div class="gallery-page">

    <div class="page-header">
        <div>
            <h1>Kelola Galeri Paket</h1>
            <p>Kelola foto destinasi dan paket wisata CanyoKuy.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM TAMBAH FOTO -->
    <div class="gallery-form-card">
        <h3>Tambah Foto Galeri</h3>

        <form action="{{ route('admin.package-gallery.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="form-group">
                <label>Judul Foto</label>
                <input type="text"
                       name="title"
                       value="{{ old('title') }}"
                       placeholder="Masukkan judul foto"
                       required>
            </div>

            <div class="form-group">
                <label>Jenis Paket</label>
                <select name="package_type">
                    <option value="">Pilih jenis paket</option>
                    <option value="Camp">Camp</option>
                    <option value="Round Trip">Round Trip</option>
                </select>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description"
                          rows="3"
                          placeholder="Masukkan deskripsi foto">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label>Upload Foto</label>
                <input type="file"
                       name="image"
                       accept="image/jpeg,image/png,image/webp"
                       required>
                <small>Format JPG, JPEG, PNG, atau WebP. Maksimal 2 MB.</small>
            </div>

            <button type="submit" class="btn-primary">
                <i class="fas fa-plus"></i> Tambahkan Foto
            </button>

        </form>
    </div>

    <!-- DAFTAR GALERI -->
    <div class="gallery-list-section">

        <div class="section-header">
            <h3>Daftar Foto Galeri</h3>
            <span>{{ $galleries->count() }} Foto</span>
        </div>

        <div class="gallery-grid">

            @forelse($galleries as $gallery)

                <div class="gallery-card">

                    <div class="gallery-image">
                        <img src="{{ asset('storage/' . $gallery->image) }}"
                             alt="{{ $gallery->title }}">
                    </div>

                    <div class="gallery-info">

                        <span class="package-badge">
                            {{ $gallery->package_type ?: 'Umum' }}
                        </span>

                        <h4>{{ $gallery->title }}</h4>

                        <p>{{ $gallery->description ?: 'Tidak ada deskripsi.' }}</p>

                        <div class="gallery-actions">

                            <button type="button"
                                    class="btn-edit"
                                    onclick="openEditModal(
                                        {{ $gallery->id }},
                                        {{ Js::from($gallery->title) }},
                                        {{ Js::from($gallery->description) }},
                                        {{ Js::from($gallery->package_type) }}
                                    )">
                                <i class="fas fa-edit"></i> Edit
                            </button>

                            <form action="{{ route('admin.package-gallery.destroy', $gallery->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus foto ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn-delete">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>

                            </form>

                        </div>
                    </div>
                </div>

            @empty

                <div class="empty-gallery">
                    <i class="fas fa-images"></i>
                    <h4>Belum Ada Foto Galeri</h4>
                    <p>Silakan tambahkan foto destinasi atau paket wisata.</p>
                </div>

            @endforelse

        </div>
    </div>

</div>

<!-- MODAL EDIT -->
<div id="editModal" class="modal">
    <div class="modal-content">

        <div class="modal-header">
            <h3>Edit Foto Galeri</h3>
            <button type="button" onclick="closeEditModal()">&times;</button>
        </div>

        <form id="editForm" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Judul Foto</label>
                <input type="text" name="title" id="editTitle" required>
            </div>

            <div class="form-group">
                <label>Jenis Paket</label>
                <select name="package_type" id="editPackageType">
                    <option value="">Pilih jenis paket</option>
                    <option value="Camp">Camp</option>
                    <option value="Round Trip">Round Trip</option>
                </select>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" id="editDescription" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label>Ganti Foto (Opsional)</label>
                <input type="file" name="image"
                       accept="image/jpeg,image/png,image/webp">
                <small>Kosongkan jika tidak ingin mengganti foto.</small>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel"
                        onclick="closeEditModal()">Batal</button>

                <button type="submit" class="btn-primary">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

<style>
.gallery-page {
    padding: 5px;
}

.page-header {
    margin-bottom: 25px;
}

.page-header h1 {
    font-size: 25px;
    color: #26332f;
    margin-bottom: 6px;
}

.page-header p {
    color: #777;
    font-size: 14px;
}

.gallery-form-card {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 30px;
    box-shadow: 0 3px 12px rgba(0,0,0,.05);
}

.gallery-form-card h3,
.section-header h3 {
    color: #26332f;
    font-size: 18px;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 17px;
}

.form-group label {
    display: block;
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 8px;
    color: #444;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 11px 13px;
    border: 1px solid #ddd;
    border-radius: 7px;
    font-family: inherit;
    font-size: 14px;
    box-sizing: border-box;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #2f6b5e;
}

.form-group small {
    display: block;
    color: #888;
    margin-top: 6px;
    font-size: 12px;
}

.btn-primary {
    background: #2f6b5e;
    color: #fff;
    border: none;
    padding: 11px 18px;
    border-radius: 7px;
    cursor: pointer;
    font-weight: 600;
}

.btn-primary:hover {
    background: #245448;
}

.alert-success {
    padding: 13px 16px;
    background: #e7f5ec;
    color: #267344;
    border-radius: 7px;
    margin-bottom: 20px;
}

.alert-error {
    padding: 13px 16px;
    background: #fdecec;
    color: #b42318;
    border-radius: 7px;
    margin-bottom: 20px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}

.section-header span {
    color: #777;
    font-size: 13px;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
    gap: 20px;
}

.gallery-card {
    background: #fff;
    border-radius: 11px;
    overflow: hidden;
    box-shadow: 0 3px 12px rgba(0,0,0,.05);
}

.gallery-image {
    height: 175px;
    background: #eee;
}

.gallery-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.gallery-info {
    padding: 16px;
}

.package-badge {
    display: inline-block;
    background: #e7f1ed;
    color: #2f6b5e;
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.gallery-info h4 {
    margin: 12px 0 7px;
    color: #26332f;
    font-size: 16px;
}

.gallery-info p {
    color: #777;
    font-size: 13px;
    min-height: 35px;
    line-height: 1.5;
}

.gallery-actions {
    display: flex;
    gap: 8px;
    margin-top: 15px;
}

.gallery-actions form {
    margin: 0;
}

.btn-edit,
.btn-delete {
    border: none;
    padding: 8px 11px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 12px;
    font-weight: 600;
}

.btn-edit {
    background: #eaf1ff;
    color: #315caa;
}

.btn-delete {
    background: #fdeaea;
    color: #c0392b;
}

.empty-gallery {
    grid-column: 1 / -1;
    text-align: center;
    padding: 55px 20px;
    background: #fff;
    border-radius: 12px;
    color: #888;
}

.empty-gallery i {
    font-size: 40px;
    margin-bottom: 15px;
}

.empty-gallery h4 {
    color: #444;
}

.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.5);
    z-index: 9999;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.modal-content {
    background: #fff;
    width: 100%;
    max-width: 500px;
    padding: 25px;
    border-radius: 12px;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.modal-header h3 {
    color: #26332f;
}

.modal-header button {
    border: none;
    background: none;
    font-size: 25px;
    cursor: pointer;
}

.modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn-cancel {
    padding: 10px 16px;
    border: none;
    border-radius: 7px;
    cursor: pointer;
    background: #eee;
}

@media(max-width: 600px) {
    .gallery-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function openEditModal(id, title, description, packageType) {
    const form = document.getElementById('editForm');

    form.action = "{{ url('/admin/package-gallery') }}/" + id;

    document.getElementById('editTitle').value = title || '';
    document.getElementById('editDescription').value = description || '';
    document.getElementById('editPackageType').value = packageType || '';

    document.getElementById('editModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}
</script>

@endsection
