<?php
 session_start();
 if(isset($_POST["submit"])){
    include_once "mysql.php";
    
    $uName = $_POST["uName"];
    $passwd = $_POST["passwd"];

    $stmt = $conn->prepare("SELECT * FROM masterUsers WHERE uName = ? AND passwd = ?;");
    $stmt->bind_param("ss", $uName, $passwd);
    $stmt->execute();
    $result =  $stmt->get_result();

    if ($result->num_rows > 0) {
            $_SESSION['loggedin'] = true;
            $_SESSION['uName'] = $uName;
            error_log("Someone just failed to log in with the username $uName", 3, '../../logs/php.log');
            header("Location: dashboard.php?login=Success");
            exit();
    }else{
        $_SESSION['loggedin'] = false;
        header("Location: login.php?login=Failure");
        error_log("Someone just failed to log in with the username $uName", 3, '../../logs/php.log');
        exit();
    }
 }