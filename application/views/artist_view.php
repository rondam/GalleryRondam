<!DOCTYPE html>
<html>
<head>
    <title>Add Artist</title>
</head>
<body>
<?php if (isset($logged_in) && $logged_in === TRUE): ?>
    <h3>You are logged in. <a href="<?php echo base_url() . 'admin_login/logout' ?>">Logout</a>.</h3>
    <?php
    $hidden = array('operation_type' => 'add');
    echo form_open('artist_controller', null, $hidden);

    echo form_input('artist_name', '');
    echo form_submit('submit1', 'Add Artist');

    echo form_close();
    ?>
    <br>

    <?php
    $hidden = array('operation_type' => 'remove');
    echo form_open('artist_controller', null, $hidden);
    echo form_dropdown('id', $form_names);
    echo form_submit('submit2', 'Remove Artist');
    echo form_close();
    ?>
    <?php if (isset($artist_added) && $artist_added === TRUE): ?>
        <h2>The artist has been added</h2>
    <?php endif; ?>
    <?php if (isset($error_adding_artist) && $error_adding_artist === TRUE): ?>
        <h2>Error while adding artist</h2>
    <?php endif; ?>
    <?php if (isset($artist_removed) && $artist_removed === TRUE): ?>
        <h2>The artist has been deleted</h2>
    <?php endif; ?>
    <?php if (isset($error_removing_artist) && $error_removing_artist === TRUE): ?>
        <h2>Error while deleting artist</h2>
    <?php endif; ?>
<?php else: ?>
    <?php if (isset($wrong_credentials) && $wrong_credentials === TRUE): ?>
        <a href="<?php echo base_url() . 'admin_login/login' ?>">You need to login</a>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>