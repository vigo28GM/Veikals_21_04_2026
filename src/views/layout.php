<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Veikals</title>
    <style>
        body { font-family: sans-serif; margin: 20px; background: #f4f4f4; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        nav { margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        nav a { margin-right: 15px; text-decoration: none; color: #007bff; font-weight: bold; }
        nav a:hover { text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; }
        .btn { padding: 8px 12px; text-decoration: none; border-radius: 4px; color: white; display: inline-block; font-size: 14px; }
        .btn-add { background: #28a745; margin-bottom: 10px; }
        .btn-edit { background: #007bff; }
        .btn-delete { background: #dc3545; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; box-sizing: border-box; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Veikals</h1>
        <nav>
            <?php 
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); 
            ?>
            <a href="/" style="<?php echo $uri === '/' ? 'text-decoration: underline;' : ''; ?>">Sākums</a>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/customers" style="<?php echo strpos($uri, '/customers') === 0 && !isset($_GET['with-orders']) ? 'text-decoration: underline;' : ''; ?>">Klienti</a>
                <a href="/customers?with-orders=full" style="<?php echo isset($_GET['with-orders']) ? 'text-decoration: underline;' : ''; ?>">Hierarhija</a>
                <a href="/orders" style="<?php echo strpos($uri, '/orders') === 0 ? 'text-decoration: underline;' : ''; ?>">Pasūtījumi</a>
                
                <span style="float: right;">
                    Sveiki, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>!
                    <a href="/logout" style="margin-left: 10px; color: #dc3545;">Izrakstīties</a>
                </span>
            <?php else: ?>
                <span style="float: right;">
                    <a href="/login" style="<?php echo $uri === '/login' ? 'text-decoration: underline;' : ''; ?>">Pieteikties</a>
                    <a href="/register" style="<?php echo $uri === '/register' ? 'text-decoration: underline;' : ''; ?>">Reģistrēties</a>
                </span>
            <?php endif; ?>
        </nav>
        <?php echo $content; ?>
    </div>
</body>
</html>
