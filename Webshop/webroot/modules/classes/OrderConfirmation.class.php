<?php
define ( 'FPDF_FONTPATH', '/usr/share/php/fpdf/font/' );
// require ('fpdf.php');
class OrderConfirmation extends FPDF {
	public $title = "Order Confirmation";
	
	/**
	 * function to print the header of the document
	 *
	 * @see FPDF::Footer()
	 */
	public function Header() {
		$this->SetXY ( $this->lMargin, 5, $this->tMargin, 5 );
		$this->Image ( '../doc/ci/logo-black.png', $this->lMargin, 5, 40, 10 );
		$this->SetFont ( 'Arial', 'B', 11 );
		$this->Cell ( 0, 11, $this->title, 0, 0, C ); // width = 0, height = 10, text = title, boarder = 0, ln = 0, align = L, color = 0
		$this->SetXY ( $this->lMargin, $this->GetY () + 20 );
	}
	
	/**
	 * function to print the footer of the document
	 *
	 * @see FPDF::Footer()
	 */
	public function Footer() {
		$this->SetXY ( 10, - 15 );
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 0, 10, 'Page ' . $this->PageNo (), 0, 0, 'C' );
	}
	
	/**
	 * function to print the Order confirmation
	 *
	 * @param array $content        	
	 */
	public function printOc($content) {
		$this->AddPage ();
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 0, 10, 'Thank you for your order', 0, 1, 'L' );
		foreach ( $content as $key => $value ) 

		{
			$this->Cell ( 0, 10, "Array key $key - array value $value", 0, 1, 'L' );
		}
	}
	
	private function getProduct() {
		foreach ( $content as $key => $value ) {
			if ($key == 'product_id') {
				
				$product_id = $shopdb->escape ( $key->$value );
				$query = sprintf ( "SELECT product_id, name, product_picture, price, inventory_quantity FROM product WHERE product_id=%s", $product_id );
				$product_info = $shopdb->get_row ( $query );
			}
		}
	}
}

?>