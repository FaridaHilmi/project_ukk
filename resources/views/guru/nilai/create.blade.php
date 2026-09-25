<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Nilai Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Input Nilai Siswa</h2>
        <p class="text-sm text-gray-500 mb-4">Mapel: <strong>{{ $guru->mapel ?? '-' }}</strong></p>

        <form action="{{ route('nilai.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="block mb-1">Pilih Siswa</label>
                <select name="siswa_id" class="w-full border p-2 rounded" required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswas as $s)
                        <option value="{{ $s->siswa_id }}">{{ $s->nisn }} - {{ $s->nama_siswa }} (Kelas {{ $s->kelas }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="block mb-1">Nilai Tugas (Bobot 30%)</label>
                <input type="number" step="0.1" name="nilai_tugas" class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-3">
                <label class="block mb-1">Nilai UTS (Bobot 30%)</label>
                <input type="number" step="0.1" name="nilai_uts" class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Nilai UAS (Bobot 40%)</label>
                <input type="number" step="0.1" name="nilai_uas" class="w-full border p-2 rounded" required>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('nilai.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan Nilai</button>
            </div>
        </form>
    </div>
</body>
</html>