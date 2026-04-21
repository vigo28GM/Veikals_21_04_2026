<h2>Pasūtījumu saraksts</h2>
<a href="/orders/create" class="btn btn-add">Pievienot jaunu pasūtījumu</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Klients</th>
            <th>Datums</th>
            <th>Statuss</th>
            <th>Piegādāts</th>
            <th>Darbības</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
            <td><?php echo htmlspecialchars($order['name'] . ' ' . $order['last_name']); ?></td>
            <td><?php echo htmlspecialchars($order['date']); ?></td>
            <td><?php echo htmlspecialchars($order['status']); ?></td>
            <td><?php echo htmlspecialchars($order['arrived_at'] ?? '-'); ?></td>
            <td>
                <a href="/orders/edit?id=<?php echo $order['order_id']; ?>" class="btn btn-edit">Labot</a>
                <a href="/orders/delete?id=<?php echo $order['order_id']; ?>" class="btn btn-delete" onclick="return confirm('Vai tiešām dzēst?')">Dzēst</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
