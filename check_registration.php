<?php

$page_title = "Check registration";

include 'mysqli_connect.php';

include 'includes/header.php';

include 'includes/navbar.php';

if (isset ($_SESSION['username'])){
	header('location: index.php');
}
else{
	
    $username = $_POST['username'];
    $password = $_POST['pass'];

    $sql1 = mysqli_prepare($connection, "SELECT users_username, users_password FROM users WHERE users_username = ? AND users_password = ?");
    mysqli_stmt_bind_param($sql1, "ss", $username, $password);
    mysqli_stmt_execute($sql1);
    mysqli_stmt_close($sql1);

    $stmt = mysqli_prepare($connection, "INSERT INTO users (users_username, users_password) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $result1 = mysqli_query ($connection, $sql1) or die (mysqli_error ($connection));

    if (mysqli_num_rows ($result1) == 0){
        if ($stmt){
            include 'includes/new_registration.php';
        }
        else{
            include 'includes/error.php';
            
        }

    }
    else{
        include 'includes/notregistered.php';
    }
}

mysqli_close ($connection);

include 'includes/footer.html';

?>