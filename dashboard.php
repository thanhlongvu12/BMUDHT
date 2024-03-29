<?php 
    include('./law.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://kit.fontawesome.com/83128b721a.css" crossorigin="anonymous">
	<!-- My CSS -->
	<link rel="stylesheet" href="./admin/styleDB.css">

	<title>AdminHub</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="./dashboard.php" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">AdminHub</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="#">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Analytics</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">Message</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-group' ></i>
					<span class="text">Team</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="#">
					<i class='bx bxs-cog' ></i>
					<span class="text">Settings</span>
				</a>
			</li>
			<li>
				<a href="#" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<form action="" method="get">
				<div class="form-input">
					<input type="text" placeholder="Search..." name="searchbox" value="<?php if(!empty($_GET['searchbox'])){echo $_GET['searchbox'];}?>">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="#" class="profile">
                <i class="fa-solid fa-user"></i>
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
        <?php 
            $law = new law();
            $resultLaw = $law->showLaw();
            $customer = new customer();
            $resultCustomer = $customer->showCustomer();
			$countDownload = new law();
			$retultCountDownload = $countDownload->getCountDownload();
        ?>
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
			</div>

			<ul class="box-info">
				<li>
					<a href="">
                        <i class='bx bxs-group' ></i>
                        <span class="text">
                            <h3><?php echo count($resultCustomer)?></h3>
                            <p>Số người đăng ký</p>
                        </span>
                    </a>
				</li>
				<li>
					<a href="./addNewLaw.php">
                        <i class='bx bxs-calendar-check' ></i>
                        <span class="text">
                            <h3><?php echo count($resultLaw)?></h3>
                            <p>Tổng số luật</p>
                        </span>
                    </a>
				</li>
				<li>
					<a href="">
                        <i class='bx bxs-dollar-circle' ></i>
                        <span class="text">
							<?php 
								$total = 0;
								for($i=0; $i<count($retultCountDownload); $i++){
									$r = $retultCountDownload[$i];

									$total += $r->countdow;
								}
							?>
                            <h3><?php echo $total?></h3>
                            <p>Số luật tải về</p>
                        </span>
                    </a>
				</li>
			</ul>


			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Người dùng</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<table>
						<thead>
							<tr>
								<th>Customer</th>
								<th>Date Comment</th>
								<th>Positon</th>
							</tr>
						</thead>
						<tbody>
                            <?php 
								if(isset($_GET['searchbox'])){
									$search = $_GET['searchbox'];
									$customerSearch = new customer();
									$resultSearch = $customerSearch->showCustomerSearch($search);
									for($i=0; $i<count($resultSearch); $i++){
										$r = $resultSearch[$i];

										echo'
											<tr>
												<td>
													<i class="fa-solid fa-user"></i>
													<a href="./customerContro.php?customerid='.$r->customerID.'">
														<p>'.$r->customerID.'</p>
													</a>
												</td>
												<td>'.$r->customerName.'</td>
												<td><span class="status '.$r->type.'">'.$r->type.'</span></td>
											</tr>
										';
									}
								}else{
									for($i=0; $i<count($resultCustomer); $i++){
										$r = $resultCustomer[$i];
										
										echo '
											<tr>
												<td>
													<i class="fa-solid fa-user"></i>
													<a href="./customerContro.php?customerid='.$r->customerID.'">
														<p>'.$r->customerID.'</p>
													</a>
												</td>
												<td>'.$r->customerName.'</td>
												<td><span class="status '.$r->type.'">'.$r->type.'</span></td>
											</tr>
										';
									}
								}
                            ?>
						</tbody>
					</table>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="./admin/scriptDB.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/83128b721a.js" crossorigin="anonymous"></script>
</body>
</html>