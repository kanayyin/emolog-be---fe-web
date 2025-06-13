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
              <label for="fullname">Fullname</label>
              <input type="text" id="fullname" value="Sandi" disabled>
            </div>

            <div class="profile-row">
              <label for="username">Username</label>
              <input type="text" id="username" value="sandi_123" disabled>
            </div>

            <div class="profile-row">
              <label for="email">Email</label>
              <input type="email" id="email" value="sandi@example.com" disabled>
              <span class="change-btn" id="changeEmailBtn">Change</span>
            </div>

            <div class="profile-row">
              <label for="password">Password</label>
              <input type="password" id="password" value="••••••••" disabled>
              <span class="change-btn" id="changePasswordBtn">Change</span>
            </div>

            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
              @csrf
              <button type="submit" class="btn btn-danger">Logout</button>
          </form>

          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Change Email Modal -->
  <div id="changeEmailModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" id="closeEmailModalBtn">&times;</span>
        <h2>Change Email</h2>
        
        <!-- Current Email Field -->
        <div class="modal-row">
            <label for="currentEmail">Current Email</label>
            <input type="email" id="currentEmail" placeholder="Current Email">
        </div>
        
        <!-- New Email Field -->
        <div class="modal-row">
            <label for="newEmail">New Email</label>
            <input type="email" id="newEmail" placeholder="Enter new email">
        </div>
        
        <!-- Confirm New Email Field -->
        <div class="modal-row">
            <label for="confirmNewEmail">Confirm New Email</label>
            <input type="email" id="confirmNewEmail" placeholder="Confirm new email">
        </div>
        
        <!-- Save and Cancel Buttons -->
        <div class="modal-buttons">
            <button id="saveEmailBtn" class="save-btn">Save</button>
            <button id="cancelEmailBtn" class="cancel-btn">Cancel</button>
        </div>
    </div>
  </div>

  <!-- Change Password Modal -->
  <div id="changePasswordModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" id="closeModalBtn">&times;</span>
        <h2>Change Password</h2>
        
        <!-- Current Password Field -->
        <div class="modal-row">
            <label for="currentPassword">Current Password</label>
            <input type="password" id="currentPassword" placeholder="Current Password">
            <!-- Eye icon for toggle password visibility -->
            <span class="toggle-password" onclick="togglePassword('currentPassword')">
                <img id="eye-icon-current" src="{{ asset('images/eyeclose.png')}}" alt="Eye Icon" width="30px">
            </span>
        </div>
        
        <!-- New Password Field -->
        <div class="modal-row">
            <label for="newPassword">New Password</label>
            <input type="password" id="newPassword" placeholder="Enter new password">
            <!-- Eye icon for toggle password visibility -->
            <span class="toggle-password" onclick="togglePassword('newPassword')">
                <img id="eye-icon-new" src="{{ asset('images/eyeclose.png')}}" alt="Eye Icon" width="30px">
            </span>
        </div>
        
        <!-- Confirm New Password Field -->
        <div class="modal-row">
            <label for="confirmPassword">Confirm New Password</label>
            <input type="password" id="confirmPassword" placeholder="Confirm new password">
            <!-- Eye icon for toggle password visibility -->
            <span class="toggle-password" onclick="togglePassword('confirmPassword')">
                <img id="eye-icon-confirm" src="{{ asset('images/eyeclose.png')}}" alt="Eye Icon" width="30px">
            </span>
        </div>
        
        <!-- Save and Cancel Buttons -->
        <div class="modal-buttons">
            <button id="savePasswordBtn" class="save-btn">Save</button>
            <button id="cancelPasswordBtn" class="cancel-btn">Cancel</button>
        </div>
    </div>
  </div>
  <footer class="footer-global">
    <p>&copy; Mood Tracker</p>
  </footer>
  <script src="/tesscript.js"></script>
</body>
</html>