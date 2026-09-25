<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - Admin TU</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

<div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Data Siswa</h2>
        <a href="{{ route('siswa.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            + Tambah Siswa
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="p-3 border-b">NIS</th>
                    <th class="p-3 border-b">Nama Siswa</th>
                    <th class="p-3 border-b">L/P</th>
                    <th class="p-3 border-b">Telp</th>
                    <th class="p-3 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $siswa)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border-b">{{ $siswa->nis }}</td>
                    <td class="p-3 border-b">{{ $siswa->nama_siswa }}</td>
                    <td class="p-3 border-b">{{ $siswa->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                    <td class="p-3 border-b">{{ $siswa->telp }}</td>
                    <td class="p-3 border-b text-center flex justify-center space-x-2">
                        <a href="{{ route('siswa.edit', $siswa->siswa_id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Edit</a>
                        
                        <form action="{{ route('siswa.destroy', $siswa->siswa_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">Belum ada data siswa.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>