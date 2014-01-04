<?php
define ( 'FPDF_FONTPATH', 'modules/fpdf/font/' );
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
		$this->Cell ( 0, 11, $this->title, 0, 0, 'C' ); // width = 0, height = 10, text = title, boarder = 0, ln = 0, align = L, color = 0
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
	public function printOc($printInfo) {
		$this->AddPage ();
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 0, 10, 'Thank you for your order', 0, 1, 'L' );
		// Print the address the user entered in the Order Form.
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 0, 10, 'Delivery Address:', 0, 1, 'L' );
		$this->SetFont ( 'Arial', '', 10 );
		foreach ( $_SESSION ['user_info'] as $key => $value ) {
			$this->Cell ( 0, 4, "$value", 0, 1, 'L' );
		}
		
		// Simple separator
		$this->Ln ( 10 );
		
		$this->Line ( $this->GetX (), $this->GetY (), $this->GetX () + 190, $this->GetY () );
		
		// Print all details of the ordered Planets
		
		if ($_SESSION ['cart']) {
			foreach ( $_SESSION ['cart'] as $key => $value ) {
				$prod_info = getProductInformation ( $key ); // TODO: Fix this
				$this->SetFont ( 'Arial', 'B', 10 );
				$this->Cell ( 0, 10, 'Order Details:', 0, 1, 'L' );
				$this->SetFont ( 'Arial', '', 10 );
				$this->Cell ( 0, 5, "$prod_info->name", 0, 0, 'L' );
				$this->Cell ( 10, 5, "Pieces: $value", 0, 1, 'L' );
				$this->Cell ( 0, 5, "$prod_info->product_picture", 0, 1, 'L' );
				$this->Cell ( 0, 5, "$prod_info->product_description", 0, 1, 'L' );
				$this->Cell ( 0, 5, "$prod_info->price", 0, 1, 'L' );
				$this->Ln ( 10 );
				$this->Line ( $this->GetX (), $this->GetY (), $this->GetX () + 190, $this->GetY () );
			}
		}
		
		if ($_SESSION ['buy_now_prod_id']) {
			$prod_info = getProductInformation ( $_SESSION ['buy_now_prod_id'] ); // TODO: Fix this
			$this->SetFont ( 'Arial', 'B', 10 );
			$this->Cell ( 0, 10, 'Order Details:', 0, 1, 'L' );
			$this->SetFont ( 'Arial', '', 10 );
			$this->Cell ( 0, 5, "$prod_info->name", 0, 1, 'L' );
			$this->Cell ( 0, 5, "$prod_info->product_picture", 0, 1, 'L' );
			$this->Cell ( 0, 5, "$prod_info->product_description", 0, 1, 'L' );
			$this->Cell ( 0, 5, "$prod_info->price", 0, 1, 'L' );
		}
	}
}

?>