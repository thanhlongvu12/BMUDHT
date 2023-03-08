<?php 
    require_once("config.php");
    require "./law.php";
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<?php include("functions.php"); $post_id=4; 
  $sql="SELECT * FROM posts WHERE post_id=:post_id"; 
  $stmt=$db->prepare($sql);
  $stmt->bindParam(':post_id', $post_id ,PDO::PARAM_INT);
  $stmt->execute();
  $row=$stmt->fetch();
  $title=$row['title']; $content=$row['content']; $post_id=$row['post_id']; 
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <!-- link swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
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
        </nav>

        <?php 
            if(!empty($_POST['btnlogout'])){
                unset($_SESSION['customerid']);
                redirect("http://localhost:3000/loginPage.php");
            }
            if(empty($_SESSION['customerid'])){
                $isLoggedIn = false;
                echo '
                <div class="icons">
                    <a href="./loginPage.php" class="btn">login</a>
                    <div id="menu-btn" class="fas fa-bars"></div>
                </div>
                ';
            }else{
                $isLoggedIn = true;
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

        <div class="container">
            <div class="content">
                <h1 class="heading">luật an ninh mạng</h1>
                <?php 
                    $idDieu = $_GET['lawID'];
                    $lawInfo = new law();
                    $result = $lawInfo->showLawInfo($idDieu);
                    $isFlag = true;
                    for($i=0; $i<count($result); $i++){
                        $s = $result[$i];
                        if($isFlag){
                            echo '
                                <h2>Chuong: <span>'.$s->chuong.'</span></h2>
                                <h3>Noi Dung Chuong: <span>'.$s->noidungchuong.'</span></h3>
                                <h2>Dieu: <span>'.$s->dieu.'</span></h2>
                                <h3>Noi Dung Dieu: <span>'.$s->noidungdieu.'</span></h3>
                            ';
                            $isFlag=false;
                        }
                        echo '
                            <h2>Khoan: <span>'.$s->khoan.'</span></h2>
                            <h4>Noi Dung Khoan: <span>'.$s->noidungkhoan.'</span></h4>
                        ';
                    }
                    echo $_SESSION['customerid'];
                ?>
            </div>

            <div class="getLaw">
                <!-- <a href="#" onclick="downloadLaw(<?php echo $idDieu?>)">Download</a> -->
                <button onclick="downloadLaw(<?php echo $idDieu?>)">Download</button>
            </div>

            
            <div class="row">
                <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-12">
                                <!--Comment Column start -->
                                <script type="text/javascript"></script>
                                <hr><strong><?php echo count_comment($post_id,$db).' '.name(count_comment($post_id,$db));?> </strong><hr>
                            </div>
                        </div>
                        <?php 
                        $CommentList = commentTree($post_id);
                        foreach($CommentList as $cl){ 
                            if($cl["parentid"]!=0){ 
                        ?>
                        <!--Reply-->
                        <div class="row cm_mainr">
                            <div class="col-sm-12 cm_head">
                                <?php echo ' <div class ="reply_cm"><span class="to-user">@'.userfind($cl["parentid"],$db).'</span> replied by <strong>'.$cl["username"].'</strong> <span class="right">' .easy($cl['created']).'</span><br> </div>'; ?>
                            </div>
                            <div class="col-sm-12"> 
                                <p class="reply"><?php echo $cl["cm_message"].'<br>';  ?> </p>
                            </div>
                        </div>
                        <?php } else {?> 
                        <!--Comment-->
                        <!--Display Comment & Reply-->
                        <div class="row cm_main">
                            <div class="col-sm-12 cm_head">
                                <div class="cm_author"><?php echo $cl["username"].' <span class="right">' .easy($cl['created']).'</span><br>';?></div>
                            </div>
                            <div class="col-sm-12"> 
                                <p><?php echo $cl["cm_message"].'<br>';  ?> </p>
                            </div>
                        </div>
                        <?php } ?>
                        <!--Display Comment & Reply-->
                        <!--Append reply form--> 
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="comment-list-boxr">
                                    <?php 
                                        if($cl["parentid"]!=0){ 
                                            echo '
                                                <a class="add_comment reply_cm cm_reply" id="reply_'.$cl["cm_id"].'" onclick="reply_form('.$cl["cm_id"].','.$post_id.')"> Reply</a>'; 
                                            }else{ 
                                            echo '
                                                <span class="cm_reply"><a class="add_comment" id="reply_'.$cl["cm_id"].'" onclick="reply_form('.$cl["cm_id"].','.$post_id.')"> Reply</a></span>';
                                            } 
                                    ?> 
                                    <div class="reply_area" id="reply_area_<?php echo $cl["cm_id"];?>"></div>
                                        <div class="message-wrapcm-<?php echo $cl['cm_id'];?>"></div>
                                    </div>
                                </div>
                            </div>
                            <!--Append reply form-->
                        <?php }?>
            <hr>
            <!--Add New Comment -->
            <div class="row">
                <div class="col-sm-12">
                    <a  class="add_new_comment" onclick="checkComment()">Add a comment </a>
                </div>
                </div>
            <div class="row">
                <div class="col-sm-12">
            <div class="comment-list-box" >
            <div id="frmAdd" class="new_comment_area"> 
            <textarea name="txtmessage" class="txtmessage form-control"  placeholder="Type Comment"  id="ftextarea" cols="auto" rows="2"></textarea>
            <br>
            <div class="row">
                <div class="col-sm-6">
                    <input type="text" id="uname" placeholder="Full Name" class="uname form-control" required>
                </div>
                <div class="col-sm-6">
                    <input type="email" id="uemail" class="uemail form-control"placeholder="Your Email "  required>
                </div>
            </div>
            <input type="hidden" value="<?php echo $post_id; ?>" name="postid" class="postid">
            <br><button class="btnAddAction btn btn-primary" name="submit" onClick="callCrudAction('add',this)">Comment </button>
            </div>
            <div class="message-wrap">                      
            </div>
            </div>
            </div>
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
        function downloadLaw(idDieu) {
            if (isLoggedIn()) {
                window.location.href = "toPDF.php?lawID=" + idDieu;
            } else {
                alert("Bạn cần đăng nhập để tải xuống tài liệu.");
            }
        }

        function checkComment(){
            if (!isLoggedIn()) {
                alert("Bạn cần đăng nhập để tải xuống tài liệu.");
            }
        }

        function isLoggedIn() {
            return <?php echo ($isLoggedIn ? 'true' : 'false'); ?>;
        }
</script>
</body>
</html>