<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Nilai Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Edit Nilai Siswa</h2>

        <form action="{{ route('nilai.update', $nilai->nilai_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="block mb-1">Siswa</label>
                <input type="text" value="{{ $nilai->siswa->nama_siswa ?? '' }}" class="w-full border p-2 rounded bg-gray-100" disabled>
            </div>
            <div class="mb-3">
                <label class="block mb-1">Nilai Tugas</label>
                <input type="number" step="0.1" name="nilai_tugas" value="{{ $nilai->nilai_tugas }}" class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-3">
                <label class="block mb-1">Nilai UTS</label>
                <input type="number" step="0.1" name="nilai_uts" value="{{ $nilai->nilai_uts }}" class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Nilai UAS</label>
                <input type="number" step="0.1" name="nilai_uas" value="{{ $nilai->nilai_uas }}" class="w-full border p-2 rounded" required>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('nilai.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Perbarui Nilai</button>
            </div>
        </form>
    </div>
</body>
</html>