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
        <a href="{{ route('admin.siswa.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
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
                    <th class="p-3 border-b">NISN</th>
                    <th class="p-3 border-b">Nama Siswa</th>
                    <th class="p-3 border-b">Kelas</th>
                    <th class="p-3 border-b text-center">L/P</th>
                    <th class="p-3 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $siswa)
                <tr class="hover:bg-gray-50 border-b">
                    <td class="p-3">{{ $siswa->nis }}</td>
                    <td class="p-3">{{ $siswa->nisn }}</td>
                    <td class="p-3 font-medium text-gray-800">{{ $siswa->nama_siswa }}</td>
                    <td class="p-3">{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td class="p-3 text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded {{ $siswa->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                            {{ $siswa->jenis_kelamin }}
                        </span>
                    </td>
                    <td class="p-3 text-center">
                        <div class="flex justify-center space-x-2">
                            <!-- PERBAIKAN: Gunakan admin.siswa.edit dan $siswa->id -->
                            <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm transition">
                                Edit
                            </a>
                            
                            <!-- PERBAIKAN: Gunakan admin.siswa.destroy dan $siswa->id -->
                            <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-6 text-center text-gray-500">
                        Belum ada data siswa.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>