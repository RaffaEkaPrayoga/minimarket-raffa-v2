<?php
require '../vendor/autoload.php';

if (isset($_POST["chart_data"])) {
    $chartData = $_POST["chart_data"];

    $mpdf = new \Mpdf\Mpdf();
    $html = '<h1 style="margin-left: 10.5rem; margin-bottom: 5rem;">Data Pembelian Pelanggan</h1>';
    $html .= '<img src="' . $chartData . '">';

    $mpdf->WriteHTML($html);
    $mpdf->Output('chart.pdf', \Mpdf\Output\Destination::INLINE);
}
