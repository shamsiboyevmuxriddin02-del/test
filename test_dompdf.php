<?php
require_once './lib/dompdf/vendor/autoload.php';
use Dompdf\Dompdf;

try {
    $dompdf = new Dompdf();
    $html = '<h1>Test PDF</h1><p>Bu Dompdf sinovi.</p>';
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("test.pdf", ['Attachment' => true]);
} catch (Exception $e) {
    echo 'Xatolik: ' . $e->getMessage();
}
?>