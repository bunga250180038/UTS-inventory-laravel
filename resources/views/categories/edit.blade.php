<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori | Inventory System</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 25px; background: #f1f5f9; font-family: Arial, sans-serif; color: #1e293b; }
        .container { max-width: 650px; margin: 25px auto; }
        .header { background: #102a43; color: white; padding: 20px 25px; border-radius: 12px 12px 0 0; }
        .header h1 { margin: 0; font-size: 22px; }
        .panel { background: white; padding: 28px; border-radius: 0 0 12px 12px; box-shadow: 0 5px 20px #0000000a; }
        label { display: block; margin: 18px 0 8px; font-weight: bold; }
        input, textarea { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font: inherit; }
        textarea { resize: vertical; min-height: 120px; }
        input:focus, textarea:focus { outline: 2px solid #64ccc5; border-color: #176b87; }
        .error { color: #dc2626; font-size: 13px; margin-top: 6px; }
        .buttons { display: flex; gap: 10px; margin-top: 25px; }
        .button { border: 0; padding: 12px 17px; border-radius: 8px; text-decoration: none; font-weight: bold; cursor: pointer; font-size: 14px; }
        .save { background: #176b87; color: white; }
        .cancel { background: #e2e8f0; color: #334155; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>✏️ Edit Kategori</h1>
    </div>

    <div class="panel">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="name">Nama Kategori *</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $category->name) }}"
                maxlength="100"
                required
            >
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="description">Deskripsi</label>
            <textarea
                id="description"
                name="description"
                maxlength="2000"
                placeholder="Keterangan kategori (opsional)"
            >{{ old('description', $category->description) }}</textarea>
            @error('description')
                <div class="error">{{ $message }}</div>
            @enderror

            <div class="buttons">
                <button class="button save" type="submit">Simpan Perubahan</button>
                <a class="button cancel" href="{{ route('categories.index') }}">Kembali</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
