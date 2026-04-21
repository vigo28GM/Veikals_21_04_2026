<h2>Klientu saraksts</h2>
<a href="/customers/create" class="btn btn-add">Pievienot jaunu klientu</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Vārds</th>
            <th>Uzvārds</th>
            <th>E-pasts</th>
            <th>Punkti</th>
            <th>Darbības</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customers as $customer): ?>
        <tr>
            <td><?php echo htmlspecialchars($customer['customer_id']); ?></td>
            <td><?php echo htmlspecialchars($customer['name']); ?></td>
            <td><?php echo htmlspecialchars($customer['last_name']); ?></td>
            <td><?php echo htmlspecialchars($customer['email']); ?></td>
            <td><?php echo htmlspecialchars($customer['points']); ?></td>
            <td>
                <a href="/customers/edit?id=<?php echo $customer['customer_id']; ?>" class="btn btn-edit">Labot</a>
                <a href="/customers/delete?id=<?php echo $customer['customer_id']; ?>" class="btn btn-delete" onclick="return confirm('Vai tiešām dzēst?')">Dzēst</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
