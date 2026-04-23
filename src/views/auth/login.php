<?php
/**
 * Autentifikācijas skats: Lietotāja pieteikšanās forma.
 * 
 * Mainīgie:
 * - $error: Neobligāts kļūdas paziņojums, ja pieteikšanās nav veiksmīga.
 * 
 * Loģika:
 * - Pārbauda, vai ir iestatīts $error, un attēlo to lietotājam.
 */
?>
<h2>Pieteikties</h2>

<?php if (isset($error)): ?>
    <div style="color: red; margin-bottom: 10px;"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form action="/login" method="post">
    <div>
        <label>Lietotājvārds:</label>
        <input type="text" name="username" required>
    </div>
    <div style="margin-top: 10px;">
        <label>Parole:</label>
        <input type="password" name="password" required>
    </div>
    <div style="margin-top: 10px;">
        <button type="submit">Pieteikties</button>
    </div>
</form>

<p style="margin-top: 20px;">
    Nav konta? <a href="/register">Reģistrēties</a>
</p>
