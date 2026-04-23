<h2>Reģistrēties</h2>

<?php if (isset($error)): ?>
    <div style="color: red; margin-bottom: 10px;"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form action="/register" method="post">
    <div>
        <label>Lietotājvārds:</label>
        <input type="text" name="username" required>
    </div>
    <div style="margin-top: 10px;">
        <label>E-pasts:</label>
        <input type="email" name="email" required>
    </div>
    <div style="margin-top: 10px;">
        <label>Parole:</label>
        <input type="password" name="password" required>
    </div>
    <div style="margin-top: 10px;">
        <button type="submit">Reģistrēties</button>
    </div>
</form>

<p style="margin-top: 20px;">
    Jau ir konts? <a href="/login">Pieteikties</a>
</p>
