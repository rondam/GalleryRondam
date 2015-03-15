<!DOCTYPE html>
<html>
<head>
    <title>Add Exhibition</title>
</head>
<body>
<?php if (isset($logged_in) && $logged_in === TRUE): ?>
    <h3>You are logged in. <a href="<?php echo base_url() . 'admin_login/logout' ?>">Logout</a>.</h3>
    <?php
    $hidden = array('operation_type' => 'add');
    echo form_open('exhibition_controller', null, $hidden);

    echo form_input('exhibition_name', '');
    echo form_submit('submit1', 'Add Exhibition');

    echo form_close();
    ?>
    <br>

    <?php
    $hidden = array('operation_type' => 'remove');
    echo form_open('exhibition_controller', null, $hidden);
    echo form_dropdown('id', $form_names);
    echo form_submit('submit2', 'Remove Exhibition');
    echo form_close();
    ?>
    <?php if (isset($exhibition_added) && $exhibition_added === TRUE): ?>
        <h2>The exhibition has been created</h2>
    <?php endif; ?>
    <?php if (isset($error_adding_exhibition) && $error_adding_exhibition === TRUE): ?>
        <h2>Error while creating the exhibition</h2>
    <?php endif; ?>
    <?php if (isset($exhibition_removed) && $exhibition_removed === TRUE): ?>
        <h2>The exhibition has been deleted</h2>
    <?php endif; ?>
    <?php if (isset($error_removing_exhibition) && $error_removing_exhibition === TRUE): ?>
        <h2>Error while deleting exhibition</h2>
    <?php endif; ?>
<?php else: ?>
    <?php if (isset($wrong_credentials) && $wrong_credentials === TRUE): ?>
        <a href="<?php echo base_url() . 'admin_login/login' ?>">You need to login</a>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>