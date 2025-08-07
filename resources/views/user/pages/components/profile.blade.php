<div class="card mb-4">
    <div class="card-header">
        <h5>Profil Saya</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3 text-center">
                <img src="{{ auth()->user()->profile_photo_url ?? asset('images/default-profile.png') }}" alt="Foto Profil"
                     class="rounded-circle mb-2" width="100">
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="profile_photo" class="form-label">Ganti Foto Profil</label>
                <input type="file" name="profile_photo" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Update Profil</button>
        </form>
    </div>
</div>
