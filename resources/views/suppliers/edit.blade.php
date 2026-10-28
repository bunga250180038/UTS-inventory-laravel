<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Supplier - Inventory System</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #1e293b; }
        .container { max-width: 900px; margin: 35px auto; padding: 20px; }
        h1 { margin: 0 0 8px; font-size: 28px; }
        .muted { color: #64748b; font-size: 14px; margin-bottom: 25px; }
        .panel { background: white; padding: 28px; border-radius: 14px; box-shadow: 0 4px 18px rgba(15,23,42,.05); }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .field { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-size: 14px; font-weight: bold; }
        input, textarea { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font: inherit; background: white; }
        textarea { min-height: 100px; resize: vertical; }
        input:focus, textarea:focus { outline: 2px solid #bfdbfe; border-color: #2563eb; }
        .full { grid-column: 1 / -1; }
        .actions { display: flex; gap: 10px; margin-top: 8px; flex-wrap: wrap; }
        .btn { display: inline-block; padding: 12px 18px; border: none; border-radius: 8px; font-weight: bold; font-size: 14px; text-decoration: none; cursor: pointer; }
        .primary { background: #2563eb; color: white; }
        .secondary { background: #e2e8f0; color: #334155; }
        .errors { background: #fee2e2; color: #991b1b; padding: 14px; border-radius: 8px; margin-bottom: 20px; }
        .required { color: #dc2626; }
        @media(max-width:600px) {
            .form-grid { grid-template-columns: 1fr; gap: 0; }
            .full { grid-column: auto; }
            .container { margin: 10px auto; padding: 14px; }
            .panel { padding: 20px; }
            h1 { font-size: 23px; }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Edit Supplier</h1>
    <p class="muted">Perbarui informasi supplier di bawah ini.</p>

    <div class="panel">
        @if($errors->any())
            <div class="errors">
                <strong>Periksa kembali data berikut:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="field">
                    <label for="name">Nama Supplier <span class="required">*</span></label>
                    <input id="name" name="name" value="{{ old('name', $supplier->name) }}"
                           maxlength="255" required>
                </div>

                <div class="field">
                    <label for="contact_person">Nama Kontak</label>
                    <input id="contact_person" name="contact_person"
                           value="{{ old('contact_person', $supplier->contact_person) }}" maxlength="255">
                </div>

                <div class="field">
                    <label for="phone">Nomor Telepon</label>
                    <input id="phone" name="phone" type="tel"
                           value="{{ old('phone', $supplier->phone) }}" maxlength="30">
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email"
                           value="{{ old('email', $supplier->email) }}" maxlength="255">
                </div>

                <div class="field full">
                    <label for="address">Alamat</label>
                    <textarea id="address" name="address">{{ old('address', $supplier->address) }}</textarea>
                </div>

                <div class="field full">
                    <label for="notes">Catatan</label>
                    <textarea id="notes" name="notes">{{ old('notes', $supplier->notes) }}</textarea>
                </div>
            </div>

            <div class="actions">
                <button class="btn primary" type="submit">Simpan Perubahan</button>
                <a class="btn secondary" href="{{ route('suppliers.index') }}">Kembali</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
