<?php
require_once("config.php");
require "./law.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<?php include("functions.php");
// $post_id = 4;
// $sql = "SELECT * FROM posts WHERE post_id=:post_id";
// $stmt = $db->prepare($sql);
// $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
// $stmt->execute();
// $row = $stmt->fetch();
// $title = $row['title'];
// $content = $row['content'];
// $post_id = $row['post_id'];
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- link CSS -->
    <link rel="stylesheet" href="./assets/css/infoLaw.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- link icon -->
    <script src="https://kit.fontawesome.com/83128b721a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://kit.fontawesome.com/83128b721a.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <!-- link swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <!-- link javascript -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="comment_scripts.js"></script>
    <script src="reply_scripts.js"></script>
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
        if (!empty($_POST['btnlogout'])) {
            unset($_SESSION['customerid']);
            redirect("http://localhost:3000/loginPage.php");
        }
        if (empty($_SESSION['customerid'])) {
            $isLoggedIn = false;
            echo '
                <div class="icons">
                    <a href="./loginPage.php" class="btn">login</a>
                    <div id="menu-btn" class="fas fa-bars"></div>
                </div>
                ';
        } else {
            $isLoggedIn = true;
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

    <div class="container">
        <div class="content">
            <h1 class="heading">luật an ninh mạng</h1>
            <?php
            $idDieu = $_GET['lawID'];
            $lawInfo = new law();
            $result = $lawInfo->showLawInfo($idDieu);
            $isFlag = true;
            for ($i = 0; $i < count($result); $i++) {
                $s = $result[$i];
                if ($isFlag) {
                    echo '
                        <h2>Chuong: <span>' . $s->chuong . '</span></h2>
                        <h3>Noi Dung Chuong: <span>' . $s->noidungchuong . '</span></h3>
                        <h2>Dieu: <span>' . $s->dieu . '</span></h2>
                        <h3>Noi Dung Dieu: <span>' . $s->noidungdieu . '</span></h3>
                        ';
                    $isFlag = false;
                }
                echo '
                    <h2>Khoan: <span>' . $s->khoan . '</span></h2>
                    <h4>Noi Dung Khoan: <span>' . $s->noidungkhoan . '</span></h4>
                    ';
            }
            ?>
        </div>

        <!-- DOWNLOAD -->
        <?php 
            if(isset($_GET['lawID']) && isset($_GET['currentCount'])){
                $download = $_GET['lawID'];
                $current = $_GET['currentCount'];

                $new = new law();
                $newDownload = $new->updateCountDownload($download,$current); 
            }
        ?>
        <div class="getLaw">
            <button id="btnDown" onclick="downloadLaw(<?php echo $idDieu.','. $result[0]->countdow ?>)">Download</button>
            <!-- <button id="btnDownload">Download</button> -->
        </div>
        <?php 
            // $count = $result[1]->countdow;
            // $newCount = $count + 1;
        ?>

        <!-- COMMENT -->


        <?php 
            $comment = new comment();
            $resultComment = $comment->showCommentsWithLawID($idDieu);
        ?>

        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-sm-12">
                        <!--Comment Column start -->
                        <script type="text/javascript"></script>
                        <hr><strong><?php echo count($resultComment) . ' ' . name(count($resultComment)); ?> </strong>
                        <hr>
                    </div>
                </div>
                <?php
                    for($i=0; $i<count($resultComment);$i++){
                        $s = $resultComment[$i];
                ?>
                        <div class="row cm_mainr">
                            <div class="col-sm-12 cm_head">
                                <?php echo $s->customerName . ' <span class="right">' . easy($s->created) . '</span><br>'; ?>
                            </div>
                            <div class="col-sm-12">
                                <p class="reply"><?php echo $s->commentMessage . '<br>';  ?> </p>
                            </div>
                        </div>
                <?php }?>
                <hr>
                <!--Add New Comment -->
                <div class="row">
                    <div class="col-sm-12">
                        <a class="add_new_comment" onclick="checkComment()">Add a comment</a>
                    </div>
                </div>

                <div class="new-comment">
                    <?php 
                        if(!empty($_POST['submitComment'])){
                            $commentNew = $_POST['txtmessage'];
                            $customerIDComment = $_SESSION['customerid'];
                            $lawID = $idDieu;

                            $newComment = new comment();
                            $newComment->commentMessage = $commentNew;
                            $newComment->customerID = $customerIDComment;
                            $newComment->lawID = $lawID;
                            $newComment->addNewComment($lawID);

                            unset($commentNew);
                            unset($customerIDComment);
                            unset($lawID);

                            echo '
                                <script>
                                    var confirmMsg = confirm("Lưu thành công. Bạn có muốn tiếp tục không?");
                                    if (confirmMsg == true) {
                                        deleteFields();
                                    }
                                </script>';
                        }
                    ?>
                    <form action="" method="post" id="form">
                        <textarea name="txtmessage" class="txtmessage form-control" placeholder="Type Comment" id="ftextarea" cols="auto" rows="2"></textarea>
                        <input type="submit" name="submitComment" id="" onclick="return checkValidate()">
                    </form>
                </div>
                <!--Comment Column end -->
            </div>
            <!--Add New Comment -->
            <div class="col-sm-2">
            </div>
        </div>
    </div>
    <br>
    <br> <br>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="./index.js"></script>


    <script>

        function downloadLaw(idDieu, currentCount) {
            if (isLoggedIn()) {
                // let url = "http://localhost:3000/infoLaw.php";  
                // window.location.href = url + "?lawID=" + idDieu + "&currentCount=" + currentCount + "&toPDF.php?lawID=" + idDieu; 
                // window.location.href = "http://localhost:3000/toPDF.php?lawID=" + idDieu;
                
                let url1 = "http://localhost:3000/infoLaw.php";
                let url2 = "toPDF.php?lawID=" + idDieu;

                window.open(url1 + "?lawID=" + idDieu + "&currentCount=" + currentCount);
                window.open(url2);
            } else {
                alert("Bạn cần đăng nhập để tải xuống tài liệu.");
            }
        }

        function checkComment() {
            if (isLoggedIn()) {
                $(document).ready(function() {
                    $(".add_new_comment").click(function() {
                        $(".new_comment_area").show();
                        $('#alert').remove();
                    });
                });
            } else {
                alert("Bạn cần đăng nhập để tải xuống tài liệu.");
            }
        }

        function isLoggedIn() {
            return <?php echo ($isLoggedIn ? 'true' : 'false'); ?>;
        }

        function checkValidate(){
                textComment = document.getElementById("ftextarea").value;
                if(textComment == ""){
                    alert("Please fill out all fields");
                    return false;
                }
                return true;
        }

        function deleteFields() {
            document.getElementById("form").reset();
            document.getElementById("ftextarea").value = "";
        }
    </script>
</body>

</html>