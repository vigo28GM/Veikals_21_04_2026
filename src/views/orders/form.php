<h2><?php echo isset($order) ? 'Labot pasūtījumu' : 'Pievienot pasūtījumu'; ?></h2>
<form action="<?php echo isset($order) ? '/orders/update' : '/orders/store'; ?>" method="POST">
    <?php if (isset($order)): ?>
        <input type="hidden" name="order_id" value="<?php echo $order->order_id; ?>">
    <?php endif; ?>
    
    <div class="form-group">
        <label>Klients:</label>
        <select name="customer_id" required style="width:100%; padding:8px;">
            <?php foreach ($customers as $customer): ?>
                <option value="<?php echo $customer->customer_id; ?>" <?php echo (isset($order) && $order->customer_id == $customer->customer_id) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($customer->name . ' ' . $customer->last_name); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>Datums:</label>
        <input type="date" name="date" value="<?php echo $order->date ?? date('Y-m-d'); ?>" required>
    </div>
    <div class="form-group">
        <label>Statuss:</label>
        <input type="text" name="status" value="<?php echo $order->status ?? ''; ?>" required>
    </div>
    <div class="form-group">
        <label>Komentārs:</label>
        <input type="text" name="comments" value="<?php echo $order->comments ?? ''; ?>">
    </div>
    <div class="form-group">
        <label>Piegādes datums:</label>
        <input type="date" name="arrived_at" value="<?php echo $order->arrived_at ?? ''; ?>">
    </div>
    
    <button type="submit" class="btn btn-edit"><?php echo isset($order) ? 'Saglabāt izmaiņas' : 'Pievienot'; ?></button>
    <a href="/orders" class="btn btn-delete" style="background:#6c757d;">Atcelt</a>
</form>
