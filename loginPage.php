<?php 
include('./law.php');
include("./header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/loginPage.css">
    <title>Login Page</title>

    <style>
        .container{
            margin-top: 10rem;
        }

        .header{
            background-color: rgba(34, 33, 33, 0.8);
        }
    </style>
</head>
<body>
    <?php 
        if(!empty($_POST['btnLogin'])){
            $customerid = $_POST['customerid'];
            $password = $_POST['password'];
            $password = sha1($password);

            $check = new customer();
            $checkAdmin = new customer();
            $checkCustomerLogin = $check->checkLogin($customerid, $password);
            $checkAdminLogin = $checkAdmin->checkAdmin($customerid, $password);
            if(count($checkCustomerLogin) > 0){
                session_start();
                $_SESSION['customerid'] = $customerid;
                $_SESSION['loggined'] = true;
                if (count($checkAdminLogin) > 0){
                    redirect("http://localhost:3000/admin/dashboard.php");
                }else{
                    redirect("http://localhost:3000/index.php");
                }
            }else{
                echo "<script>alert('ID or Password is valid')</script>";
            }
            unset($_SESSION['customerid']);
            $_SESSION['customerid'] = "";
            $_SESSION['loggined'] = false;
        }
    ?>
    <div class="container">
        <h1>Login Page</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" class="login-form" method="post">
            <div class="line-input">
                <label for="">Customer ID:</label>
                <input type="text" name="customerid" id="" placeholder="">
            </div>
            <div class="line-input">
                <label for="">Password:</label>
                <input type="text" name="password" id="" placeholder="">
            </div>
            
            <input type="submit" name="btnLogin" id="" value="Login">
        </form>
        <a href="./registerPage.php">create new account</a>
    </div>
    <link rel="stylesheet" href="./css/styleLoginPage.css">
</body>
</html>