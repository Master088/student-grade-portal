<?php
session_start();
include 'mysql_connect.php';

// prevent unauthenticated user and not student user to access this page
if (isset($_SESSION['isLogin'])) {
    if (!$_SESSION['isLogin']) {
        header('Location:login.php');
    } else {
        if ($_SESSION['account_type'] == "teacher") {
            header('Location:studentDashboard.php');
        }
    }
} else {
    echo '<script>';
    echo 'alert("Please Login your Account!")';
    echo '</script>';
    header('Location:login.php');
}

// $subject_id = "";
// if (isset($_GET['subject_id'])) {
//     $subject_id = $_GET['subject_id'];
//     $sql = "SELECT * FROM  subject WHERE subject_id=" . $subject_id;
//     $res = mysqli_query($conn, $sql);
//     if (mysqli_num_rows($res) > 0) {

//         $subject_details = mysqli_fetch_assoc($res);
//     }
// }



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

<!-- <link rel="stylesheet" href="style.css"> -->
<style>
    * {
        box-sizing: border-box;
    }

    html,
    body {
        padding: 0;
        margin: 0;
        font-family: Poppins;
        font-weight: 300;
        /* background-image: url("img/background.png"); */
        height: 100%;
        font-size: 1em;
        overflow-x: hidden;
        overflow-y: visible;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        /* background-color: #F8FAFB; */
    }
</style>

<body>

    <nav class="navbar navbar-light bg-dark">
        <a href="index.php" class="navbar-brand text-white">Student Record System</a>
        <form action="logout.php" method="POST">
            <button type="submit" name='logout' class="btn btn-danger  "> <i class="bi bi-person-dash-fill"></i> Logout</button>
        </form>
    </nav>

    <div class="">
        <h2 class="text-center">Student</h2>
        <div class="container-fluid mt-5 px-3 py-3">
            <div class="row">
                <div class="card mb-3 border-0 ml-2  col-md-6">
                    
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="img/2.png" class="card-img border" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body ml-lg-5">
                                <h1 class="card-title">Name</h1>
                                <p class="card-text">LRN: </p>
                                <p class="card-text">Guardian Name: </p>
                                <p class="card-text">Gender: </p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-12 ">
                    <div class="row  d-flex justify-content-around" style="margin-right: -10vw">
                        <div class="card col-md-5  ">
                            
                            <div class="card-body">
                                <h3>Present <span class="text-success"><i class="bi bi-check-circle-fill"></i></span></h3>
                                <p># </p>
                            </div>
                        </div>
                        <div class="card col-md-5  ">
                            
                            <div class="card-body">
                                <h3>Absent <span class="text-danger"><i class="bi bi-x-circle-fill"></i></span></h3>
                                <p># </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        
        <div class="container-fluid">
            
            <table class="table table-bordered">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                </tr>
                <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
                </tr>
                <tr>
                <th scope="row">3</th>
                <td>Larry</td>
                <td>Bird</td>
                <td>@twitter</td>
                </tr>
            </tbody>
            </table>
        </div>
    </div>
    <!-- <div class="container-fluid mt-5 px-3 py-3">
        <div class="row">
            <div class="card mb-3 border-0 ml-2  col-md-6">
                <?php
                $class_member_id = $_GET["class_member_id"];
                $query =  "SELECT *
                    FROM class_member
                    INNER JOIN student ON class_member.student_id=student.id 
                    INNER JOIN class ON class_member.class_id=class.class_id 
                    WHERE class_member.class_member_id = " . $class_member_id;
                $res = mysqli_query($conn, $query);
                $classMemberDetails = mysqli_fetch_assoc($res);
                ?>
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="<?php echo $classMemberDetails['profile']; ?>" class="card-img border" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body ml-lg-5">
                            <h1 class="card-title"><?php echo $classMemberDetails['fullname']; ?></h1>
                            <p class="card-text">LRN: <?php echo $classMemberDetails['lrn']; ?></p>
                            <p class="card-text">Guardian Name: <?php echo $classMemberDetails['guardian_name']; ?></p>
                            <p class="card-text">Gender: <?php echo $classMemberDetails['gender']; ?></p>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-12 ">
                <div class="row  d-flex justify-content-around" style="margin-right: -10vw">
                    <div class="card col-md-5  ">
                        <?php

                        $query =  "SELECT COUNT(1)
                        FROM class_attendance 
                         WHERE student_id =" . $classMemberDetails['id'] . " AND class_id=" . $classMemberDetails['class_id'] . " AND status ='present'";
                        $res = mysqli_query($conn, $query);
                        $row = mysqli_fetch_array($res);

                        $presentCount = $row[0];

                        ?>
                        <div class="card-body">
                            <h3>Present <span class="text-success"><i class="bi bi-check-circle-fill"></i></span></h3>
                            <p># <?php echo $presentCount ?></p>
                        </div>
                    </div>
                    <div class="card col-md-5  ">
                        <?php

                        $query =  "SELECT COUNT(1)
                        FROM class_attendance 
                        WHERE student_id =" . $classMemberDetails['id'] . " AND class_id=" . $classMemberDetails['class_id'] . " AND status ='absent'";
                        $res = mysqli_query($conn, $query);
                        $row = mysqli_fetch_array($res);

                        $absentCount = $row[0];

                        ?>
                        <div class="card-body">
                            <h3>Absent <span class="text-danger"><i class="bi bi-x-circle-fill"></i></span></h3>
                            <p># <?php echo $absentCount ?></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> -->
    <!-- <div class="container-fluid mt-5 px-3 py-3">
        <div class="row">
            <div class="card mb-3 border-0 ml-2  col-md-6">
                
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="img/2.png" class="card-img border" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body ml-lg-5">
                            <h1 class="card-title"></h1>
                            <p class="card-text">LRN: </p>
                            <p class="card-text">Guardian Name: </p>
                            <p class="card-text">Gender: </p>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-12 ">
                <div class="row  d-flex justify-content-around" style="margin-right: -10vw">
                    <div class="card col-md-5  ">
                        
                        <div class="card-body">
                            <h3>Present <span class="text-success"><i class="bi bi-check-circle-fill"></i></span></h3>
                            <p># </p>
                        </div>
                    </div>
                    <div class="card col-md-5  ">
                        
                        <div class="card-body">
                            <h3>Absent <span class="text-danger"><i class="bi bi-x-circle-fill"></i></span></h3>
                            <p># </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> -->
    




</body>
</html>