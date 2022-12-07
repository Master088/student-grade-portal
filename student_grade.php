<?php
session_start();
include 'mysql_connect.php';

// prevent unauthenticated user and   student user to access this page
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

// fires when the add for the 1st quarter is click
if (isset($_POST['submit1'])) {
    //get all data from the 1st quarter form
    $prerogative = $_POST['prerogative1'];
    $summative = $_POST['summative1'];
    $exam = $_POST['exam1'];
    $bonus = $_POST['bonus1'];
    $total = $_POST['total1'];

    // get class member details
    $class_member_id = $_GET["class_member_id"];
    $query =  "SELECT *
        FROM class_member
        INNER JOIN student ON class_member.student_id=student.id 
        INNER JOIN class ON class_member.class_id=class.class_id 
        WHERE class_member.class_member_id = " . $class_member_id;
    $res = mysqli_query($conn, $query);
    $classMemberDetails = mysqli_fetch_assoc($res);

    // check if there a existing record for this subject and student
    $sql = "SELECT *
    FROM class_grade 
    WHERE student_id =" . $classMemberDetails['id'] . " AND class_id=" . $classMemberDetails['class_id'] . " AND quarter ='1st Quarter'";

    $res = mysqli_query($conn, $sql);
    $data =  mysqli_fetch_assoc($res);
    $sql = "";
    // if yes; the query will be update. if no insert
    if (mysqli_num_rows($res) > 0) {
        // update
        $sql = "UPDATE class_grade 
        SET 
        prerogative='$prerogative',
        summative='$summative',
        exam='$exam',
        bonus='$bonus',
        total='$total'
        WHERE grade_id=
    " . $data['grade_id'];
    } else {
        // insert
        $class_id = $classMemberDetails['class_id'];
        $student_id = $classMemberDetails['student_id'];
        $sql = "INSERT INTO class_grade
        SET 
        grade_id=null,
        class_id='$class_id',
        student_id='$student_id',
        prerogative='$prerogative',
        summative='$summative',
        exam='$exam',
        bonus='$bonus',
        quarter='1st Quarter',
        total='$total'
        ";
    }
    if (mysqli_query($conn, $sql)) {

        header("Refresh:1; url=student_grade.php?class_member_id=" . $_GET["class_member_id"], true, 5);
    } else {
        echo mysqli_error($conn);
    }
}
// fires when the add for the 2nd quarter is click
if (isset($_POST['submit2'])) {
    //get all data from the 2nd quarter form
    $prerogative = $_POST['prerogative2'];
    $summative = $_POST['summative2'];
    $exam = $_POST['exam2'];
    $bonus = $_POST['bonus2'];
    $total = $_POST['total2'];

    // get class member details
    $class_member_id = $_GET["class_member_id"];
    $query =  "SELECT *
        FROM class_member
        INNER JOIN student ON class_member.student_id=student.id 
        INNER JOIN class ON class_member.class_id=class.class_id 
        WHERE class_member.class_member_id = " . $class_member_id;
    $res = mysqli_query($conn, $query);
    $classMemberDetails = mysqli_fetch_assoc($res);
    // check if there a existing record for this subject and student
    $sql = "SELECT *
    FROM class_grade 
    WHERE student_id =" . $classMemberDetails['id'] . " AND class_id=" . $classMemberDetails['class_id'] . " AND quarter ='2nd Quarter'";

    $res = mysqli_query($conn, $sql);
    $data =  mysqli_fetch_assoc($res);
    $sql = "";
    // if yes; the query will be update. if no insert
    if (mysqli_num_rows($res) > 0) {
        // update
        $sql = "UPDATE class_grade 
        SET 
        prerogative='$prerogative',
        summative='$summative',
        exam='$exam',
        bonus='$bonus',
        total='$total'
        WHERE grade_id=
    " . $data['grade_id'];
    } else {
        // insert
        $class_id = $classMemberDetails['class_id'];
        $student_id = $classMemberDetails['student_id'];
        $sql = "INSERT INTO class_grade
        SET 
        grade_id=null,
        class_id='$class_id',
        student_id='$student_id',
        prerogative='$prerogative',
        summative='$summative',
        exam='$exam',
        bonus='$bonus',
        quarter='2nd Quarter',
        total='$total'
        ";
    }
    if (mysqli_query($conn, $sql)) {
        header("Refresh:1; url=student_grade.php?class_member_id=" . $_GET["class_member_id"], true, 5);
    } else {
        echo mysqli_error($conn);
    }
}
// fires when the add for the 3rd quarter is click
if (isset($_POST['submit3'])) {
    //get all data from the 3rd quarter form
    $prerogative = $_POST['prerogative3'];
    $summative = $_POST['summative3'];
    $exam = $_POST['exam3'];
    $bonus = $_POST['bonus3'];
    $total = $_POST['total3'];
    // get class member details
    $class_member_id = $_GET["class_member_id"];
    $query =  "SELECT *
        FROM class_member
        INNER JOIN student ON class_member.student_id=student.id 
        INNER JOIN class ON class_member.class_id=class.class_id 
        WHERE class_member.class_member_id = " . $class_member_id;
    $res = mysqli_query($conn, $query);
    $classMemberDetails = mysqli_fetch_assoc($res);

    // check if there a existing record for this subject and student
    $sql = "SELECT *
    FROM class_grade 
    WHERE student_id =" . $classMemberDetails['id'] . " AND class_id=" . $classMemberDetails['class_id'] . " AND quarter ='3rd Quarter'";

    $res = mysqli_query($conn, $sql);
    $data =  mysqli_fetch_assoc($res);
    $sql = "";
    // if yes; the query will be update. if no insert
    if (mysqli_num_rows($res) > 0) {
        // update
        $sql = "UPDATE class_grade 
        SET 
        prerogative='$prerogative',
        summative='$summative',
        exam='$exam',
        bonus='$bonus',
        total='$total'
        WHERE grade_id=
    " . $data['grade_id'];
    } else {
        // insert
        $class_id = $classMemberDetails['class_id'];
        $student_id = $classMemberDetails['student_id'];
        $sql = "INSERT INTO class_grade
        SET 
        grade_id=null,
        class_id='$class_id',
        student_id='$student_id',
        prerogative='$prerogative',
        summative='$summative',
        exam='$exam',
        bonus='$bonus',
        quarter='3rd Quarter',
        total='$total'
        ";
    }
    if (mysqli_query($conn, $sql)) {
        header("Refresh:1; url=student_grade.php?class_member_id=" . $_GET["class_member_id"], true, 5);
    } else {
        echo mysqli_error($conn);
    }
}
// fires when the add for the 4th quarter is click
if (isset($_POST['submit4'])) {
    //get all data from the 4th quarter form
    $prerogative = $_POST['prerogative4'];
    $summative = $_POST['summative4'];
    $exam = $_POST['exam4'];
    $bonus = $_POST['bonus4'];
    $total = $_POST['total4'];
    // get class member details
    $class_member_id = $_GET["class_member_id"];
    $query =  "SELECT *
        FROM class_member
        INNER JOIN student ON class_member.student_id=student.id 
        INNER JOIN class ON class_member.class_id=class.class_id 
        WHERE class_member.class_member_id = " . $class_member_id;
    $res = mysqli_query($conn, $query);
    $classMemberDetails = mysqli_fetch_assoc($res);
    // check if there a existing record for this subject and student
    $sql = "SELECT *
    FROM class_grade 
    WHERE student_id =" . $classMemberDetails['id'] . " AND class_id=" . $classMemberDetails['class_id'] . " AND quarter ='4th Quarter'";

    $res = mysqli_query($conn, $sql);
    $data =  mysqli_fetch_assoc($res);
    $sql = "";
    // if yes; the query will be update. if no insert
    if (mysqli_num_rows($res) > 0) {
        // update
        $sql = "UPDATE class_grade 
        SET 
        prerogative='$prerogative',
        summative='$summative',
        exam='$exam',
        bonus='$bonus',
        total='$total'
        WHERE grade_id=
    " . $data['grade_id'];
    } else {
        // insert
        $class_id = $classMemberDetails['class_id'];
        $student_id = $classMemberDetails['student_id'];
        $sql = "INSERT INTO class_grade
        SET 
        grade_id=null,
        class_id='$class_id',
        student_id='$student_id',
        prerogative='$prerogative',
        summative='$summative',
        exam='$exam',
        bonus='$bonus',
        quarter='4th Quarter',
        total='$total'
        ";
    }
    if (mysqli_query($conn, $sql)) {
        header("Refresh:1; url=student_grade.php?class_member_id=" . $_GET["class_member_id"], true, 5);
    } else {
        echo mysqli_error($conn);
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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/a81368914c.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
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
        <a href="index.php" class="navbar-brand text-white">Classroom Management System</a>
        <form action="logout.php" method="POST">
            <button type="submit" name='logout' class="btn btn-danger  "> <i class="bi bi-person-dash-fill"></i> Logout</button>
        </form>
    </nav>

    <div class="container mt-3">
        <h2 class="text-center">Student</h2>
        <div id="table" class="text-dark mx-2"></div>
    </div>
    <div class="container-fluid mt-5 px-3 py-3">
        <div class="row">
            <div class="card mb-3 border-0 ml-2  col-md-6">
                <!-- display student information -->
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
                        <img src="<?php echo $classMemberDetails['profile']; ?>" class="card-img border" alt="..." style="min-height: 30vh; min-width: 19vw; border-radius: 20px;">
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
                        <!-- count the number of present -->
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
                        <!-- count the number of absent -->
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
    </div>

    <div class="container-fluid text-center mt-5">
        <div class="row row-cols-1 row-cols-md-2">

            <div class="col mb-4">
                <div class="card" style="background-color: #F8FAFB;">
                    <div class="card-body">
                        <!-- 1st Quarter form -->
                        <h2 class="card-title">1st Quarter</h2>
                        <?php

                        $query =  "SELECT *
                        FROM class_grade 
                        WHERE student_id =" . $classMemberDetails['id'] . " AND class_id=" . $classMemberDetails['class_id'] . " AND quarter ='1st Quarter'";
                        $res = mysqli_query($conn, $query);

                        $firstQuarter =  mysqli_fetch_assoc($res);

                        ?>
                        <form method="POST">
                            <div class="form-group">
                                <label for="prerogative1">Prerogative(25%)</label>
                                <input type="number" class="form-control text-center" oninput="onChange1()" value="<?php echo $firstQuarter['prerogative'] ?>" id="prerogative1" name="prerogative1">

                            </div>
                            <div class="form-group">
                                <label for="summative1">Summative(25%)</label>
                                <input type="number" class="form-control text-center" oninput="onChange1()" value="<?php echo $firstQuarter['summative'] ?>" id="summative1" name="summative1">
                            </div>
                            <div class="form-group">
                                <label for="exam1">Exam(50%)</label>
                                <input type="number" class="form-control text-center" oninput="onChange1()" id="exam1" name="exam1" value="<?php echo $firstQuarter['exam'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="bonus1">Bonus</label>
                                <input type="number" class="form-control text-center" oninput="onChange1()" id="bonus1" name="bonus1" value="<?php echo $firstQuarter['bonus'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="total1">Total</label>
                                <input type="text" class="form-control text-center" value="<?php
                                                                                            // if total is empty display the exam+summative +prerogative
                                                                                            if (mysqli_num_rows($res) > 0) {
                                                                                                if ($firstQuarter['total'] >= 0) {
                                                                                                    echo $firstQuarter['total'];
                                                                                                } else {
                                                                                                    $total = $firstQuarter['summative'] + $firstQuarter['prerogative'] + $firstQuarter['exam'] + $firstQuarter['bonus'];

                                                                                                    if ($total > 100) {
                                                                                                        echo 100;
                                                                                                    } else {
                                                                                                        echo $total;
                                                                                                    }
                                                                                                }
                                                                                            } else {
                                                                                                echo 0;
                                                                                            }
                                                                                            ?>" id="total1" name="total1">
                            </div>

                            <button type="submit" id="submit1" name="submit1" class="btn btn-warning text-white"><span><i class="bi bi-plus-circle-fill"></i></span> Add</button>

                        </form>
                    </div>
                </div>
            </div>

            <div class="col mb-4">
                <div class="card" style="background-color: #F8FAFB;">
                    <div class="card-body">
                        <!-- 2nd Quarter form -->
                        <h2 class="card-title">2nd Quarter</h2>
                        <!-- get 2nd Quarter data -->
                        <?php

                        $query =  "SELECT *
                        FROM class_grade 
                        WHERE student_id =" . $classMemberDetails['id'] . " AND class_id=" . $classMemberDetails['class_id'] . " AND quarter ='2nd Quarter'";
                        $res = mysqli_query($conn, $query);

                        $secondQuarter =  mysqli_fetch_assoc($res);

                        ?>
                        <form method="POST">
                            <div class="form-group">
                                <label for="prerogative1">Prerogative(25%)</label>
                                <input type="number" class="form-control text-center" oninput="onChange2()" value="<?php echo $secondQuarter['prerogative'] ?>" id="prerogative2" name="prerogative2">

                            </div>
                            <div class="form-group">
                                <label for="summative1">Summative(25%)</label>
                                <input type="number" class="form-control text-center" oninput="onChange2()" value="<?php echo $secondQuarter['summative'] ?>" id="summative2" name="summative2">
                            </div>
                            <div class="form-group">
                                <label for="exam1">Exam(50%)</label>
                                <input type="number" class="form-control text-center" oninput="onChange2()" id="exam2" name="exam2" value="<?php echo $secondQuarter['exam'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="bonus1">Bonus</label>
                                <input type="number" class="form-control text-center" oninput="onChange2()" id="bonus2" name="bonus2" value="<?php echo $secondQuarter['bonus'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="total1">Total</label>
                                <input type="text" class="form-control text-center" value="<?php
                                                                                            // if total is empty display the exam+summative +prerogative
                                                                                            if (mysqli_num_rows($res) > 0) {
                                                                                                if ($secondQuarter['total'] >= 0) {
                                                                                                    echo $secondQuarter['total'];
                                                                                                } else {
                                                                                                    $total = $secondQuarter['summative'] + $secondQuarter['prerogative'] + $secondQuarter['exam'] + $secondQuarter['bonus'];

                                                                                                    if ($total > 100) {
                                                                                                        echo 100;
                                                                                                    } else {
                                                                                                        echo $total;
                                                                                                    }
                                                                                                }
                                                                                            } else {
                                                                                                echo 0;
                                                                                            }
                                                                                            ?>" id="total2" name="total2">
                            </div>
                            <button type="submit" id="submit2" name="submit2" class="btn btn-warning text-white"><span><i class="bi bi-plus-circle-fill"></i></span> Add</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col mb-4">
                <div class="card" style="background-color: #F8FAFB;">
                    <div class="card-body">
                        <!-- 3rd Quarter form -->
                        <h2 class="card-title">3rd Quarter</h2>
                        <!-- get 3rd quarter data -->
                        <?php
                        $query =  "SELECT *
                        FROM class_grade 
                        WHERE student_id =" . $classMemberDetails['id'] . " AND class_id=" . $classMemberDetails['class_id'] . " AND quarter ='3rd Quarter'";
                        $res = mysqli_query($conn, $query);
                        $thirdQuarter =  mysqli_fetch_assoc($res);
                        ?>
                        <form method="POST">
                            <div class="form-group">
                                <label for="prerogative1">Prerogative(25%)</label>
                                <input type="number" class="form-control text-center" oninput="onChange3()" value="<?php echo $thirdQuarter['prerogative'] ?>" id="prerogative3" name="prerogative3">

                            </div>
                            <div class="form-group">
                                <label for="summative1">Summative(25%)</label>
                                <input type="number" class="form-control text-center" oninput="onChange3()" value="<?php echo $thirdQuarter['summative'] ?>" id="summative3" name="summative3">
                            </div>
                            <div class="form-group">
                                <label for="exam1">Exam(50%)</label>
                                <input type="number" class="form-control text-center" oninput="onChange3()" id="exam3" name="exam3" value="<?php echo $thirdQuarter['exam'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="bonus1">Bonus</label>
                                <input type="number" class="form-control text-center" oninput="onChange3()" id="bonus3" name="bonus3" value="<?php echo $thirdQuarter['bonus'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="total3">Total</label>
                                <input type="text" class="form-control text-center" value="<?php
                                                                                            // if total is empty display the exam+summative +prerogative
                                                                                            if (mysqli_num_rows($res) > 0) {
                                                                                                if ($thirdQuarter['total'] >= 0) {
                                                                                                    echo $thirdQuarter['total'];
                                                                                                } else {
                                                                                                    $total = $thirdQuarter['summative'] + $thirdQuarter['prerogative'] + $thirdQuarter['exam'] + $thirdQuarter['bonus'];

                                                                                                    if ($total > 100) {
                                                                                                        echo 100;
                                                                                                    } else {
                                                                                                        echo $total;
                                                                                                    }
                                                                                                }
                                                                                            } else {
                                                                                                echo 0;
                                                                                            }

                                                                                            ?>" id="total3" name="total3">
                            </div>
                            <button type="submit" id="submit3" name="submit3" class="btn btn-warning text-white"><span><i class="bi bi-plus-circle-fill"></i></span> Add</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col mb-4">
                <div class="card" style="background-color: #F8FAFB;">
                    <div class="card-body">
                        <!-- 4th quarter form -->
                        <h2 class="card-title">4th Quarter</h2>
                        <!-- get 4th quarter data -->
                        <?php
                        $query =  "SELECT *
                        FROM class_grade 
                        WHERE student_id =" . $classMemberDetails['id'] . " AND class_id=" . $classMemberDetails['class_id'] . " AND quarter ='4th Quarter'";
                        $res = mysqli_query($conn, $query);
                        $fourthQuarter =  mysqli_fetch_assoc($res);
                        ?>
                        <form method="POST">
                            <div class="form-group">
                                <label for="prerogative1">Prerogative(25%)</label>
                                <input type="number" class="form-control text-center" oninput="onChange4()" value="<?php echo $fourthQuarter['prerogative'] ?>" id="prerogative4" name="prerogative4">

                            </div>
                            <div class="form-group">
                                <label for="summative1">Summative(25%)</label>
                                <input type="number" class="form-control text-center" oninput="onChange4()" value="<?php echo $fourthQuarter['summative'] ?>" id="summative4" name="summative4">
                            </div>
                            <div class="form-group">
                                <label for="exam1">Exam(50%)</label>
                                <input type="number" class="form-control text-center" oninput="onChange4()" value="<?php echo $fourthQuarter['exam'] ?>" id="exam4" name="exam4">
                            </div>
                            <div class="form-group">
                                <label for="bonus1">Bonus</label>
                                <input type="number" class="form-control text-center" oninput="onChange4()" id="bonus4" name="bonus4" value="<?php echo $fourthQuarter['bonus'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="total3">Total</label>
                                <input type="text" class="form-control text-center" value="<?php
                                                                                            // if total is empty display the exam+summative +prerogative
                                                                                            if (mysqli_num_rows($res) > 0) {
                                                                                                if ($fourthQuarter['total'] >= 0) {
                                                                                                    echo $fourthQuarter['total'];
                                                                                                } else {
                                                                                                    $total = $fourthQuarter['summative'] + $fourthQuarter['prerogative'] + $fourthQuarter['exam'] + $fourthQuarter['bonus'];

                                                                                                    if ($total > 100) {
                                                                                                        echo 100;
                                                                                                    } else {
                                                                                                        echo $total;
                                                                                                    }
                                                                                                }
                                                                                            } else {
                                                                                                echo 0;
                                                                                            }

                                                                                            ?>" id="total4" name="total4">
                            </div>
                            <button type="submit" id="submit4" name="submit4" class="btn btn-warning text-white"><span><i class="bi bi-plus-circle-fill"></i></span> Add</button>
                        </form>
                    </div>
                </div>
            </div>
</body>

<script>
    // for validation
    $(document).ready(function() {
        getData()
        onChange1()
        onChange2()
        onChange3()
        onChange4()
    });
    // for 1st quarter on change
    function onChange1() {
        // geta value from the input field
        let pre = parseFloat($("#prerogative1").val()) || 0;
        let summa = parseFloat($("#summative1").val()) || 0;
        let exam = parseFloat($("#exam1").val()) || 0;
        let bonus = parseFloat($("#bonus1").val()) || 0;
        // if the value exceed to the max value set the value to the max.
        if (pre > 25) {
            pre = 25.00;
        }
        if (summa > 25) {
            summa = 25.00;
        }
        if (exam > 50) {
            exam = 50.00;
        }
        let result = pre + summa + exam + bonus;

        if (result > 100) {
            result = 100.0
        }
        // set the value to input
        document.getElementById("prerogative1").value = pre;
        document.getElementById("summative1").value = summa;
        document.getElementById("exam1").value = exam;
        document.getElementById("bonus1").value = bonus;
        document.getElementById("total1").value = result;

    }

    // for 2nd quarter
    function onChange2() {
        let pre = parseFloat($("#prerogative2").val()) || 0;
        let summa = parseFloat($("#summative2").val()) || 0;
        let exam = parseFloat($("#exam2").val()) || 0;
        let bonus = parseFloat($("#bonus2").val()) || 0;

        if (pre > 25) {
            pre = 25.00;
        }
        if (summa > 25) {
            summa = 25.00;
        }
        if (exam > 50) {
            exam = 50.00;
        }

        let result = pre + summa + exam + bonus;

        if (result > 100) {
            result = 100.0
        }
        document.getElementById("prerogative2").value = pre;
        document.getElementById("summative2").value = summa;
        document.getElementById("exam2").value = exam;
        document.getElementById("bonus2").value = bonus;
        document.getElementById("total2").value = result;

    }

    // for 3rd quarter
    function onChange3() {
        let pre = parseFloat($("#prerogative3").val()) || 0;
        let summa = parseFloat($("#summative3").val()) || 0;
        let exam = parseFloat($("#exam3").val()) || 0;
        let bonus = parseFloat($("#bonus3").val()) || 0;

        if (pre > 25) {
            pre = 25.00;
        }
        if (summa > 25) {
            summa = 25.00;
        }
        if (exam > 50) {
            exam = 50.00;
        }

        let result = pre + summa + exam + bonus;

        if (result > 100) {
            result = 100.0
        }
        document.getElementById("prerogative3").value = pre;
        document.getElementById("summative3").value = summa;
        document.getElementById("exam3").value = exam;
        document.getElementById("bonus3").value = bonus;
        document.getElementById("total3").value = result;

    }

    // for 4th quarter
    function onChange4() {
        let pre4 = parseFloat($("#prerogative4").val()) || 0;
        let summa4 = parseFloat($("#summative4").val()) || 0;
        let exam4 = parseFloat($("#exam4").val()) || 0;
        let bonus4 = parseFloat($("#bonus4").val()) || 0;

        if (pre4 > 25) {
            pre4 = 25.00;
        }
        if (summa4 > 25) {
            summa4 = 25.00;
        }
        if (exam4 > 50) {
            exam = 50.00;
        }

        let result = pre4 + summa4 + exam4 + bonus4;

        if (result > 100) {
            result = 100.0
        }
        document.getElementById("prerogative4").value = pre4;
        document.getElementById("summative4").value = summa4;
        document.getElementById("exam4").value = exam4;
        document.getElementById("bonus4").value = bonus4;
        document.getElementById("total4").value = result;

    }
</script>

</html>