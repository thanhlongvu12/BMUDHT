<?php
include('./law.php');
require_once 'vendor/autoload.php';


use Dompdf\Dompdf;
use Dompdf\Options;

// Khởi tạo đối tượng Dompdf
$options = new Options();
$options->set('defaultFont', 'dejaVuSans-Bold');
$dompdf = new Dompdf($options);

// Lấy dữ liệu từ cơ sở dữ liệu
$idDieu = $_GET['lawID'];
$lawInfo = new law();
$result = $lawInfo->showLawInfo($idDieu);
$isFlag = true;
$html = '
        <div class="container">
            <div class="header-title">
                <div class="left-title">
                    <p>QUỐC HỘI</p>
                    <p>--------</p>
                </div>
                <div class="right-title">
                    <p>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</p>
                    <p>Độc lập - Tự do - Hạnh phúc</p>
                    <p>---------------</p>
                </div>
            </div>
            <div class="header-title two">
                <div class="left-title">
                    <p class="main-title-header">Luật số: 24/2018/QH14</p>
                </div>
                <div class="right-title">
                    <p class="main-title-header">Hà Nội, ngày 12 tháng 6 năm 2018</p>
                </div>
            </div>

            <div class="body-title">
                <div class="title-top-body">
                    <h2>LUẬT</h2>
                    <h2>AN NINH MẠNG</h2>
                </div>
                <div class="cancu">
                    <p>Căn cứ Hiến pháp nước Cộng hòa xã hội chủ nghĩa Việt Nam;</p>
                    <p>Quốc hội ban hành Luật An ninh mạng.</p>
                </div>
            </div>   
        </div>
';
for($i=0; $i<count($result); $i++){
    $s = $result[$i];
    if($isFlag){
        $html .= '
            <h2">Chương: <span>'.$s->chuong.'</span></h2>
            <h3>Noi Dung Chuong: <span>'.$s->noidungchuong.'</span></h3>
            <h2>Dieu: <span>'.$s->dieu.'</span></h2>
            <h3>Noi Dung Dieu: <span>'.$s->noidungdieu.'</span></h3>
        ';
        $isFlag=false;
    }
    $html .= '
        <h2>Khoan: <span>'.$s->khoan.'</span></h2>
        <h4>Noi Dung Khoan: <span>'.$s->noidungkhoan.'</span></h4>
    ';
}

// Tạo mã HTML và CSS
// $html = '<div class="container" id="content"><div class="content">'.nl2br($html).'</div></div>';
$css = '
<style>
    *{ 
        font-family: DejaVu Sans; font-size: 1rem;
    }
    #content {
        font-family: Arial, sans-serif;
        font-size: 12pt;
    }
    strong {
        font-weight: bold;
    }
    em {
        font-style: italic;
    }
    ul {
        list-style-type: square;
    }
    ol {
        list-style-type: decimal;
    }
    
    .container .header-title{
        display: flex;
        text-align: center;
    }
    
    .container .header-title p{
        margin-top: 0.5rem;
    }
    
    .container .header-title .main-title-header{
        top: 10rem;
    }
    
    .container .header-title.two{
        margin-top: 2rem;
        margin-left: -3rem;
    }
    
    .body-title .title-top-body{
        margin-top: 4.5rem;
        text-align: center;
    }
    
    .body-title .title-top-body h2{
        margin: 1rem 0;
    }
    
    .body-title .cancu p{
        margin: .5rem 0;
    }
</style>';

// Đưa mã HTML và CSS vào đối tượng Dompdf để tạo PDF
$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
$dompdf->loadHtml($css . $html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

// Xuất tệp PDF ra màn hình hoặc lưu vào đĩa
$dompdf->stream('law.pdf');
?>
