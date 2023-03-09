<?php include("config.php");
$date = new DateTime(null, new DateTimezone("Asia/Kolkata"));
$created = $date->format('Y-m-d H:i:s');
$action = $_POST["action"];
if (!empty($action)) {
  switch ($action) {
    case "add":

      if (strlen(trim($_POST["txtmessage"])) < 12) {
        echo "<div id='alert'><font color='red'>12 characters atleast </font></div>";
      } else {
        $msg = $_POST["txtmessage"];
        $uname = trim($_POST["uname"]);
        $uemail = trim($_POST["uemail"]);

        if (strlen($uname) < 3) {

          $error[] = 'Full Name:Enter atleast 3 charaters.. ';
        }

        if (strlen($uname) > 50) {
          $error[] = 'Full Name: Max length 50 Characters Not allowed';
        }
        // if($uname!=''){
        // 			if(!preg_match("/^[a-zA-Zs]+$/", $uname)){
        //     $error[] = 'Full Name:Characters Only (No digits or special charaters) ';
        // } 
      }
      if (!preg_match("/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,})$/i", $uemail)) {
        $error[] = 'Invalid Entry for Email.ie- username@domain.com';
      }

      if (strlen($uemail) > 100) {
        $error[] = 'Email: Max length 100 Characters Not allowed';
      }

      if (isset($error)) {
        foreach ($error as $error) {
          echo '<p class="alert">' . $error . '</p>';
        }
      }
      if (!isset($error)) {
        $postid = $_POST["postid"];
        $msg = htmlentities($msg);
        $parentid = 0;
        $sql = "INSERT INTO comments(cm_message,postid,created,status,uname,uemail,parentid) Values(:cm_message,:postid,:created,:status,:uname,:uemail,:parentid)";
        $stmt = $db->prepare($sql);
        $status = 0;
        $stmt->bindParam(':cm_message', $msg, PDO::PARAM_STR);
        $stmt->bindParam(':postid', $postid, PDO::PARAM_INT);
        $stmt->bindParam(':parentid', $parentid, PDO::PARAM_INT);
        $stmt->bindParam(':created', $created, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':uname', $uname, PDO::PARAM_STR);
        $stmt->bindParam(':uemail', $uemail, PDO::PARAM_STR);
        $stmt->execute();
        $last_id = $db->lastInsertId();
        if ($last_id) {
          $sql = "SELECT * FROM comments WHERE cm_id=:cm_id";
          $stmt = $db->prepare($sql);
          $stmt->bindParam(':cm_id', $last_id, PDO::PARAM_INT);
          $stmt->execute();
          $rows = $stmt->fetchAll();
          foreach ($rows as $row) {
            if ($row["uname"] != '') {
              $unamo = $row["uname"];
            } else ($unamo = 'Anonymous ')
?>
            <div class="row cm_main">
              <div class="col-sm-12 cm_head">
              <?php echo '<div class="message-box"  id="message_' . $last_id . '">
                            <div class="cm_author"><strong>' . $unamo . '</strong> ' . $row["created"] . ' </div></div></div>
                            <div class="col-sm-12"> 
                            <div class="message-content">' . $msg . '</div>
                            <div class="alert">Your comment is awaiting moderation.</div>
                          </div>';
            } ?>
              </div>
    <?php
        }
      }
      break;
  }
}
    ?>