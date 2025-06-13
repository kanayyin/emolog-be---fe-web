<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-Up Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body>
    <div class="container">
        <div class="left-side">
            <h1>Welcome !</h1>
            <p>To keep connected with us please login with your personal info</p>
            <button class="btn-sign-in" onclick="window.location.href='{{ route('login') }}'">Sign In</button>
        </div>
        <div class="right-side">
            <h1>Create Account</h1>
            <p>our use your e-mail for registration:</p>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form-group">
                    <div class="input-with-icon">
                        <img src="/assets/account.png" alt="Profile Icon" class="input-icon">
                        <input type="text" name="username" placeholder="Name" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-with-icon">
                        <img src="/assets/mail.png" alt="Profile Icon" class="input-icon">
                        <input type="text" name="email" placeholder="Email" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-with-icon">
                        <img src="/assets/pass.png" alt="Profile Icon" class="input-icon">
                        <input type="password" name="password" id="passwordInput" placeholder="Password" required>
                        <img src="/assets/eyes.png" alt="Toggle Password" class="toggle-password" onclick="togglePassword()">

                        <script>
                        function togglePassword() {
                            const passwordInput = document.getElementById('passwordInput');
                            if (passwordInput.type === 'password') {
                                passwordInput.type = 'text';
                            } else {
                                passwordInput.type = 'password';
                            }
                        }
                        </script>

                    </div>
                </div>
                <button type="submit" class="btn-sign-up">Sign Up</button>
                <!--<button class="btn-sign-up" onclick="window.location.href='{{ route('login') }}'">Sign Up</button>-->
            </form>
        </div>
    </div>
</body>
</html>
