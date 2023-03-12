<?php
    include('./law.php');
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- link CSS -->
    <link rel="stylesheet" href="./assets/css/index.css">

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
    <header class="header">
        <a href="./index.php" class="logo">An<span> Ninh</span></a>

        <nav class="navbar">
            <a href="./index.php">Home</a>
            <a href="#">Pháp luật</a>
            <a href="#">Tư vấn pháp luật</a>
            <a href="./trainer.php">Liên hệ</a>
            <?php 
                if(!empty($_SESSION['customerid'])){
                    echo '<a href="./infoCustomer.php?customerid='.$_SESSION['customerid'].'">Account</a>';
                }
            ?>
        </nav>
        <?php
        if (!empty($_POST['btnlogout'])) {
            unset($_SESSION['customerid']);
            redirect("http://localhost:3000/loginPage.php");
        }
        if (empty($_SESSION['customerid'])) {
            echo '
                    <div class="icons">
                        <a href="./loginPage.php" class="btn">login</a>
                        <div id="menu-btn" class="fas fa-bars"></div>
                    </div>
                    ';
        } else {
            echo '
                    <div class="icons">
                        <form action="' . $_SERVER['PHP_SELF'] . '" method="POST">
                            <input type="submit" value="Logout" name="btnlogout" class="btn">
                        </form>
                        <div id="menu-btn" class="fas fa-bars"></div>
                    </div>
                    ';
        }
        ?>
    </header>
</body>

</html>