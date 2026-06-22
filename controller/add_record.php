<?php
include('../db/config.php');
session_start();

$id = isset($_POST['id']) ? $_POST['id'] : '';
$operation = $_POST['operation'];
$category = $_POST['category'];
$name = $_POST['name'];
$description = $_POST['description'];
$image_url = $_POST['image_url'];
$google_sheet_url = $_POST['google_sheet_url'];
$linkedin_url = $_POST['linkedin_url'];
$gmail_url = $_POST['gmail_url'];
$date = date('Y-m-d', strtotime($_POST['date']));

if (isset($_POST['add'])) {
    if ($operation == 'Record') {
        $sql = "
            INSERT INTO `record`(`name`, `description`, `image_url`, `google_sheet_url` ,`linkedin_url`, `gmail_url`, `category_id`, `date`, `sys_date`) 
            VALUES ('$name','$description', '$image_url', '$google_sheet_url', '$linkedin_url', '$gmail_url', '$category', '$date', '$date');
        ";
    }

    if ($operation == 'Category') {
        $sql = "
        INSERT INTO `category`(`name`, `description`, `sys_date`) 
        VALUES ('$name','$description', '" . date('Y-m-d') . "');
    ";
    }

    if ($operation == 'Location') {
        $sql = "
            INSERT INTO `location`(`name`,`description`,`sys_date`)
            VALUES ('$name','$description', '" . date('Y-m-d') . "');
        ";
    }

    $result = $conn->query($sql);
    if ($result == TRUE) {
        $_SESSION['color'] = "#ccffd1"; //success   
        $_SESSION['radio_button']  = $operation;
        header('Location: ../add-record.php');
    } else {
        $_SESSION['color'] = "#f98686";  //error
        $_SESSION['radio_button']  = $operation;
        $_SESSION['message'] = "Error:" . $sql . "<br>" . $conn->error;
        header('Location: ../add-record.php');
    }
}

if (isset($_POST['edit'])) {    
    if ($operation == 'Record') {
        $sql = "UPDATE `record` SET `name` = '$name', `description`= '$description', `image_url`= '$image_url', `google_sheet_url`= '$google_sheet_url', `linkedin_url`= '$linkedin_url',`gmail_url`= '$gmail_url', `category_id`= '$category', `date`= '$date' WHERE id = " . $id . ";";        
    }

    if ($operation == 'Category') {
        $sql = "UPDATE `category` SET `name` = '$name', `description` = '$description' WHERE id = " . $id . ";";
    }

    $result = $conn->query($sql);
    if ($result == TRUE) {
        $_SESSION['color'] = "#ccffd1"; //success        
        header('Location: ../add-record.php');
    } else {
        $_SESSION['color'] = "#f98686";  //error
        $_SESSION['message'] = "Error:" . $sql . "<br>" . $conn->error;
        header('Location: add.php');
    }
    // $id = '';
    // die($sql);
}

if (isset($_POST['delete'])) {
    if($operation == 'Category'){        
        // echo "SELECT COUNT(*) AS i FROM `record` r INNER JOIN `category` c  ON r.category_id = c.id WHERE r.id = ". $id;        
        $row = $conn->query("SELECT COUNT(*) AS i FROM `category` c INNER JOIN `record` r  ON c.id = r.category_id WHERE c.id = ". $id)->fetch_assoc();        
        if($row['i'] > 0){
            $_SESSION['color'] = "#f98686";  //error
            $_SESSION['message'] = "You cannot delete this category because there are some records assigned to it. 
            Please remove all records from this category before deleting it.";
            header('Location: ../add-record.php?id='.$id.'.2');
            return; //Stop code execution
        }    
    }

    if($operation == 'Record'){
        $row = $conn->query("SELECT COUNT(*) AS i FROM `consume` WHERE record_id = ".$id)->fetch_assoc();
        if($row['i'] > 0){
            $_SESSION['color'] = "#f98686"; //error
            $_SESSION['message'] = "You cannot delete this record because there are some consume data assigned to it.
            Please remove all consume data from this record before deleting it.";
            header('Location: ../add-record.php?id='.$id.'.1');
            return; //Stop code execution
        }
    }

    $sql = "DELETE FROM `" . $operation . "` WHERE id = " . $id;
    // die($sql);
    $result = $conn->query($sql);
    if ($result == TRUE) {
        $_SESSION['color'] = "#ccffd1"; //success
        header('Location: ../index.php');
    } else {
        $_SESSION['color'] = "#f98686";  //error
        $_SESSION['message'] = "Error:" . $sql . "<br>" . $conn->error;
        header('Location: add.php');
    }
}

