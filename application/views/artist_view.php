<!DOCTYPE html>
<html>
<head>
    <title>Add Artist</title>
</head>
<body>
    <?php if (isset($logged_in) && $logged_in === TRUE): ?>
        <h3>You are logged in. <a href="<?php echo base_url() . 'admin_login/logout' ?>">Logout</a>.</h3>
        <form action="<?php echo base_url() . 'artist_controller/add_artist' ?>" method="POST">
            <input type="text" name="artist_name" id="artist_name" placeholder="Artist_name"/>
            <input type="submit" value="Add Artist"/>
        </form>
		<br>
        <?php echo form_dropdown('id', $form_names); ?>
		<input type="submit" value="Remove Artist"/>
    <?php endif; ?>

</body>
</html>