<?php 
    include('./law.php')
    // include('.law.php')?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- link icon -->
    <script src="https://kit.fontawesome.com/83128b721a.js" crossorigin="anonymous"></script>
</head>
<body>
    <h1>Law</h1>
    <div class="container">
        <div class="optionsLaw">
            <a href="">Add new</a>
        </div>
        <div class="showLaw">
            <div class="search">
                <form action="" method="get">
                    <input type="text" name="searchbox" id="" value="<?php if(!empty($_GET['searchbox'])){echo $_GET['searchbox'];}?>">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            <div class="content">
            <?php
                if(isset($_GET['searchbox'])){
                    $search = $_GET['searchbox'];
                    $law = new law();
                    $result = $law->showLawSearch($search);
                    for ($i=0; $i<count($result); $i++){
                        $s = $result[$i];
                        echo '
                        <div class="law">
                            <a href="./infoLaw.php?lawID='.$s->dieu.'">
                                <p>'.$s->noidungkhoan.'</p>
                            </a>
                        </div>';
                    }
                }else{
                    $law = new law();
                    $result = $law->showLaw();
                    for ($i=0; $i<count($result); $i++){
                        $s = $result[$i];
                        echo '
                        <div class="law">
                            <a href="./infoLaw.php?lawID='.$s->dieu.'">
                                <p>'.$s->noidungkhoan.'</p>
                            </a>
                        </div>';
                    }
                }
            ?>
            </div>
        </div>
            <?php

            ?>
        </div>
    </div>
</body>
</html>