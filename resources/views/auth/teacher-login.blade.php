<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Login - SMS System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h1 {
            color: #10b981;
            font-size: 28px;
            margin-bottom: 10px;
        }
        .login-header p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 8px;
            font-size: 14px;
        }
        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            font-size: 16px;
            transition: all 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        }
        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }
        .remember-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }
        .remember-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #10b981;
        }
        .remember-group label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            cursor: pointer;
        }
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }
        .error-message {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.5);
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 20px;
            color: #fca5a5;
            font-size: 14px;
        }
        .demo-credentials {
            margin-top: 20px;
            padding: 15px;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 10px;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        .demo-credentials p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
            margin-bottom: 5px;
        }
        .demo-credentials code {
            color: #10b981;
            background: rgba(0, 0, 0, 0.3);
            padding: 2px 6px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>🎓 Teacher Portal</h1>
            <p>Sign in to access your dashboard</p>
        </div>
        
        @if(session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
        @endif
        
        @if($errors->any())
        <div class="error-message">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif
        
        <form method="POST" action="{{ url('/teacher/login') }}">
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
            
            <div class="remember-group">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>
            
            <button type="submit" class="btn-login">Sign In</button>
        </form>
        
        <div class="demo-credentials">
            <p><strong>Demo Login:</strong></p>
            <p>Email: <code>teacher@school.com</code></p>
            <p>Password: <code>password</code></p>
        </div>
    </div>
</body>
</html>
