<h2>Add New User</h2>
<form method="post" action="<?= site_url('auth/addUser') ?>">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin">
        <label class="form-check-label" for="is_admin">Administrator</label>
    </div>
    <button type="submit" class="btn btn-success mt-2">Add User</button>
</form> 