<?php require_once("config.php"); include("functions.php"); 
$date = new DateTime(null, new DateTimezone("Asia/Kolkata"));
$created=$date->format('Y-m-d H:i:s');
$action = $_POST["action"];
if(!empty($action)) {
	switch($action) {
		case "addr":  
		    if(strlen($_POST["txtmessager"])<12)  { 
			echo "<div id='alert'><font color='red'>12 characters atleast </font></alert>";
			} 
			else {
					$msg=$_POST["txtmessager"];
						$uname=trim($_POST["unamer"]);
					$uemail=trim($_POST["uemailr"]);
					if($uname!=''){
					if(!preg_match("/^[a-zA-Zs]+$/", $uname)){
            $error[] = 'Full Name:Characters Only (No digits or special charaters) ';
        } 
      }
        	if(strlen($uname)<3){

            $error[] = 'Full Name:Enter atleast 3 charaters.. ';
        } 

          if(strlen($uname)>50){
            $error[] = 'Full Name: Max length 50 Characters Not allowed';
        }
					
				
         if(!preg_match("/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,})$/i", $uemail)){
            $error[] = 'Invalid Entry for Email.ie- username@domain.com';
        }
         if(strlen($uemail)>100){
            $error[] = 'Email: Max length 100 Characters Not allowed';
            
					}
					  if(isset($error)){ 
foreach($error as $error){ 
  echo '<p class="alert">'.$error.'</p>'; 
}
 }
					
        if(!isset($error)){ 
   
$postid=$_POST["postm"];
$parentid=$_POST["postidr"];
$status=0;
$msg=htmlentities($msg);
				$sql="INSERT INTO comments(cm_message,postid,created,status,uname,uemail,parentid) Values(:cm_message,:postid,:created,:status,:uname,:uemail,:parentid)";
     $stmt = $db->prepare($sql);
       $stmt->bindParam(':cm_message', $msg ,PDO::PARAM_STR);
       $stmt->bindParam(':postid', $postid, PDO::PARAM_INT);
           $stmt->bindParam(':parentid', $parentid, PDO::PARAM_INT);
       $stmt->bindParam(':created', $created, PDO::PARAM_STR);
       $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->bindParam(':uname', $uname, PDO::PARAM_STR);
             $stmt->bindParam(':uemail', $uemail, PDO::PARAM_STR);
    $stmt->execute();
    $last_id= $db->lastInsertId();
		    if($last_id){
		   $sql="SELECT * FROM comments WHERE cm_id=:cm_id"; 
     $stmt = $db->prepare($sql);
        $stmt->bindParam(':cm_id', $last_id, PDO::PARAM_INT);
    $stmt->execute();
        $rows=$stmt->fetchAll(); 
		  foreach($rows as $rowcm)
		  { 
	if($rowcm["uname"]!=''){$unamo=$rowcm["uname"];} else{ $unamo='Anonymous ';}
	?>
 <div class="row cm_main">
    <div class="col-sm-12 cm_head">
<?php 
				  echo '<div class="message-box"  id="message_' . $last_id. '">
				       <div class="reply_cm"> <span class="to-user">@'.userfind($rowcm["parentid"],$db).'</span> replied by <strong>' .$unamo. ' </strong>'. $rowcm["created"] .'</div></div>
				       <div class="col-sm-12">
						<div class="reply_cm">' . $msg. '</div>
							<div class="alert">Your reply is awaiting moderation</div>
</div>

						
						'; } ?> 
</div>
</div>

						<?php 

			}
        }
			}
			break;			
	}
}
?>