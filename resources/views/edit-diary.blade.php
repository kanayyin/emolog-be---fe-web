<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Diary</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9fafb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 600px;
            background-color: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-top: 50px;
        }
        h2 {
            font-weight: bold;
            margin-bottom: 25px;
        }
        label {
            font-weight: 500;
        }
        .btn-primary {
            background-color: #007bff;
            border-radius: 8px;
            font-weight: 500;
        }
        .btn-secondary {
            border-radius: 8px;
            font-weight: 500;
        }
        textarea, input[type="text"], input[type="date"] {
            border-radius: 8px !important;
        }
        .navbar {
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .navbar-brand img {
            height: 35px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/emolog512fix.png') }}" alt="Logo">
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('journaling') }}">Diary</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('history') }}">History</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('setting') }}">Setting</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Form -->
    <main class="container">
        <h2>Edit Catatan Harian</h2>
        <form method="POST" action="{{ route('diary.update', $diary->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="diary_date">Tanggal</label>
                <input type="date" name="diary_date" class="form-control"
                       value="{{ old('diary_date', \Carbon\Carbon::parse($diary->diary_date)->format('Y-m-d')) }}" required>
            </div>

            <div class="form-group">
                <label for="title">Judul</label>
                <input type="text" name="title" class="form-control" value="{{ $diary->title }}" required>
            </div>

            <div class="form-group">
                <label for="content">Isi</label>
                <textarea name="content" class="form-control" rows="5" required>{{ $diary->content }}</textarea>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-primary px-4">💾 Simpan Perubahan</button>
                <a href="{{ route('history') }}" class="btn btn-secondary px-4">❌ Batal</a>
            </div>
        </form>
    </main>
</body>
</html>
