<?php 
    include('./law.php')
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="./assets/css/loginPage.css">
</head>
<body>
    <?php 
        if(!empty($_POST["addnew"])){
            $chuong = $_POST['chuong'];
            $noidungchuong = $_POST['noidungchuong'];
            $dieu = $_POST['dieu'];
            $noidungdieu = $_POST['noidungdieu'];
            $khoan = $_POST['khoan'];
            $noidungkhoan = $_POST['noidungkhoan'];

            $new = new law();
            $new->chuong = $chuong;
            $new->noidungchuong = $noidungchuong;
            $new->dieu = $dieu;
            $new->noidungdieu = $noidungdieu;
            $new->khoan = $khoan;
            $new->noidungkhoan = $noidungkhoan;
            $new->addNewLaw();

        }
    ?>
    <h1>Register Page</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" class="login-form" method="POST" onsubmit="checkValidate()">
            <div class="line-input">
                <label for="">Chương:</label>
                <input type="text" name="chuong" id="customerid" placeholder="Chương">
            </div>
            <div class="line-input">
                <label for="">Nội dung chuong:</label>
                <input type="text" name="noidungchuong" id="customername" placeholder="Nội dung chuong">
            </div>
            <div class="line-input">
                <label for="">Điều</label>
                <input type="text" name="dieu" id="password" placeholder="Điều">
            </div>
            <div class="line-input">
                <label for="">Nội dung điều</label>
                <input type="text" name="noidungdieu" id="email" placeholder="Nội dung điều">
            </div>
            <div class="line-input">
                <label for="">Khoản</label>
                <input type="text" name="khoan" id="phone" placeholder="khoản">
            </div>
            <div class="line-input">
                <label for="">Nội dung khoản</label>
                <!-- <textarea name="noidungkhoan" id="address" cols="90" rows="10"></textarea> -->
            </div>
            <div class="line-input">
                <!-- <label for="">Nội dung khoản</label> -->
                <textarea name="noidungkhoan" id="address" cols="107" rows="10"></textarea>
            </div>
            
            
            <input type="submit" name="addnew" id="register" value="Addnew" onclick="return checkValidate()">
        </form>

        <script>
            function checkValidate(){
                cusID = document.getElementById("customerid").value;
                cusName = document.getElementById("customername").value;
                pass = document.getElementById("password").value;
                email = document.getElementById("email").value;
                phone = document.getElementById("phone").value;
                address = document.getElementById("address").value;
                if(cusID == "" || cusName == "" || pass == "" || email == "" || phone == "" || address == ""){
                    alert("Please fill out all fields");
                    return false;
                }
                return true;
            }
        </script>
</body>
</html>