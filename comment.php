<?php require_once("config.php");?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Comment system using AJAX,Jquery,Bootstrap with MYSQL database.</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">
	<div div class="row">
<div style="background:grey; color: #fff;" class="card">
	 	<h1>All Posts</h1>	
	</div>
</div>
<br>
    <div class="row">
    	<?php 
      $sql="SELECT * FROM posts ORDER BY post_id DESC"; 
         $stmt=$db->prepare($sql);
            $stmt->execute();
            $rows=$stmt->fetchAll();
            foreach($rows as $row){
                echo '<div class="col-sm-12 list">
                    <div class="card"><li><a href="post.php?id='.$row["post_id"].'">'.$row["title"].'</a></li></div>
                    </div>'; 
            }
    	?> 
    </div>
</div>
</body>
</html>