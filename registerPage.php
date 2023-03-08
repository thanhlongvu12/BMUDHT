<?php include('./law.php')?>
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
<div class="container">
    <?php 
        if(!empty($_POST["register"])){
            $customerid = $_POST['customerid'];
            $customername = $_POST['customername'];
            $password = $_POST['password'];
            $password = sha1($password);
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            $check = new customer();
            $checkCustomerID = $check->checkCustomerID($customerid);
            if(count($checkCustomerID) == 0){
                $newCustomer = new customer();
                $newCustomer->customerID = $customerid;
                $newCustomer->customerName = $customername;
                $newCustomer->password = $password;
                $newCustomer->email = $email;
                $newCustomer->phone = $phone;
                $newCustomer->address = $address;
                $newCustomer->registerCustomer();
            }else{
                echo "<script>alert('ID is avaiable')</script>";
            }
        }
    ?>
    <h1>Register Page</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" class="login-form" method="POST" onsubmit="checkValidate()">
            <div class="line-input">
                <label for="">Customer ID:</label>
                <input type="text" name="customerid" id="customerid" placeholder="User ID">
            </div>
            <div class="line-input">
                <label for="">Customer Name:</label>
                <input type="text" name="customername" id="customername" placeholder="User Name">
            </div>
            <div class="line-input">
                <label for="">Password:</label>
                <input type="text" name="password" id="password" placeholder="Password">
            </div>
            <div class="line-input">
                <label for="">Email:</label>
                <input type="text" name="email" id="email" placeholder="Email">
            </div>
            <div class="line-input">
                <label for="">Phone:</label>
                <input type="text" name="phone" id="phone" placeholder="Phone">
            </div>
            <div class="line-input">
                <label for="">Address:</label>
                <textarea name="address" id="address" cols="80" rows="10"></textarea>
            </div>
            
            <input type="submit" name="register" id="register" value="Register" onclick="return checkValidate()">
        </form>
        <a href="./loginPage.php"></a>

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
    </div>
</body>
</html>