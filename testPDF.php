<?php 
    require_once 'vendor/autoload.php';

    use Dompdf\Dompdf;
    use Dompdf\Options;
    
    // Khởi tạo đối tượng Dompdf
    $options = new Options();
    $options->set('isRemoteEnabled', true); // cho phép load font chữ từ xa
    $dompdf = new Dompdf($options);
    
    // Tạo mã HTML từ file HTML đã tạo ở bước trước đó
    $html = file_get_contents('configPDF.php');
    
    // Đưa mã HTML vào đối tượng Dompdf để tạo PDF
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    // Xuất tệp PDF ra màn hình hoặc lưu vào đĩa
    $dompdf->stream('my-pdf.pdf');
?>