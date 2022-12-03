<?php
session_start();

include 'mysql_connect.php';

if (isset($_SESSION['isLogin'])) {
    if ($_SESSION['isLogin']) {
        if ($_SESSION['account_type'] == "teacher") {
            header('Location:index.php');
        } else {
            header('Location:studentDashboard.php');
        }
    }
}

if(isset($_POST['submit']) ){
    
    $lrn = $_POST['lrn'];
    $fullname = $_POST['fullname'];
    $guardian_name = $_POST['guardian_name'];
    $gender = $_POST['gender'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['confirm_password'];

    if($password!=$password2){
        echo '<script>';
        echo "alert('password not macth!');";
        echo '</script>';
    }else{
        $date = date_create(); 
        $stamp = date_format($date,'YmdHis');
        $temp = $_FILES['file']['tmp_name'];
    
        $directory = "upload/" . $stamp . $_FILES['file']['name'];
        
            if(move_uploaded_file($temp,$directory)) {

                $sql = "SELECT * FROM  account where lrn='$lrn'";
                $res = mysqli_query($conn, $sql);
                if (mysqli_num_rows($res) > 0) {
                    echo '<script>';
                    echo "alert('LRN already taken!');";
                    echo '</script>'; 
                }else{
                    
                    $sql = "INSERT INTO account 
                    SET 
                    id=null,
                    lrn='$lrn',
                    fullname='$fullname',
                    gender='$gender',
                    guardian_name='$guardian_name',
                    account_type='student',                    
                    username='$username',
                    profile='$directory',
                    password='$password';
                    ";
                    
                    if (mysqli_query($conn, $sql)) {
            
                        echo '<script>';
                        echo "alert('Add Sucessfully!');";
                        echo '</script>';
                        header("Refresh:1; url=login.php", true, 1);
                    } else {
                        echo mysqli_error($conn);
                        echo '<script>';
                        echo "alert('Error Occurfsfd!');";
                        echo '</script>';
                        header("Refresh:1; url=registration.php", true, 1);
                    }
                    
                } 
         
            }
    }
    
    }else{
        
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
<style>
    body{
        
    }

</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" /> 


  <link rel="stylesheet" href="style.css">  

 <body>
    <div class="container">
            <div class="row d-flex justify-content-center">   <form method="POST" action="" enctype="multipart/form-data">
               <div class="col-12 mt-5 card p-5">
               
                        <div class="row">
                        <div class="col-md-4">
                                <div class="col-md-12">
                                        <img   src="profile.png" class="border" alt="Profile"  id="output"  width="250"> 
                                    </div>
                                    <div class="col-md-12">
                                        <input    accept="image/*"  onchange="loadFile(event)" type="file" name="file" required><br>
                                    </div>
                                </div>

                        <div class="col-md-8 py-5 ">
                                <div class="row d-flex justify-content-between">

                                    <div class="col-md-6">
                                    <div class="col-md-12 py-3">
                                        <div class="form-group row">
                                            <label class="col-sm-4 " for="lrn">LRN:</label>
                                            <div class="col-sm-8">
                                                <input class=" form-control" type="text" name="lrn"  id="lrn">
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-md-12 py-3">
                                        <div class="form-group row">
                                            <label class="col-sm-4 " for="fullname">Fullname:</label>
                                            <div class="col-sm-8">
                                                <input class=" form-control" type="text" name="fullname"  id="fullname">
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-md-12 py-3">
                                        <div class="form-group row">
                                            <label class="col-sm-4 " for="gender">Gender:</label>
                                            <div class="col-sm-8">
                                            <select class="form-select" name="gender" required aria-label="Default select example">
                                                <option selected>Select Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-md-12 py-3">
                                        <div class="form-group row">
                                            <label class="col-sm-4 " for="guardian_name">Guardian Name:</label>
                                            <div class="col-sm-8">
                                                <input class=" form-control" type="text" name="guardian_name"  id="guardian_name">
                                            </div>
                                        </div> 
                                    </div>

                                   
                                  
                                    </div>
                                    <div class="col-md-6 ">
                                   
                                    <div class="col-md-12 py-3">
                                        <div class="form-group row">
                                            <label class="col-sm-4 " for="username">Username:</label>
                                            <div class="col-sm-8">
                                                <input class=" form-control" type="text" name="username"  id="username">
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-md-12 py-3">
                                        <div class="form-group row">
                                            <label class="col-sm-4 " for="password">Password:</label>
                                            <div class="col-sm-8">
                                                <input class=" form-control" type="password" name="password"  id="password">
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-md-12 py-3">
                                        <div class="form-group row">
                                            <label class="col-sm-4 " for="confirm_password">Confirm Password:</label>
                                            <div class="col-sm-8">
                                                <input class=" form-control" type="password" name="confirm_password"  id="confirm_password">
                                            </div>
                                        </div> 
                                    </div>


                                    </div>

                                </div>
                            </div>
                             
                        </div>
                  

                    <div class="d-flex justify-content-end">
                        <button class="btn btn-danger mx-2" type="reset">Reset</button>
                        <button class="btn btn-primary mx-2" name="submit" type="submit">Submit</button>
                    </div>
                    <div class=" d-flex justify-content-end">   <a href="login.php">Already have an account.</a> </div>
                   
                </div>  
               
                </form>
            </div>
    </div>

    <script>
    var loadFile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
        image.setAttribute("class","out");
    };

</script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body> 
