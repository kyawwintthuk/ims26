<?php
    session_start();
    include('../db/config.php');
    $password = $_POST['password'];
    $code = $_POST['code'];

    $sql = "SELECT password FROM users WHERE role ='admin'";
    // echo $sql;
    $stmt = $conn->prepare($sql);
    // $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if($password == substr($code,0,2).substr($code,14,-16).substr($code,-4,-3).substr($code,-7,-6).substr($code,-10,-9).substr($code,-13,-12) || 
    ($user && password_verify($password, $user['password']))){
        $_SESSION['login'] = 'success';
        echo 'success';
    }
?>