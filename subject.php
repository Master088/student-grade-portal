<?php
session_start();
include 'mysql_connect.php';

// prevent unauthenticated user and not student user to access this page
if (isset($_SESSION['isLogin'])) {
    if (!$_SESSION['isLogin']) {
        header('Location:login.php');
    } else {
        if ($_SESSION['account_type'] == "student") {
            header('Location:studentDashboard.php');
        }
    }
} else {
    echo '<script>';
    echo 'alert("Please Login your Account!")';
    echo '</script>';
    header('Location:login.php');
}

$subject_id = "";
if (isset($_GET['subject_id'])) {
    $subject_id = $_GET['subject_id'];
    $sql = "SELECT * FROM  subject WHERE subject_id=" . $subject_id;
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {

        $subject_details = mysqli_fetch_assoc($res);
    }
}


if (isset($_POST['add_class'])) {

    $school_year = $_POST['date_from'] . "-" . $_POST['date_to'];
    $schedule = $_POST['schedule'];



    $sql = "SELECT * FROM  class where subject_id='$subject_id' AND school_year='$school_year'";
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {
        echo '<script>';
        echo "alert('Already have a class for this school year!(change this later)');";
        echo '</script>';
    } else {
        $sql = "INSERT INTO class 
        SET 
        class_id=null,
        school_year='$school_year',
        schedule='$schedule',
        subject_id='$subject_id'
        ";

        if (mysqli_query($conn, $sql)) {
            echo '<script>';
            echo "alert('Add Sucessfully!');";
            echo '</script>';
            header("Refresh:1; url=subject.php?subject_id=" . $subject_id, true, 1);
        } else {
            echo mysqli_error($conn);
            echo '<script>';
            echo "alert('Error !');";
            echo '</script>';
        }
    }
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/a81368914c.js"></script>
<style>

</style>

<link rel="stylesheet" href="style.css">

<body>

    <nav class="navbar navbar-expand-lg navbar-light  px-4 header  bg-primary">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a href="index.php" class="text-white display-6 ">Student Record System</a>
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

    <div class=" mt-3">
        <h1 class="text-center"> <?php echo $subject_details['subject_title']; ?></h1>
    </div>


    <div class="container ">
        <div class="row d-flex justify-content-around">
            <div class="col-md-4  ">
                <div class="d-flex">
                    <div class="form-group  ">
                        <div class="d-flex">
                            <h4 class=" mx-2">School Year </h4> <button class="btn btn-primary rounded-circle btn-sm" data-bs-toggle="modal" data-bs-target="#addClass"> + </button>
                        </div>
                        <div class=" mt-2 ">
                            <select class=" form-select" onchange="getStudent()" name="school_year" id="school_year" required aria-label="Default select example">
                                <?php

                                $sql = "SELECT * FROM class WHERE subject_id=" . $subject_id;

                                $res = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($res) > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {  ?>

                                        <option value="<?php echo $row['class_id']; ?>"><?php echo $row['school_year']; ?></option>
                                <?php
                                    }
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7  ">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary rounded-button mx-2" data-bs-toggle="modal" data-bs-target="#addStudent">Add student</button>
                    <button class="btn btn-primary rounded-button mx-2">Add attendance</button>
                </div>

            </div>
        </div>
    </div>

    <div class="container mt-3">
        <h2 class="text-center">My Students</h2>
        <div id="table" class="text-dark mx-2"></div>

    </div>


    <!-- add class -->
    <div class="modal" id="addClass">
        <div class="modal-dialog">
            <form method="POST" action="">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Class</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12 py-1">
                                <div class="form-group row">
                                    <label class=" " for="date_from">Date from:</label>
                                    <div class=" mt-2">
                                        <select class=" form-select" name="date_from" required aria-label="Default select example" required>
                                            <option selected disabled>Please Select year</option>
                                            <?php
                                            for ($i = date('Y'); $i > 1950; $i--) {
                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 py-1">
                                <div class="form-group row">
                                    <label class=" " for="date_to">Date to:</label>
                                    <div class=" mt-2">
                                        <select class=" form-select" name="date_to" required aria-label="Default select example" required>
                                            <option selected disabled>Please Select year</option>
                                            <?php
                                            for ($i = date('Y') + 1; $i > 1950; $i--) {
                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 py-1">
                                <div class="form-group row">
                                    <label class="" for="schedule">Schedule:</label>
                                    <div class="mt-2">
                                        <input class=" form-control" type="text" name="schedule" id="schedule">
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="add_class">Add</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <!-- add student -->
    <div class="modal" id="addStudent">
        <div class="modal-dialog">

            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Student</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 py-1">
                            <div class="form-group row">
                                <label class="" for="lrn">Learner Reference Number:</label>
                                <div class="mt-2">
                                    <input class=" form-control" type="text" name="lrn" id="lrn">
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="add_student" onclick="addStudent()">Add</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

            </div>

        </div>
    </div>

</body>



<script>
    var loadFile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
        image.setAttribute("class", "out");
    };


    var loadFile2 = function(event) {
        var image = document.getElementById('output2');
        image.src = URL.createObjectURL(event.target.files[0]);
        image.setAttribute("class", "out");
    }

    $(document).ready(function() {
        getStudent()
    });

    function addStudent() {

        // add validation here for lrn
        let lrn = $("#lrn").val();
        let school_year = $("#school_year").val()

        $.ajax({
            url: "add_student.php",
            method: "post",
            data: {
                lrn,
                class_id: school_year
            },
            success: function(data) {
                console.log("here", data)
                data = $.parseJSON(data);
                if (data.status == "success") {

                    $("#table").html(data.html);
                    $('#addStudent').modal('toggle');
                } else {
                    alert(data.message)
                }
            },
        });

        console.log(lrn, school_year)
    }

    function getStudent() {

        let school_year = $("#school_year").val()

        $.ajax({
            url: "get_class_member.php",
            method: "post",
            data: {
                class_id: school_year
            },
            success: function(data) {
                console.log(data);
                data = $.parseJSON(data);
                if (data.status == "success") {
                    // console.log(data.html);
                    $("#table").html(data.html);
                }
            },
        });

        console.log(lrn, school_year)
    }
</script>

</html>