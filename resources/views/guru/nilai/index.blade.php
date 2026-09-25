<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Nilai Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Daftar Nilai Siswa</h2>
                <p class="text-sm text-gray-500">Mata Pelajaran: <strong>{{ $guru->mapel ?? '-' }}</strong></p>
            </div>
            <div>
                <a href="{{ route('guru.dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Kembali</a>
                <a href="{{ route('nilai.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">+ Input Nilai</a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <table class="w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-50 text-center">
                    <th class="border p-2">NISN</th>
                    <th class="border p-2">Nama Siswa</th>
                    <th class="border p-2">Nilai Tugas</th>
                    <th class="border p-2">UTS</th>
                    <th class="border p-2">UAS</th>
                    <th class="border p-2">Nilai Akhir</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nilais as $n)
                <tr class="text-center">
                    <td class="border p-2">{{ $n->siswa->nisn ?? '-' }}</td>
                    <td class="border p-2 text-left">{{ $n->siswa->nama_siswa ?? '-' }}</td>
                    <td class="border p-2">{{ $n->nilai_tugas }}</td>
                    <td class="border p-2">{{ $n->nilai_uts }}</td>
                    <td class="border p-2">{{ $n->nilai_uas }}</td>
                    <td class="border p-2 font-bold text-blue-600">{{ number_format($n->nilai_akhir, 2) }}</td>
                    <td class="border p-2">
                        <a href="{{ route('nilai.edit', $n->nilai_id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded text-sm">Edit</a>
                        <form action="{{ route('nilai.destroy', $n->nilai_id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus nilai ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded text-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-4 text-center text-gray-500">Belum ada data nilai.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>