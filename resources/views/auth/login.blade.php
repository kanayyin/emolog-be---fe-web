<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body>
    <div class="login-container">
        <div class="login-left-side">
            <h1>Sign In to Emolog</h1>
            <p>or use your e-mail account:</p>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <div class="input-with-icon">
                        <img src="{{asset('images/account.png')}}" alt="Profile Icon" class="input-icon">
                        <input type="text" name="username" placeholder="Username" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-with-icon">
                        <img src="{{asset('images/pass.png')}}" alt="Profile Icon" class="input-icon">
                        <input type="password" name="password" id="passwordInput" placeholder="Password" required>
                        <img src="{{asset('images/eyeopen.png')}}" alt="Toggle Password" class="toggle-password" onclick="togglePassword()">

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
                <button type="submit" class="login-btn-sign-in">Sign In</button>
                @if ($errors->has('username'))
                    <div class="alert alert-danger mt-3">
                        {{ $errors->first('username') }}
                    </div>
                @endif

            </form>

        </div>
        <div class="login-right-side">
            <h1>Hello dear!</h1>
            <p>Enter your personal details and start your journey with us</p>
            <button class="login-btn-sign-up" onclick="window.location.href='{{ route('register') }}'">Sign Up</button>
        </div>
    </div>
</body>
</html>
