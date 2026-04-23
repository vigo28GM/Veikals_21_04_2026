<?php
/**
 * Pasūtījuma detaļu skats: Detalizēta informācija un komentāru pārvaldība.
 * 
 * Mainīgie:
 * - $order: Pasūtījuma objekts ar visiem pamatdatiem.
 * - $comments: Masīvs ar visiem šim pasūtījumam pievienotajiem komentāriem.
 * 
 * Loģika:
 * - Parāda pasūtījuma galveno informāciju.
 * - Pārbauda, vai ir komentāri: ja ir, izvada tos ciklā; ja nav, parāda paziņojumu.
 * - Ietver formu jauna komentāra pievienošanai.
 */
?>
<h2>Pasūtījuma #<?= $order->order_id ?> detaļas</h2>

<div style="margin-bottom: 20px; padding: 15px; background: #f9f9f9; border-radius: 5px;">
    <p><strong>Datums:</strong> <?= htmlspecialchars($order->date) ?></p>
    <p><strong>Statuss:</strong> <?= htmlspecialchars($order->status) ?></p>
    <p><strong>Klients:</strong> <?= htmlspecialchars($order->customer_name ?? 'Nav norādīts') ?></p>
    <p><strong>Sākotnējais komentārs:</strong> <?= htmlspecialchars($order->comments) ?></p>
</div>

<h3>Komentāri</h3>

<?php if (empty($comments)): ?>
    <p>Šim pasūtījumam vēl nav pievienoti komentāri.</p>
<?php else: ?>
    <div style="margin-bottom: 20px;">
        <?php foreach ($comments as $comment): ?>
            <div style="border-bottom: 1px solid #eee; padding: 10px 0;">
                <small style="color: #666;"><?= $comment->created_at ?></small>
                <p style="margin: 5px 0;"><?= nl2br(htmlspecialchars($comment->comment_text)) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div style="margin-top: 30px; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">
    <h4>Pievienot jaunu komentāru</h4>
    <form action="/orders/comment" method="post">
        <input type="hidden" name="order_id" value="<?= $order->order_id ?>">
        <div class="form-group">
            <textarea name="comment_text" style="width: 100%; height: 80px; padding: 8px;" placeholder="Ierakstiet komentāru šeit..." required></textarea>
        </div>
        <button type="submit" class="btn btn-edit">Pievienot</button>
    </form>
</div>

<p style="margin-top: 20px;">
    <a href="/orders">Atpakaļ uz sarakstu</a>
</p>
