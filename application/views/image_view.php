<!DOCTYPE html>
<html>
<head>
    <title>Upload Image</title>
</head>
<body>
<?php if (isset($logged_in) && $logged_in === TRUE): ?>
    <h3>You are logged in. <a href="<?php echo base_url() . 'admin_login/logout' ?>">Logout</a>.</h3>

    <?php
    echo ('Upload the image:');
    echo '<br>';
    echo '<br>';
    $hidden = array('operation_type' => 'upload');
    echo form_open_multipart('admin_image_controller', null, $hidden);
    echo ('Author:');
    echo form_dropdown('image_author', $form_names);
    echo('Title:');
    echo form_input('image_name','');
    echo '<br>';
    echo '<br>';
    echo form_upload('userfile');
    echo '<br>';
    echo '<br>';
    echo form_submit('submit','Upload Image');

    echo form_close();
    ?>

    <br>

    <?php
    echo ('Delete the image:');
    echo '<br>';
    echo '<br>';
    $hidden = array('operation_type' => 'remove');
    echo form_open('admin_image_controller', null, $hidden);
    echo form_dropdown('show_image_name',$form_images);
    echo form_submit('submit','Delete Image');
    echo form_close();
    ?>

<?php endif; ?>

</body>
</html>