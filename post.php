<?php require_once("config.php");?>
<!DOCTYPE html>
<html>
<?php include("functions.php"); $post_id=$_GET['id']; 
  $sql="SELECT * FROM posts WHERE post_id=:post_id"; 
  $stmt=$db->prepare($sql);
  $stmt->bindParam(':post_id', $post_id ,PDO::PARAM_INT);
  $stmt->execute();
  $row=$stmt->fetch();
  $title=$row['title']; $content=$row['content']; $post_id=$row['post_id']; 
?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $title=$row['title'];?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="style.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="comment_scripts.js"></script>
<script src="reply_scripts.js"></script>
</head>
<body>
<div class="container">
	<div div class="row">
		<div class="col-sm-12">
	 	  <h1><?php echo $title=$row['title'];?></h1>	
	  </div>
  </div><br>
  <div class="row">
    <div class="col-sm-12">
      <?php echo $content;?> 
    </div>
  </div><br>
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
foreach($CommentList as $cl) { ?>
<?php  
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
<?php if($cl["parentid"]!=0){ 
    echo '
  <a class="add_comment reply_cm cm_reply" id="reply_'.$cl["cm_id"].'" onclick="reply_form('.$cl["cm_id"].','.$post_id.')"> Reply</a>'; } 
  else 
    { 
echo '
  <span class="cm_reply"><a class="add_comment" id="reply_'.$cl["cm_id"].'" onclick="reply_form('.$cl["cm_id"].','.$post_id.')"> Reply</a></span>';
    } ?> 
   	<div class="reply_area" id="reply_area_<?php echo $cl["cm_id"];?>"></div>
                   <div class="message-wrapcm-<?php echo $cl['cm_id'];?>">    
                    </div>
                </div>
</div>
</div>
 <!--Append reply form-->
<?php }?>
<hr>
<!--Add New Comment -->
<div class="row">
       <div class="col-sm-12">
        <a class="add_new_comment">Add a comment </a>
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
</body>
</html>