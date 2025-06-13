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
           <img src="/assets/emologlogo.png" alt="Logo" />
          </a>
        </div>
        <nav class="nav">
            <ul>
                <li><a href="{{route('journaling')}}" class="active">Diary</a></li>
                <li><a href="{{route('history')}}" >History</a></li>
                <li><a href="{{route('setting')}}">Setting</a></li>
            </ul>
        </nav>
    </header>

  <!-- Journaling Section -->
  <section class="journaling-container">
    <div class="journaling-header">
      <h2>Give your feelings a title</h2>
      <p class="journaling-date">Monday, 7 June 2025</p>
      <hr>
      <p class="journaling-description">Feel free to write as much or as little as you want.</p>
    </div>

    <div class="journaling-body">
      <textarea class="journaling-textarea" placeholder="Write your thoughts here..."></textarea>
    </div>

    <div class="journaling-footer">
      <button class="save-btn">Save</button>
      <div class="icon-group">
        <img src="/assets/photo.png" alt="image" class="icon">
        <img src="/assets/camera.png" alt="camera" class="icon">
      </div>
    </div>
  </section>
  <footer class="footer-global">
    <p>&copy; 2025 Dicoding</p>
    </footer>
</body>
</html>
