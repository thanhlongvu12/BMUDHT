<?php 

    include ('./DBinfo.php');

    function redirect($url, $statusCode = 303){
        header('Location: ' . $url, $statusCode);
        die();
    }
    class law{
        public $chuong;
        public $noidungchuong;
        public $dieu;
        public $noidungdieu;
        public $khoan;
        public $noidungkhoan;
        public $muc;
        public $countdow;
        public $flag;

        public function addNewLaw(){
            try {
                $options = array(PDO::ATTR_EMULATE_PREPARES, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
                $dsn = "mysql:host=".DBinfo::getServer().";dbname=".DBinfo::getDBname().";charset=utf8";
                $conn = new PDO($dsn,DBinfo::getUserName(),DBinfo::getPassword(),$options);

                $sql = "INSERT INTO `luat` (`chuong`, `noidungchuong`, `dieu`, `noidungdieu`, `khoan`, `noidungkhoan`, `countdown`, `flag`) 
                        VALUES (:chuong, :noidungchuong, :dieu, :noidungdieu, :khoan, :noidungkhoan, '0', '1');";

                $stmt = $conn->prepare($sql);
                $stmt -> execute(
                    array(
                        ":chuong" => $this->chuong,
                        ":noidungchuong" => $this->noidungchuong,
                        ":dieu" => $this->dieu,
                        ":noidungdieu" => $this->noidungdieu,
                        ":khoan" => $this->khoan,
                        ":noidungkhoan" => $this->noidungkhoan
                    )
                );

                redirect("http://localhost:3000/index.php");
                $conn = null;
            } catch (PDOException $e) {
                echo "False" . $e;
            }
        }

        public function showLaw(){
            $options = array(PDO::ATTR_EMULATE_PREPARES, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
            $dsn = "mysql:host=".DBinfo::getServer().";dbname=".DBinfo::getDBname().";charset=utf8";
            $conn = new PDO($dsn,DBinfo::getUserName(),DBinfo::getPassword(),$options);

            $sql = "SELECT * FROM luat;";

            $stmt = $conn -> prepare($sql);
            $stmt->execute();
            $arr = array();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $law = new law();

                $law->chuong = $row['chuong'];
                $law->noidungchuong = $row['noidungchuong'];
                $law->dieu = $row['dieu'];
                $law->noidungdieu = $row['noidungdieu'];
                $law->khoan = $row['khoan'];
                $law->noidungkhoan = $row['noidungkhoan'];
                $law->muc =$row['muc'];
                $law->countdow = $row['countdown'];
                $law->flag = $row['flag'];

                array_push($arr, $law);
            }

            $conn = null;
            return $arr;
        }

        public function showLawInfo($lawID){
            $options = array(PDO::ATTR_EMULATE_PREPARES, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
            $dsn = "mysql:host=".DBinfo::getServer().";dbname=".DBinfo::getDBname().";charset=utf8";
            $conn = new PDO($dsn,DBinfo::getUserName(),DBinfo::getPassword(),$options);

            $sql = "SELECT * FROM luat WHERE dieu = $lawID;";

            $stmt = $conn -> prepare($sql);
            $stmt->execute();
            $arr = array();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $law = new law();

                $law->chuong = $row['chuong'];
                $law->noidungchuong = $row['noidungchuong'];
                $law->dieu = $row['dieu'];
                $law->noidungdieu = $row['noidungdieu'];
                $law->khoan = $row['khoan'];
                $law->noidungkhoan = $row['noidungkhoan'];
                $law->muc = $row['muc'];
                $law->countdow = $row['countdown'];
                $law->flag = $row['flag'];

                array_push($arr, $law);
            }

            $conn = null;
            return $arr;
        }

        public function showLawSearch($search){
            $options = array(PDO::ATTR_EMULATE_PREPARES, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
            $dsn = "mysql:host=".DBinfo::getServer().";dbname=".DBinfo::getDBname().";charset=utf8";
            $conn = new PDO($dsn,DBinfo::getUserName(),DBinfo::getPassword(),$options);

            $sql = "SELECT * FROM luat WHERE noidungkhoan LIKE '%$search%';";

            $stmt = $conn -> prepare($sql);
            $stmt->execute();
            $arr = array();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $law = new law();

                $law->chuong = $row['chuong'];
                $law->noidungchuong = $row['noidungchuong'];
                $law->dieu = $row['dieu'];
                $law->noidungdieu = $row['noidungdieu'];
                $law->khoan = $row['khoan'];
                $law->noidungkhoan = $row['noidungkhoan'];
                $law->flag = $row['flag'];

                array_push($arr, $law);
            }

            $conn = null;
            return $arr;
        }

        public function updateCountDownload($lawID, $newCount){
            try {
                $options = array(PDO::ATTR_EMULATE_PREPARES, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
                $dsn = "mysql:host=".DBinfo::getServer().";dbname=".DBinfo::getDBname().";charset=utf8";
                $conn = new PDO($dsn, DBinfo::getUserName(), DBinfo::getPassword(), $options);

                $sql = "UPDATE `luat` SET `countdown`=:newCount + 1 WHERE `dieu` = :lawID";
                $stmt = $conn->prepare($sql);
                $stmt->execute(
                    array(
                        ":newCount" => $newCount,
                        ":lawID" => $lawID
                    )
                );

                $conn = null;
            } catch (PDOException $e) {
                echo "False " . $e;
            }
        }

        public function getCountDownload(){
            $options = array(PDO::ATTR_EMULATE_PREPARES, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
            $dsn = "mysql:host=".DBinfo::getServer().";dbname=".DBinfo::getDBname().";charset=utf8";
            $conn = new PDO($dsn, DBinfo::getUserName(), DBinfo::getPassword(), $options);

            $sql = "SELECT * FROM luat GROUP BY countdown;";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $result = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $r = new law();

                $r->countdow = $row['countdown'];
                array_push($result, $r);
            }

            $conn = null;
            return $result;
        }
    }

    class customer{
        public $customerID;
        public $customerName;
        public $password;
        public $email;
        public $phone;
        public $address;
        public $type;
        public $flag;

        public function registerCustomer(){
            try {
                $options = array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
                $dsn = "mysql:host=".DBinfo::getServer().";dbname=".DBinfo::getDBname().";charset=utf8";
                $conn = new PDO($dsn,DBinfo::getUsername(), DBinfo::getPassword(),$options);
        
                $sql = "INSERT INTO `customers` (`customerid`, `customername`, `password`,`address`, `Phone`, `email`,`type`, `flag`) 
                        VALUES (:customerid, :customername, :password, :address, :Phone, :email,'customer', '1');";
                
                $stmt = $conn -> prepare($sql);
                $stmt -> execute(
                    array(
                        ":customerid" => $this->customerID,
                        ":customername" => $this->customerName,
                        ":password" => $this->password,
                        ":address" => $this->address,
                        ":Phone" => $this->phone,
                        ":email" => $this->email
                    )
                );
                // $stmt->bindParam(':customerid', $customerid);
                // $stmt->bindParam(':customername', $customername);
                // $stmt->bindParam(':password', $password);
                // $stmt->bindParam(':email', $email);
                // $stmt->bindParam(':Phone', $phone);
                // $stmt->bindParam(':address', $address);
                // $stmt->execute();
                redirect("http://localhost:3000/loginPage.php");
                $conn = null;
            } catch (PDOException $e) {
                echo "Error: " .$e->getMessage();
            }
        }

        public function checkCustomerID($customerid){
            try {
                $options = array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
                $dsn = "mysql:host=".DBinfo::getServer().";dbname=".DBinfo::getDBname().";charset=utf8";
                $conn = new PDO($dsn,DBinfo::getUsername(), DBinfo::getPassword(),$options);

                $sql = "SELECT * FROM `customers` WHERE `customerid`=:customerid;";

                $stmt = $conn -> prepare($sql);
                $stmt ->execute(
                    array(
                        ":customerid" => $customerid,
                    )
                );

                $result = array();
                while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
                    $customer = new customer();
                    $customer->customerID = $row["customerid"];

                    array_push($result, $customer);
                }
                $conn = null;
                return $result;
            } catch (PDOException $e) {
                echo "Erros ".$e->getMessage(); 
            }
        }

        public function checkLogin($customerid, $password){
            try {
                $options = array(PDO::ATTR_EMULATE_PREPARES=>false, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
                $dsn = "mysql:host=".DBinfo::getServer().";dbname=".DBinfo::getDBname().";charset=utf8";
                $conn = new PDO($dsn, DBinfo::getUsername(), DBinfo::getPassword(), $options);

                $sql = "SELECT * FROM `customers` WHERE `customerid`=:customerid AND `password`=:password;";

                $stmt =$conn->prepare($sql);
                $stmt->execute(
                    array(
                        ":customerid" => $customerid,
                        ":password" => $password
                    )
                );

                $result = array();
                while($row = $stmt -> fetchAll(PDO::FETCH_ASSOC)){
                    $customer = new customer();
                    $customer->customerID = $row["customerid"];
                    $customer->password = $row["password"];

                    array_push($result, $customer);
                }

                $conn = null;
                return $result;
            } catch (PDOException $e) {
                echo "Erros " . $e->getMessage();
            }
        }

        public function showCustomer(){
            try {
                $options = array(PDO::ATTR_EMULATE_PREPARES, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
                $dsn = "mysql:host=".DBinfo::getServer().";dbname=".DBinfo::getDBname().";charset=utf8";
                $conn = new PDO($dsn, DBinfo::getUserName(), DBinfo::getPassword(), $options);

                $sql = "SELECT * FROM `customers`";

                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $result = array();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $customer = new customer();

                    $customer->customerID = $row['customerid'];
                    $customer->customerName = $row['customername'];
                    $customer->password = $row['password'];
                    $customer->address = $row['address'];
                    $customer->phone = $row['Phone'];
                    $customer->email = $row['email'];
                    $customer->type = $row['type'];
                    $customer->flag = $row['flag'];

                    array_push($result, $customer);
                }

                $conn = null;
                return $result;
            } catch (PDOException $e) {
                echo "False to " . $e;
            }
        }

        public function checkAdmin($customerid, $password){
            try {
                $options = array(PDO::ATTR_EMULATE_PREPARES=>false, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
                $dsn = "mysql:host=".DBinfo::getServer().";dbname=".DBinfo::getDBname().";charset=utf8";
                $conn = new PDO($dsn, DBinfo::getUsername(), DBinfo::getPassword(), $options);

                $sql = "SELECT * FROM `customers` WHERE `customerid`=:customerid AND `password`=:password AND `type`='admin' AND `flag`='1'";

                $stmt = $conn -> prepare($sql);
                $stmt -> execute(
                    array(
                        ":customerid" => $customerid,
                        ":password" => $password
                    )
                );

                $result = array();
                while($row = $stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $customer = new customer();
                    $customer->customerID = $row["customerid"];
                    $customer->password = $row["password"];
                    $customer->type = $row['type'];

                    array_push($result, $customer);
                }

                $conn = null;
                return $result;
            } catch (PDOException $e) {
                echo "FALSE " . $e;
            }
        }

        public function showInfoCustomer($customerID){
            try {
                $options = array(PDO::ATTR_EMULATE_PREPARES, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
                $dsn = "mysql:host=" .DBinfo::getServer().";dbname=".DBinfo::getDBname().";charset=utf8";
                $conn = new PDO($dsn, DBinfo::getUserName(), DBinfo::getPassword(), $options);

                $sql = "SELECT * FROM `customers`WHERE `customerid` = :customerid";

                $stmt = $conn->prepare($sql);
                $stmt->execute(
                    array(
                        ":customerid" => $customerID
                    )
                );

                $result = array();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $customer = new customer();

                    $customer->customerID = $row['customerid'];
                    $customer->customerName = $row['customername'];
                    $customer->password = $row['password'];
                    $customer->address = $row['address'];
                    $customer->phone = $row['Phone'];
                    $customer->email = $row['email'];
                    $customer->type = $row['type'];
                    $customer->flag = $row['flag'];

                    array_push($result, $customer);
                }
                $conn = null;
                return $result;
            } catch (PDOException $e) {
                echo $e;
            }
        }

        public function showCustomerSearch($search){
            $options = array(PDO::ATTR_EMULATE_PREPARES, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
            $dsn = "mysql:host=".DBinfo::getServer().";dbname=".DBinfo::getDBname().";charset=utf8";
            $conn = new PDO($dsn,DBinfo::getUserName(),DBinfo::getPassword(),$options);

            $sql = "SELECT * FROM `customers` WHERE customername LIKE '%$search%';";

            $stmt = $conn -> prepare($sql);
            $stmt->execute();
            $arr = array();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $customerSearch = new customer();

                $customerSearch->customerID = $row['customerid'];
                $customerSearch->customerName = $row['customername'];
                $customerSearch->password = $row['password'];
                $customerSearch->address = $row['address'];
                $customerSearch->phone = $row['Phone'];
                $customerSearch->email = $row['email'];
                $customerSearch->type = $row['type'];
                $customerSearch->flag = $row['flag'];

                array_push($arr, $customerSearch);
            }

            $conn = null;
            return $arr;
        }
    }

    class comment{
        public $id;
        public $commentID;
        public $commentMessage;
        public $created;
        public $parentID;
        public $customerID;
        public $customerName;
        public $lawID;
        public $status;

        public function showCommentsWithLawID($lawID){
            try{
                $options = array(PDO::ATTR_EMULATE_PREPARES, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
                $dsn = "mysql:host=".DBinfo::getServer().";dbname=".DBinfo::getDBname().";charset=utf8";
                $conn = new PDO($dsn, DBinfo::getUserName(), DBinfo::getPassword(), $options);

                $sql = "SELECT * FROM comment_true INNER JOIN customers ON comment_true.customerID = customers.customerid WHERE comment_true.lawID=:lawID AND comment_true.status='1' ORDER BY comment_true.id DESC;";

                $stmt = $conn->prepare($sql);
                $stmt->execute(
                    array(
                        ":lawID" => $lawID
                    )
                );

                $result = array();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $comment = new comment();

                    $comment->commentMessage = $row['commentMessage'];
                    $comment->created = $row['created'];
                    $comment->parentID = $row['parentID'];
                    $comment->customerID = $row['customerID'];
                    $comment->customerName = $row['customername'];
                    $comment->lawID = $row['lawID'];
                    $comment->status = $row['status'];

                    array_push($result, $comment);
                }

                $conn = null;
                return $result;
            }catch(PDOException $e){
                echo "False ". $e;
            }
        }

        public function addNewComment($lawID){
            $options = array(PDO::ATTR_EMULATE_PREPARES=>false, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
            $dsn = "mysql:host=".DBinfo::getServer().";dbname=".DBinfo::getDBname().";charset=utf8";
            $conn = new PDO($dsn, DBinfo::getUserName(), DBinfo::getPassword(), $options);

            $date = new DateTime(null, new DateTimeZone("Asia/Ho_Chi_Minh"));
            $created = $date->format('Y-m-d H:i:s');

            $sql = "INSERT INTO `comment_true` (`commentID`, `commentMessage`, `created`, `parentID`, `customerID`, `lawID`, `status`) 
                    VALUES (0, :commentMessage, :created, 0, :customerID, :lawID, 1);";

            $stmt = $conn->prepare($sql);
            $stmt->execute(
                array(
                    ":commentMessage" => $this->commentMessage,
                    ":created" => $created,
                    ":customerID" => $this->customerID,
                    ":lawID" => $this->lawID,
                )
            );
            $conn = null;
        }

    }
?>