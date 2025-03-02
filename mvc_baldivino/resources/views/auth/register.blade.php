<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Student Information System</title>
    
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
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .register-container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            padding: 2rem;
        }

        .register-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .register-header h1 {
            color: #2D3748;
            font-size: 1.75rem;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            color: #4A5568;
            font-size: 0.813rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .form-control {
            width: 100%;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
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

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%234A5568' viewBox='0 0 16 16'%3E%3Cpath d='M8 11.5l-5-5h10l-5 5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-align: center;
            border-radius: 12px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            margin-bottom: 1rem;
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
            font-size: 0.813rem;
        }

        .footer-links a {
            color: #6C5DD3;
            text-decoration: none;
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
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .register-container {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-header">
            <h1>Create an Account!</h1>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}" 
                       required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control @error('role') is-invalid @enderror" 
                        id="role" 
                        name="role" 
                        required>
                    <option value="">Select Role</option>
                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" 
                       class="form-control" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       required>
            </div>

            <button type="submit" class="btn btn-primary">
                Register Account
            </button>

            <div class="footer-links">
                <a href="{{ route('login') }}">Already have an account? Login!</a>
            </div>
        </form>
    </div>
</body>

</html>
