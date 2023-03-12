<?php
    // include("./customer.php");
    include "./law.php";
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
    <!-- link icon -->
    <script src="https://kit.fontawesome.com/83128b721a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://kit.fontawesome.com/83128b721a.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <!-- link swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
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
                    echo '<a href="./infoCustomer.php">Account</a>';
                }
            ?>
        </nav>
        <?php 
            if(!empty($_POST['btnlogout'])){
                unset($_SESSION['customerid']);
                redirect("http://localhost:3000/loginPage.php");
            }
            if(empty($_SESSION['customerid'])){
                echo '
                <div class="icons">
                    <a href="./loginPage.php" class="btn">login</a>
                    <div id="menu-btn" class="fas fa-bars"></div>
                </div>
                ';
            }else{
                echo'
                <div class="icons">
                    <form action="'. $_SERVER['PHP_SELF'] . '" method="POST">
                        <input type="submit" value="Logout" name="btnlogout" class="btn">
                    </form>
                    <div id="menu-btn" class="fas fa-bars"></div>
                </div>
                ';
            }
        ?>
    </header>

    <section class="home">
        <div class="swiper home-slider">
            
            <div class="swiper-wrapper">
                <div class="swiper-slide box" style="background: linear-gradient(rgba(0,0,0,.3),rgba(0,0,0,.3)), url('./assets/image/home-1.jpeg');">
                    <div class="content">
                        <h3>Sống và làm việc theo Hiến pháp và pháp luật</h3>
                        <p>Tích cực hưởng ứng Ngày Pháp luật nước Cộng hòa xã hội chủ nghĩa Việt Nam</p>
                    </div>
                </div>
                
                <div class="swiper-slide box" style="background: linear-gradient(rgba(0,0,0,.3),rgba(0,0,0,.3)), url('./assets/image/home-2.jpeg');">
                    <div class="content">
                        <h3>Tìm hiểu và chấp hành pháp luật là trách nhiệm của mọi công dân</h3>
                        <p>Đẩy mạnh cải cách hành chính, cải cách tư pháp, nâng cao năng lực, hiệu quả chỉ đạo điều hành và tổ chức thi hành pháp luật</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <h1 class="heading">luật an ninh mạng</h1>
        
        <div class="search">
            <form action="" method="get">
                <input type="text" name="searchbox" id="" value="<?php if(!empty($_GET['searchbox'])){echo $_GET['searchbox'];}?>">
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
        
        <div class="content">
            <?php
                if(isset($_GET['searchbox'])){
                    $search = $_GET['searchbox'];
                    $law = new law();
                    $result = $law->showLawSearch($search);
                    for ($i=0; $i<count($result); $i++){
                        $s = $result[$i];
                        echo '
                        <div class="law">
                            <a href="./infoLaw.php?lawID='.$s->dieu.'">
                                <p>'.$s->noidungkhoan.'</p>
                            </a>
                        </div>';
                    }
                }else{
                    $law = new law();
                    $result = $law->showLaw();
                    for ($i=0; $i<count($result); $i++){
                        $s = $result[$i];
                        echo '
                        <div class="law">
                            <a href="./infoLaw.php?lawID='.$s->dieu.'">
                                <p>'.$s->noidungkhoan.'</p>
                            </a>
                        </div>';
                    }
                }
            ?>
        </div>
    </section>

    <section>
        <div class="comment">
            
        </div>
    </section>
    
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="./assets/javascript/index.js"></script>
</body>
</html>