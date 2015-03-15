<!DOCTYPE html>
<html>
<head>
    <title>Upload Image</title>
</head>
<body>
<?php
    $hidden = array('operation_type' => 'upload_image');
    echo form_open('admin_image_controller', null, $hidden);
?>
Author:
<?php
    echo form_input('image_author','');
?>
Title:
<?php
    echo form_input('image_name','');
echo '<br>';
echo '<br>';
    echo form_upload('image_dir');
    echo '<br>';
echo '<br>';
    echo form_submit('submit','Upload Image');

    echo form_close();
?>

</body>
</html>