<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Edit Data Guru</h2>

        <form action="{{ route('guru.update', $guru->guru_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="block mb-1">NIP</label>
                <input type="text" name="nip" value="{{ $guru->nip }}" class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-3">
                <label class="block mb-1">Nama Lengkap Guru</label>
                <input type="text" name="nama_guru" value="{{ $guru->nama_guru }}" class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-3">
                <label class="block mb-1">Mata Pelajaran (Mapel)</label>
                <input type="text" name="mapel" value="{{ $guru->mapel }}" class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-3">
                <label class="block mb-1">No. Telp / HP</label>
                <input type="text" name="telp" value="{{ $guru->telp }}" class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Pilih Akun Login</label>
                <select name="user_id" class="w-full border p-2 rounded" required>
                    @foreach($users as $u)
                        <option value="{{ $u->user_id }}" {{ $guru->user_id == $u->user_id ? 'selected' : '' }}>
                            {{ $u->nama_lengkap }} ({{ $u->username }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('guru.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Perbarui</button>
            </div>
        </form>
    </div>

</body>
</html>