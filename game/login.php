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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color:#33475b">
    <div class="page_container">
         <div class="lc">
            <div class="division">
                <a href="index.php"><img src="logo.png" alt="logo" width="100" height="100"></a>
            </div>
            <div class="division">
                <h2>Ed-venture</h2>
            </div>
        </div> 
        <br><br>
        <div class="container">
            <form action="login.php" method="post">
                <div class=form-group>
                    <input type="text" class="form-control" name="user-id" placeholder="User-Id:">
                </div>
                <div class=form-group>
                    <input type="password" class="form-control" name="password" placeholder="Password:">
                </div>
                <div class="form.btn">
                    <input type="submit" value="Login" name="login" class="btn btn-primary">
                </div>
            </form>
            <br>
            <div><p>New to Game?   <a href="registration.php">Register Here</a></p></div>
            <div> 
                <?php
                
                if(isset($_POST["login"])){
                    $uid=$_POST["user-id"]; 
                    $password=$_POST["password"]; 
                    require_once "database.php";
                    $sql="SELECT * FROM users WHERE uid='$uid'";
                    $result=mysqli_query($conn,$sql);
                    $user=mysqli_fetch_array($result,MYSQLI_ASSOC);
                    if($user){
                        if(password_verify($password,$user["password"])){
                            session_start();
                            $_SESSION["user"]="yes";
                            header("Location: Index.php");
                            die();
                        }
                        else{
                            echo "<div class='alert alert-danger'>Oops...Password does not match..Try again..</div> ";
                        }
                    }   
                    else{
                        echo "<div class='alert alert-danger'>User does not exist</div> ";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    </body>
</html>
 