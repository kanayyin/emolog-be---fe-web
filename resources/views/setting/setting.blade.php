<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile - Emolog</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  @vite('resources/css/app.css')
</head>
<body>
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <ul class="mb-0">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif


  <!-- Navbar -->
  <header class="navbar">
        <div class="logo">
         <a href="{{ route('home') }}">
           <img src="{{asset('images/emolog512fix.png')}}" alt="Logo" />
          </a>
        </div>
        <nav class="nav">
            <ul>
              <li><a href="{{route('journaling')}}">Diary</a></li>
                <li><a href="{{route('history')}}" >History</a></li>
                <li><a href="{{route('setting')}}" class="active">Setting</a></li>
            </ul>
        </nav>
    </header>


  <!-- Main Content: Profile Page -->
  <main class="main-content-profile">
    <section class="profile-container">
      <div class="profile-header">
        <div class="profile-content">
          <div class="profile-picture">
            <img src="{{ asset('images/profile.png')}}" alt="Profile Picture" class="profile-img">
          </div>
          <div class="profile-info">
            <h1>{{ Auth::user()->username }}</h1>
   
            <div class="profile-row">
              <label for="username">Username</label>
              <input type="text" id="username" value="{{ Auth::user()->username }}" disabled>
            </div>

            <div class="profile-row">
              <label for="email">Email</label>
              <input type="email" id="email" value="{{ Auth::user()->email }}" disabled>
            </div>

            <button type="button" class="btn btn-warning" id="changePasswordBtn">Change Password</button>


            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
               @csrf
               <button type="submit" class="btn btn-danger">Logout</button>
            </form>

          </div>
        </div>
      </div>
    </section>
  </main>


  <!-- Change Password Modal -->
<div id="changePasswordModal" class="modal">
  <form action="{{ route('change.password') }}" method="POST" class="modal-content">
    @csrf
    <span class="close-btn" id="closeModalBtn">&times;</span>
    <h2>Change Password</h2>

    <div class="modal-row">
      <label for="currentPassword">Current Password</label>
      <input type="password" name="current_password" id="currentPassword" placeholder="Current Password" required>
    </div>

    <div class="modal-row">
      <label for="newPassword">New Password</label>
      <input type="password" name="new_password" id="newPassword" placeholder="New Password" required>
    </div>

    <div class="modal-row">
      <label for="confirmPassword">Confirm New Password</label>
      <input type="password" name="new_password_confirmation" id="confirmPassword" placeholder="Confirm Password" required>
    </div>

    <div class="modal-buttons">
      <button type="submit" class="save-btn">Save</button>
      <button type="button" class="cancel-btn" id="cancelPasswordBtn">Cancel</button>
    </div>
  </form>
</div>

  <script >
    // Untuk membuka modal
    document.getElementById('changePasswordBtn').addEventListener('click', function () {
      document.getElementById('changePasswordModal').style.display = 'block';
    });

    // Untuk menutup modal
    document.getElementById('closeModalBtn').addEventListener('click', function () {
      document.getElementById('changePasswordModal').style.display = 'none';
    });

    document.getElementById('cancelPasswordBtn').addEventListener('click', function () {
      document.getElementById('changePasswordModal').style.display = 'none';
    });

  </script>
</body>
</html>