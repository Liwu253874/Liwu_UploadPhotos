<?php
// 检查是否会话已经启动
if (session_status() === PHP_SESSION_NONE) {
    // 确保只在会话未启动时设置 session 配置
    ini_set('session.cookie_lifetime', 0);  // 设置会话在浏览器关闭时失效
    session_start(); // 启动会话
} else {
    session_start(); // 仅启动会话，不修改 session 配置
}

// 登录验证逻辑
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 检查用户名和密码是否正确
    if ($username === 'admin' && $password === 'abc123') {
        $_SESSION['logged_in'] = true;
        header('Location: index.php');
        exit();
    } else {
        $error = "用户名或密码错误";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录后台</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        .login-container {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            width: 300px;
            background-color: #f5f5f5;
        }
        input[type="text"], input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 3px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 3px;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>登录后台</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="login.php">
            <input type="text" name="username" placeholder="用户名" required>
            <input type="password" name="password" placeholder="密码" required>
            <input type="submit" value="登录">
        </form>
    </div>
</body>
</html>
