<?php
/**
 * Sākumlapas skats: Sistēmas pārskats un statistika.
 * 
 * Mainīgie:
 * - $customerCount: Kopējais klientu skaits.
 * - $orderCount: Kopējais pasūtījumu skaits.
 * - $statusStats: Statistikas dati par pasūtījumiem sadalījumā pa statusiem.
 * 
 * Loģika:
 * - Attēlo kopsavilkuma blokus ar galvenajiem rādītājiem.
 * - Izmanto ciklu, lai uzskaitītu pasūtījumu skaitu katrā statusā.
 */
?>
<h2>Sistēmas statistika</h2>

<div style="display: flex; gap: 20px; margin-top: 20px;">
    <div style="background: #e7f3ff; padding: 20px; border-radius: 8px; flex: 1; text-align: center; border: 1px solid #b6d4fe;">
        <h3 style="margin: 0; color: #084298;">Klienti</h3>
        <p style="font-size: 24px; font-weight: bold; margin: 10px 0;"><?php echo $customerCount; ?></p>
    </div>
    <div style="background: #e2fbe8; padding: 20px; border-radius: 8px; flex: 1; text-align: center; border: 1px solid #badbcc;">
        <h3 style="margin: 0; color: #0f5132;">Pasūtījumi</h3>
        <p style="font-size: 24px; font-weight: bold; margin: 10px 0;"><?php echo $orderCount; ?></p>
    </div>
</div>

<h3 style="margin-top: 30px;">Pasūtījumi pēc statusa</h3>
<ul>
    <?php foreach ($statusStats as $stat): ?>
    <li><strong><?php echo htmlspecialchars($stat['status']); ?>:</strong> <?php echo $stat['count']; ?></li>
    <?php endforeach; ?>
</ul>
