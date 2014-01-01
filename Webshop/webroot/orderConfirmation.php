<?php
error_reporting(E_ALL);
require 'modules/classes/OrderConfirmation.class.php';
$content = array();
$content = array_merge($content,$_GET);
printConfirmation();
?>

<?php
function printConfirmation() {
	$pdf = new OrderConfirmation('P','mm','A4');
	$pdf->printOc();
	ob_end_clean();
	$pdf->Output ();
}
?>


