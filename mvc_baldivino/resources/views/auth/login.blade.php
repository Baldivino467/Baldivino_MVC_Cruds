<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Student Information System</title>
    
    <!-- Custom fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #6C5DD3 0%, #8674e9 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            padding: 2.5rem;
            margin: 1rem;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-header h1 {
            color: #2D3748;
            font-size: 1.875rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            color: #4A5568;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            line-height: 1.5;
            color: #2D3748;
            background-color: #F7FAFC;
            border: 2px solid #EDF2F7;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #6C5DD3;
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(108, 93, 211, 0.1);
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .remember-me input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
            margin-right: 0.5rem;
            border-radius: 4px;
            border: 2px solid #CBD5E0;
            cursor: pointer;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 0.875rem 1.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-align: center;
            border-radius: 12px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background-color: #6C5DD3;
            color: white;
        }

        .btn-primary:hover {
            background-color: #5a4cb4;
            transform: translateY(-1px);
        }

        .footer-links {
            text-align: center;
        }

        .footer-links a {
            color: #6C5DD3;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #5a4cb4;
            text-decoration: underline;
        }

        /* Error Messages */
        .error-message {
            color: #E53E3E;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-container {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Welcome Back!</h1>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autocomplete="email" 
                       autofocus>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       required 
                       autocomplete="current-password">
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="remember-me">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Remember Me</label>
            </div>

            <button type="submit" class="btn btn-primary">
                Login
            </button>

            <div class="footer-links">
                <a href="{{ route('register') }}">Create an Account!</a>
            </div>
        </form>
    </div>
</body>
</html>
