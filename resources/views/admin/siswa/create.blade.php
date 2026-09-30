<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

<div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Data Siswa Baru</h2>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.siswa.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Akun User (Siswa)</label>
                <select name="user_id" class="w-full border-gray-300 rounded shadow-sm p-2 border focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Akun User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->user_id }}">{{ $user->nama_lengkap }} ({{ $user->username }})</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-gray-700 font-medium mb-1">NIS</label>
                <input type="text" name="nis" value="{{ old('nis') }}" class="w-full border-gray-300 rounded shadow-sm p-2 border focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="md:col-span-2">
                <label class="block text-gray-700 font-medium mb-1">Nama Lengkap Siswa</label>
                <input type="text" name="nama_siswa" value="{{ old('nama_siswa') }}" class="w-full border-gray-300 rounded shadow-sm p-2 border focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full border-gray-300 rounded shadow-sm p-2 border focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" value="{{ old('tgl_lahir') }}" class="w-full border-gray-300 rounded shadow-sm p-2 border focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Nomor Telepon</label>
                <input type="text" name="telp" value="{{ old('telp') }}" class="w-full border-gray-300 rounded shadow-sm p-2 border focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="md:col-span-2">
                <label class="block text-gray-700 font-medium mb-1">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" class="w-full border-gray-300 rounded shadow-sm p-2 border focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('alamat') }}</textarea>
            </div>
        </div>

        <div class="flex space-x-3 mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow font-medium">Simpan Data</button>
            <a href="{{ route('siswa.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded shadow font-medium">Batal</a>
        </div>
    </form>
</div>

</body>
</html>