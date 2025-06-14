<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Journaling - Emolog</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  @vite('resources/css/app.css')
</head>
<body id="journaling">

<!-- Navbar -->
<header class="navbar">
  <div class="logo">
    <a href="{{ route('home') }}">
      <img src="{{asset('images/emolog512fix.png')}}" alt="Logo" />
    </a>
  </div>
  <nav class="nav">
    <ul>
      <li><a href="{{route('journaling')}}" class="active">Diary</a></li>
      <li><a href="{{route('history')}}">History</a></li>
      <li><a href="{{route('setting')}}">Setting</a></li>
    </ul>
  </nav>
</header>

<!-- Journaling Section -->
<section class="journaling-container">
  
  {{-- Pesan sukses jika ada --}}
  @if(session('success'))
    <div class="alert alert-success text-center">
      {{ session('success') }}
    </div>
  @endif

  <form method="POST" action="{{ route('diary.store') }}">
    @csrf

    <div class="journaling-header">
      <h2>Give your feelings a title</h2>
      <p class="journaling-date">{{ \Carbon\Carbon::now()->translatedFormat('l, j F Y') }}</p>
      <hr>
      <p class="journaling-description">Feel free to write as much or as little as you want.</p>
    </div>

    <div class="journaling-body">
      <input type="hidden" name="diary_date" value="{{ \Carbon\Carbon::now()->toDateString() }}">
      <input type="text" name="title" class="form-control mb-2" placeholder="Title..." required>
      <textarea class="journaling-textarea" name="content" placeholder="Write your thoughts here..." required></textarea>
    </div>

    <div class="journaling-footer">
      <button type="submit" class="save-btn">Save</button>
      <div class="icon-group">
        <img src="{{asset('images/photo.png')}}" alt="image" class="icon">
        <img src="{{asset('images/camera.png')}}" alt="camera" class="icon">
      </div>
    </div>
  </form>
</section>

</body>
</html>
