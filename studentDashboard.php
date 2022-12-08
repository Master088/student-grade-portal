<?php
session_start();
include 'mysql_connect.php';

// prevent unauthenticated user and teacher  to access this page
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


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student Dashboard</title>
    <link rel="icon" href ="img/logo.png" class="icon">
</head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/a81368914c.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

<link rel="stylesheet" href="style.css">
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
        height: 100%;
        font-size: 1em;
        overflow-x: hidden;
        overflow-y: visible;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>

<body>

    <nav class="navbar navbar-light bg-dark">
        <a href="index.php" class="navbar-brand text-white">Classroom Management System</a>
        <form action="logout.php" method="POST">
            <button type="submit" name='logout' class="btn btn-danger  "> <i class="bi bi-person-dash-fill"></i> Logout</button>
        </form>
    </nav>

    <div class="">
        <h2 class="text-center mt-5">Student Grade</h2>
        <div class="container-fluid mt-5 px-3 py-3">
            <div class="row">
                <div class="card mb-3 ml-2 border-0 col-md-6">
                    <!-- get student data -->
                    <?php
                    $student_id = $_SESSION['id'];
                    $query =  "SELECT *
                    FROM student 
                    WHERE id = " . $student_id;
                    $res = mysqli_query($conn, $query);
                    $studentDetails = mysqli_fetch_assoc($res);
                    ?>
                    <div class="row no-gutters">
                        <div class="col-md-4 ">
                            <img src="<?php echo $studentDetails['profile']; ?>" class=" img-fluid border">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body ml-lg-5">
                                <h1 class="card-title"><?php echo $studentDetails['fullname']; ?></h1>
                                <p class="card-text">LRN: <?php echo $studentDetails['lrn']; ?></p>
                                <p class="card-text">Guardian Name: <?php echo $studentDetails['guardian_name']; ?></p>
                                <p class="card-text">Gender: <?php echo $studentDetails['gender']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-12 ">
                    <div class="row  d-flex justify-content-end " style="margin-right: -10vw">
                        <div class="card col-md-5  border-0">

                            <div class="d-flex">
                                <div class="form-group  ">
                                    <div class="d-flex">
                                        <h4 class=" mx-2">School Year </h4>
                                    </div>
                                    <div class=" mt-2 ">
                                        <select class=" form-control" onchange="getGradeTable()" name="school_year" id="school_year" required aria-label="Default select example">
                                            <!-- get school year  -->
                                            <?php

                                            $sql = "SELECT DISTINCT class.school_year  FROM class_member
                                            INNER JOIN student ON class_member.student_id=student.id 
                                            INNER JOIN class ON class_member.class_id=class.class_id 
                                            WHERE student_id=" . $_SESSION['id'];

                                            $res = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($res) > 0) {
                                                while ($row = mysqli_fetch_assoc($res)) {  ?>

                                                    <option value="<?php echo $row['school_year']; ?>"><?php echo $row['school_year']; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card col-md-5 border-0 noPrint mt-5">
                            <div class="form-group noPrint">
                                <!-- print the page. no print class exclude this button in print  -->
                                <button class="btn btn-danger  " onclick="window.print();"><i class="bi bi-file-earmark-arrow-down-fill"></i> Download</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" id="table">
        <div class="card mb-5">
            <div id="grade_table" class="text-dark mx-2"></div>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            getGradeTable()
        });
        // get all student grade for active school year function
        function getGradeTable() {
            // get current school year 
            let school_year = $("#school_year").val()

            // send ajax request to get_student_grade.php with school year
            $.ajax({
                url: "get_student_grade.php",
                method: "GET",
                data: {
                    school_year
                },
                success: function(data) {
                    //convert the response to json
                    data = $.parseJSON(data);
                    if (data.status == "success") {
                        // append the response to div with oid of grade_table
                        $("#grade_table").html(data.html);
                    }
                },
            });
        }
    </script>


</body>

</html>