<h2>Klienti un viņu pasūtījumi</h2>
<a href="/customers" class="btn btn-edit" style="background:#6c757d; margin-bottom: 20px;">Atpakaļ uz parasto sarakstu</a>

<ul>
    <?php foreach ($customers as $customer): ?>
        <li>
            <strong><?php echo htmlspecialchars($customer->name . ' ' . $customer->last_name); ?></strong> 
            (<?php echo htmlspecialchars($customer->email); ?>) - <?php echo $customer->points; ?> punkti
            
            <?php if (!empty($customer->orders)): ?>
                <ul style="margin-top: 5px; margin-bottom: 15px; color: #555;">
                    <?php foreach ($customer->orders as $order): ?>
                        <li>
                            Pasūtījums #<?php echo $order->order_id; ?>: 
                            <?php echo htmlspecialchars($order->date); ?> - 
                            <em><?php echo htmlspecialchars($order->status); ?></em>
                            <?php if ($order->comments): ?>
                                (Komentārs: <?php echo htmlspecialchars($order->comments); ?>)
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p style="color: #999; font-size: 0.9em; margin-left: 20px;">Nav veiktu pasūtījumu.</p>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
