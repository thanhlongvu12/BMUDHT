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
</head>
<body>
    <?php 
        $customerID = $_GET['customerid'];
        $customerContro = new customer();
        $CTM = $customerContro->showInfoCustomer($customerID);
    ?>
    <?php 
        for($i=0; $i<count($CTM); $i++){
            $r = $CTM[$i];
    ?>
        <div class="">
            <div class="line">
                <h3 class="title">Customer ID: </h3>
                <p class="content"><?php echo $r->customerID?></p>
            </div>
            <div class="line">
                <h3 class="title">Customer Name: </h3>
                <p class="content"><?php echo $r->customerName?></p>
            </div>
            <div class="line">
                <h3 class="title">Phone Number: </h3>
                <p class="content"><?php echo $r->phone?></p>
            </div>
            <div class="line">
                <h3 class="title">Email: </h3>
                <p class="content"><?php echo $r->email?></p>
            </div>
            <div class="line">
                <h3 class="title">Address: </h3>
                <p class="content"><?php echo $r->address?></p>
            </div>
            <div class="line">
                <h3 class="title">Status: </h3>
                <p class="content">
                    <?php
                        if($r->flag == 1){
                            echo "Đang hoạt động";
                        }else{
                            echo "Đang cấm";
                        }
                    ?>
                </p>
            </div>
        </div>
    <?php 
        }
    ?>
</body>
</html>