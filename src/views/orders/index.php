<?php
/**
 * Pasūtījumu saraksta skats: Tabula ar visiem pasūtījumiem un filtrēšanas iespējām.
 * 
 * Mainīgie:
 * - $orders: Pasūtījumu saraksts ar piesaistītajiem klientu vārdiem.
 * - $currentStatus: Pašreizējais aktīvais filtrs pēc statusa.
 * 
 * Loģika:
 * - Piedāvā filtrēšanas saites, vizuāli izceļot aktīvo filtru.
 * - Cikls cauri pasūtījumiem, lai tos attēlotu tabulā.
 * - Katram pasūtījumam ir pogas skatīšanai, labošanai un dzēšanai (ar formas palīdzību).
 */
?>
<h2>Pasūtījumu saraksts</h2>

<div style="margin-bottom: 20px;">
    Filtrēt pēc statusa:
    <a href="/orders" style="<?php echo !$currentStatus ? 'font-weight: bold; text-decoration: none; color: black;' : ''; ?>">Visi</a> |
    <a href="/orders?status=Jauns" style="<?php echo $currentStatus === 'Jauns' ? 'font-weight: bold; text-decoration: none; color: black;' : ''; ?>">Jauns</a> |
    <a href="/orders?status=Procesā" style="<?php echo $currentStatus === 'Procesā' ? 'font-weight: bold; text-decoration: none; color: black;' : ''; ?>">Procesā</a> |
    <a href="/orders?status=Pabeigts" style="<?php echo $currentStatus === 'Pabeigts' ? 'font-weight: bold; text-decoration: none; color: black;' : ''; ?>">Pabeigts</a>
</div>

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
            <td><?php echo htmlspecialchars($order->order_id); ?></td>
            <td><?php echo htmlspecialchars($order->name . ' ' . $order->last_name); ?></td>
            <td><?php echo htmlspecialchars($order->date); ?></td>
            <td><?php echo htmlspecialchars($order->status); ?></td>
            <td><?php echo htmlspecialchars($order->arrived_at ?? '-'); ?></td>
            <td>
                <a href="/orders/show?id=<?php echo $order->order_id; ?>" class="btn btn-edit" style="background: #17a2b8;">Skatīt</a>
                <a href="/orders/edit?id=<?php echo $order->order_id; ?>" class="btn btn-edit">Labot</a>
                <form action="/orders/delete" method="POST" style="display:inline;" onsubmit="return confirm('Vai tiešām dzēst?');">
                    <input type="hidden" name="id" value="<?php echo $order->order_id; ?>">
                    <button type="submit" class="btn btn-delete">Dzēst</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
