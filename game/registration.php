<?php
    session_start();
    if(isset($_SESSION["user"])){
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color:#33475b">
<div class=page_container>
    <div class="logo_container">
        
    <a href="index.php"><img src="logo.png" alt="logo" width="100" height="100"></a>
        <h2> Ed-venture</h2 >
    </div>
    <br><br>
    <div class="container">
    <form action="registration.php"method="post">
        <h3 style="font-family: verdana; color: yellow">Registration Form</h3>
            <div class="form-group">
                <input type="text" class="form-control" name="user-id" placeholder="User-id:">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="full-name" placeholder="Full Name:">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="nick-name" placeholder="Nick Name:">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="register" name="Submit">
            </div> 
        </form>
        <br>
        <div><p>Already Registered?  <a href="login.php">login here</a></p></div>

        <?php
        if(isset($_POST["Submit"])){
            $uid=$_POST["user-id"];
            $fullName=$_POST["full-name"];
            $nickName=$_POST["nick-name"];
            $email=$_POST["email"];
            $password=$_POST["password"];
            $confirm_password=$_POST["confirm_password"];

            $password_hash=password_hash($password,PASSWORD_DEFAULT);
            $errors=array();
            if(empty($fullName) OR empty($email) OR empty($password) OR empty($confirm_password OR empty($uid) OR empty($nickName))){
                array_push($errors,"All fields are required");
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                array_push($errors,"Email is not valid");
            }
            if(strlen($password)<8){
                array_push($errors,"password must be at least 8 characters long.");
            }
            if($password!=$confirm_password){
                array_push($errors,"passwords don't match");
            }
            require_once "database.php";
            
            $sql="SELECT * FROM users WHERE password='$password_hash'";
            $res=mysqli_query($conn,$sql);
            $rc=mysqli_num_rows($res);
            if($rc>0)
            {
                array_push($errors,"Password already used");
            }
            if(count($errors)>0){
                foreach($errors as $error)
                {
                    echo "<div class='alert alert-danger'>$error</div>"; 
                }
            }
            else{
                
                $sql="INSERT INTO users (uid,full_name,nick_name,email,password) VALUES(?,?,?,?,?)";
                $stmt = mysqli_stmt_init($conn);
                $ps=mysqli_stmt_prepare($stmt,$sql);
                if($ps)
                {
                    mysqli_stmt_bind_param($stmt,"sssss",$uid,$fullName,$nickName,$email,$password_hash);
                    mysqli_stmt_execute($stmt);
                    echo "<div class ='alert alert-success'>You are registered successfully.</div>";
                }
                else{
                    die("Something went wrong..");
                }
            }
        }
        ?>
    </div> 

    </div> 
</body>
</html>