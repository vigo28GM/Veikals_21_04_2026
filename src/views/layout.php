<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Veikals - Administratīvais panelis</title>
    <style>
        /* Pamata noformējums lapas vizuālajam tēlam */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 20px; background: #f4f4f4; color: #333; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        
        /* Navigācijas joslas stils */
        nav { margin-bottom: 30px; border-bottom: 2px solid #eee; padding-bottom: 15px; }
        nav a { margin-right: 20px; text-decoration: none; color: #007bff; font-weight: 600; transition: color 0.2s; }
        nav a:hover { color: #0056b3; text-decoration: underline; }
        
        /* Tabulu noformējums datiem */
        table { width: 100%; border-collapse: collapse; margin-top: 25px; background: #fff; }
        th, td { padding: 14px; text-align: left; border-bottom: 1px solid #eee; }
        th { background-color: #f8f9fa; color: #495057; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; }
        tr:hover { background-color: #f1f1f1; }
        
        /* Pogu stili dažādām darbībām */
        .btn { padding: 10px 16px; text-decoration: none; border-radius: 6px; color: white; display: inline-block; font-size: 14px; border: none; cursor: pointer; transition: opacity 0.2s; }
        .btn:hover { opacity: 0.85; }
        .btn-add { background: #28a745; margin-bottom: 15px; }
        .btn-edit { background: #007bff; }
        .btn-delete { background: #dc3545; }
        
        /* Formu lauku noformējums */
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        
        /* Kļūdu paziņojumi */
        .error-msg { color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Lapas galvene un galvenā navigācija -->
        <header>
            <h1>Sistēma "Veikals"</h1>
            <nav>
                <?php 
                // Nosakām pašreizējo URL, lai iezīmētu aktīvo sadaļu
                $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); 
                ?>
                <a href="/" style="<?php echo $uri === '/' ? 'color: #333; pointer-events: none;' : ''; ?>">Sākums</a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Sadaļas, kas pieejamas tikai autorizētiem lietotājiem -->
                    <a href="/customers" style="<?php echo strpos($uri, '/customers') === 0 && !isset($_GET['with-orders']) ? 'text-decoration: underline;' : ''; ?>">Klienti</a>
                    <a href="/customers?with-orders=full" style="<?php echo isset($_GET['with-orders']) ? 'text-decoration: underline;' : ''; ?>">Hierarhija</a>
                    <a href="/orders" style="<?php echo strpos($uri, '/orders') === 0 ? 'text-decoration: underline;' : ''; ?>">Pasūtījumi</a>
                    
                    <!-- Lietotāja informācija un izrakstīšanās -->
                    <span style="float: right;">
                        Lietotājs: <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
                        <a href="/logout" style="margin-left: 15px; color: #dc3545;">Izrakstīties</a>
                    </span>
                <?php else: ?>
                    <!-- Viesu piekļuves saites -->
                    <span style="float: right;">
                        <a href="/login" style="<?php echo $uri === '/login' ? 'text-decoration: underline;' : ''; ?>">Pieteikties</a>
                        <a href="/register" style="<?php echo $uri === '/register' ? 'text-decoration: underline;' : ''; ?>">Reģistrēties</a>
                    </span>
                <?php endif; ?>
            </nav>
        </header>

        <!-- Galvenais satura bloks, kurā tiek ielādēti dažādi skati -->
        <main>
            <?php echo $content; ?>
        </main>

        <!-- Lapas kājene -->
        <footer style="margin-top: 40px; text-align: center; font-size: 12px; color: #999; border-top: 1px solid #eee; padding-top: 20px;">
            &copy; <?php echo date('Y'); ?> Veikala vadības sistēma. Visas tiesības aizsargātas.
        </footer>
    </div>
</body>
</html>
