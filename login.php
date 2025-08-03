<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f6f8fb;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: #333;
        }

        .login-container {
            background: #ffffff;
            border: 1px solid #e1e5ee;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            width: 100%;
            max-width: 400px;
            padding: 2.5rem 2rem;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            font-size: 1.75rem;
            margin: 0 0 0.5rem;
            font-weight: 600;
            color: #222;
        }

        .login-header p {
            font-size: 0.95rem;
            color: #666;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
            font-size: 0.95rem;
            transition: border 0.2s ease;
        }

        input:focus {
            outline: none;
            border-color: #4c7ef3;
            background-color: #fff;
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background-color: #4c7ef3;
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        button:hover {
            background-color: #3a6ee6;
        }

        .error-message {
            background-color: #fff0f0;
            color: #b00020;
            border: 1px solid #f5c2c7;
            padding: 0.75rem;
            border-radius: 6px;
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 1.25rem;
        }

        .footer-note {
            text-align: center;
            font-size: 0.8rem;
            color: #999;
            margin-top: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Sign In</h1>
            <p>Access your dashboard</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="authenticate.php">
            <input type="text" name="userid" placeholder="User ID" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit">Continue</button>
        </form>

        
    </div>
</body>
</html>
