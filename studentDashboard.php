<?php
session_start();

include 'mysql_connect.php';
 // prevent unauthenticated user and not student user to access this page
if (isset($_SESSION['isLogin'])) {
    if (!$_SESSION['isLogin']) {
        header('Location:login.php');
    } else {
        if ($_SESSION['account_type'] == "teacher") {
            header('Location:index.php');
        }
    }
} else {
    echo '<script>';
    echo 'alert("Please Login your Account!")';
    echo '</script>';
    header('Location:login.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/a81368914c.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
 
</style>
<link rel="stylesheet" href="style.css">

<body  >
<nav class="navbar navbar-expand-lg navbar-light  px-4 header  bg-primary">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <h3 class="text-white">Student Record System</h3>
        <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarSupportedContent ">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0  ">
                <li>

                    <a class=" text-white ">

                        <form action="logout.php" method="POST">
                            <button type="submit" name='logout' class="btn btn-danger  ">Logout</button>

                        </form>
                    </a>
                </li>
            </ul>
            </li>
            </ul>
        </div>
    </nav>

    



    
</body>

<script>
   
</script>

</html>