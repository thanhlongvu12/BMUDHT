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
$html = '<h1>Xin Chào chương</h1>';
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
$html = '<div class="container" id="content"><div class="content">'.nl2br($html).'</div></div>';
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
</style>';

// Đưa mã HTML và CSS vào đối tượng Dompdf để tạo PDF
$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
$dompdf->loadHtml($css . $html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

// Xuất tệp PDF ra màn hình hoặc lưu vào đĩa
$dompdf->stream('law.pdf');
?>
