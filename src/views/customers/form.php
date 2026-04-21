<h2><?php echo isset($customer) ? 'Labot klientu' : 'Pievienot klientu'; ?></h2>
<form action="<?php echo isset($customer) ? '/customers/update' : '/customers/store'; ?>" method="POST">
    <?php if (isset($customer)): ?>
        <input type="hidden" name="customer_id" value="<?php echo $customer['customer_id']; ?>">
    <?php endif; ?>
    
    <div class="form-group">
        <label>Vārds:</label>
        <input type="text" name="name" value="<?php echo $customer['name'] ?? ''; ?>" required>
    </div>
    <div class="form-group">
        <label>Uzvārds:</label>
        <input type="text" name="last_name" value="<?php echo $customer['last_name'] ?? ''; ?>" required>
    </div>
    <div class="form-group">
        <label>E-pasts:</label>
        <input type="email" name="email" value="<?php echo $customer['email'] ?? ''; ?>" required>
    </div>
    <div class="form-group">
        <label>Dzimšanas datums:</label>
        <input type="date" name="birthday" value="<?php echo $customer['birthday'] ?? ''; ?>">
    </div>
    <div class="form-group">
        <label>Punkti:</label>
        <input type="number" name="points" value="<?php echo $customer['points'] ?? 0; ?>">
    </div>
    
    <button type="submit" class="btn btn-edit"><?php echo isset($customer) ? 'Saglabāt izmaiņas' : 'Pievienot'; ?></button>
    <a href="/customers" class="btn btn-delete" style="background:#6c757d;">Atcelt</a>
</form>
