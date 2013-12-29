<?php
error_reporting(E_ALL);
require 'modules/classes/OrderConfirmation.class.php';
$content = array();
$content = array_merge($content,$_GET);
printConfirmation($content);
?>

<?php
function printConfirmation($content) {
	$pdf = new OrderConfirmation('L','mm','A4');
	$pdf->printOc($content);
	ob_end_clean();
	$pdf->Output ();
}
?>


