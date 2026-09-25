<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Data Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Guru</h2>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Kembali</a>
                <a href="{{ route('guru.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Tambah Guru</a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <table class="w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-50">
                    <th class="border p-2">NIP</th>
                    <th class="border p-2">Nama Guru</th>
                    <th class="border p-2">Mata Pelajaran</th>
                    <th class="border p-2">No. HP</th>
                    <th class="border p-2">Akun Login</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gurus as $g)
                <tr class="text-center">
                    <td class="border p-2">{{ $g->nip }}</td>
                    <td class="border p-2 text-left">{{ $g->nama_guru }}</td>
                    <td class="border p-2">{{ $g->mapel }}</td>
                    <td class="border p-2">{{ $g->telp }}</td>
                    <td class="border p-2">{{ $g->user->username ?? '-' }}</td>
                    <td class="border p-2">
                        <a href="{{ route('guru.edit', $g->guru_id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded text-sm">Edit</a>
                        <form action="{{ route('guru.destroy', $g->guru_id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded text-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">Belum ada data guru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>