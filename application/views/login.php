<!DOCTYPE html>
<html>
<head>
    <title>Secure Login: Log In</title>
</head>
<body>
    <?php if (isset($logged_in) && $logged_in === TRUE): ?>
        <h3>You are logged in. <a href="<?php echo base_url() . 'admin_login/logout' ?>">Logout</a>.</h3>
    <?php else: ?>
        <?php if (isset($wrong_credentials) && $wrong_credentials === TRUE): ?>
            <h3>Wrong username or password. Please try again.</h3>
		<?php elseif (isset($logged_out) && $logged_out === TRUE): ?>
			<h3>You have logged out successfully.</h3>
        <?php endif; ?>
        <form action="<?php echo base_url() . 'admin_login/login' ?>" method="POST">
            <input type="text" name="username" id="username" placeholder="Username"/>
            <input type="password" name="password" id="password" placeholder="Password"/>
            <input type="submit" value="Login"/>
        </form>
    <?php endif; ?>
</body>
</html>