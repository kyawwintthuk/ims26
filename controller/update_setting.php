<?php
// 2026-07-12 Sunday 13:29PM
// To store radio button checked value

include('../db/config.php');
$id = $_POST['id'];
$value = $_POST['value'];
$option1 = isset($_POST['option1']) ? $_POST['option1']: '';
$option2 = isset($_POST['option2']) ? $_POST['option2']: '';

$sql = "INSERT INTO `setting` (`id`,`value`,`option1`,`option2`) VALUES ('$id','$value','$option1','$option2')
        ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `option1` = VALUES(`option1`), `option2` = VALUES(`option2`)";

$result = $conn->query($sql);
if($result){
    if($conn->affected_rows > 0){
        echo 'Inserted';
    } else {
        echo 'Updated';
    }
}else {
    echo 'Error: ' . $conn->error;
}

