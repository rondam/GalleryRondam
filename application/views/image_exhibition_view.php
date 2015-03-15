<!DOCTYPE html>
<html>
<head>
    <title>Upload Image</title>
</head>
<body>

<?php if (isset($logged_in) && $logged_in === TRUE): ?>
<h3>You are logged in. <a href="<?php echo base_url() . 'admin_login/logout' ?>">Logout</a>.</h3>

    <?php
    echo '<h3>';
    echo ('Title: ' . $image_name);
    echo '</h3>';

    echo ('Select the Exhibition(s) where the piece will be displayed:');
    echo '<br>';
    echo '<br>';

    $hidden = array('operation_type' => 'select');
    echo form_open('admin_image_controller/exhibition/' . $id, null, $hidden);
    echo form_multiselect('exhibitions[]',$exhibitions,$selected_exhibitions);
    echo form_submit('submit','Submit');
    echo form_close();
    ?>

<?php endif; ?>

</body>
</html>