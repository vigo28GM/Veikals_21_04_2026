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
            <a href="/customers">Klienti</a>
            <a href="/orders">Pasūtījumi</a>
        </nav>
        <?php echo $content; ?>
    </div>
</body>
</html>
