<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - School Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 48px 40px;
            width: 100%;
            max-width: 400px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        }
        .login-header {
            text-align: center;
            margin-bottom: 36px;
        }
        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 36px;
        }
        .login-header h1 {
            color: #fff;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .login-header .subtitle {
            color: rgba(255, 255, 255, 0.5);
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
        }
        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.03);
            color: #fff;
            font-size: 15px;
            transition: all 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.05);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }
        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }
        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        .remember-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .remember-group input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #3b82f6;
            border-radius: 4px;
        }
        .remember-group label {
            color: rgba(255, 255, 255, 0.6);
            font-size: 13px;
            cursor: pointer;
        }
        .forgot-link {
            color: #3b82f6;
            font-size: 13px;
            text-decoration: none;
            transition: color 0.3s;
        }
        .forgot-link:hover {
            color: #60a5fa;
        }
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
        }
        .btn-login:active {
            transform: translateY(0);
        }
        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 20px;
            color: #fca5a5;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .error-message::before {
            content: "⚠";
            font-size: 16px;
        }
        .footer {
            margin-top: 24px;
            text-align: center;
            color: rgba(255, 255, 255, 0.4);
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <div class="logo">🏫</div>
                <h1>School Management System</h1>
                <p class="subtitle">Sign in to your account</p>
            </div>
            
            @if($errors->any())
            <div class="error-message">
                <div>
                    @foreach($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            </div>
            @endif
            
            <form method="POST" action="{{ url('/login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" 
                           value="{{ old('email') }}" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                
                <div class="options-row">
                    <div class="remember-group">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    <a href="#" class="forgot-link">Forgot password?</a>
                </div>
                
                <button type="submit" class="btn-login">Sign In</button>
            </form>
        </div>
        
        <div class="footer">
            © {{ date('Y') }} School Management System. All rights reserved.
        </div>
    </div>
</body>
</html>
