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
    @media print {
        body *{
            display: none;
        }
        #table, #table * {
            display: block;
            /* height: 100vh; */
        }
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
        <h2 class="text-center mt-5">Student</h2>
        <div class="container-fluid mt-5 px-3 py-3">
            <div class="row">
                <div class="card mb-3 ml-2 border-0 col-md-6">
                    <?php
                    $student_id = $_SESSION['id'];
                    $query =  "SELECT *
                    FROM student 
                    WHERE id = " . $student_id;
                    $res = mysqli_query($conn, $query);
                    $studentDetails = mysqli_fetch_assoc($res);
                    ?>
                    <div class="row no-gutters">
                        <div class="col-md-4" >
                            <img src="<?php echo $studentDetails['profile']; ?>" class="card-img border" alt="..." style="min-height: 30vh; min-width: 19vw;">
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
                <div class="col-md-5 col-sm-12 " style="margin-left: 5vw">
                    <div class="row  d-flex justify-content-end " style="margin-right: -10vw">
                        <div class="card col-md-5  border-0" >

                            <div class="d-flex">
                                <div class="form-group  ">
                                    <div class="d-flex">
                                        <!-- <h4 class=" mx-2">School Year </h4> <button class="btn btn-primary rounded-circle btn-sm" data-bs-toggle="modal" data-bs-target="#addClass"><i class="bi bi-plus-circle-fill"></i></button> -->
                                        <h4 class=" mx-2">School Year </h4>
                                    </div>
                                    <div class=" mt-2 ">
                                        <select class=" form-control" onchange="getGradeTable()" name="school_year" id="school_year" required aria-label="Default select example">
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
                        <div class="card col-md-5 border-0 ">
                            <div class="form-group">
                                <button class="btn btn-danger"  id="print"><i class="bi bi-file-earmark-arrow-down-fill"></i> Download</button>
                            
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" id="table">
        <div id="grade_table" class="text-dark mx-2"></div>
    </div>



    <script>
        $(document).ready(function() {
            getGradeTable()
        });

        function getGradeTable() {
            let school_year = $("#school_year").val()
            console.log("here", school_year)
            $.ajax({
                url: "get_student_grade.php",
                method: "GET",
                data: {
                    school_year
                },
                success: function(data) {
                    console.log(data);
                    data = $.parseJSON(data);
                    if (data.status == "success") {
                        $("#grade_table").html(data.html);
                    }
                },
            });


        }
    </script>

    <script>
        const printBtn = document.getElementById('print');

        printBtn.addEventListener('click', function(){
            var printdata = document.getElementById("table");
            newwin = window.open("");
            newwin.document.write(printdata.outerHTML);
            newwin.print();
            newwin.close();
        })
    </script>

</body>

</html>