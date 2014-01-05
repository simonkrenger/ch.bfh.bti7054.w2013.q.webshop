<?php

/**
 * Standalone class to print PDF
 */

// This is somehow necessary to represent the fonts
define ( 'FPDF_FONTPATH', 'modules/fpdf/font/' );

// Standalone, include functions.php
include_once('modules/functions.php');

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
	public function printOc($order_id) {
		$this->AddPage ();
		$this->SetFont ( 'Arial', '', 10 );

		
		// Print the address the user entered in the Order Form.
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 0, 10, 'Delivery Address:', 0, 1, 'L' );
		$this->SetFont ( 'Arial', '', 10 );
		$this->pdf_print_address($order_id);
		
		// Simple separator
		$this->Ln ( 10 );
		$this->Line ( $this->GetX (), $this->GetY (), $this->GetX () + 190, $this->GetY () );
		
		// Print all details of the ordered Planets
		
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 0, 10, 'Order Details:', 0, 1, 'L' );
		$this->SetFont ( 'Arial', '', 10 );
		
		$this->pdf_print_order($order_id);
		
		$this->Cell ( 0, 10, "Thank you for your order!", 0, 1, 'L' );
	}
	
	private function pdf_print_address($order_id) {
		global $shopdb;
		global $shopuser;

		$address_id = $shopdb->get_var(sprintf("SELECT shipping_address FROM `order` WHERE order_id=%s", $shopdb->escape($order_id)));
		
		$query = sprintf("SELECT a.street, a.zipcode, a.city, a.country, p.name AS pname, g.name AS gname FROM address a JOIN planet p ON a.planet_id = p.planet_id JOIN galaxy g ON a.galaxy_id = g.galaxy_id WHERE a.address_id=%s LIMIT 1", $address_id);
		$address = $shopdb->get_row($query);
		
		$this->Cell ( 0, 4, "First Name, Last Name: $shopuser->first_name, $shopuser->last_name", 0, 1, 'L' );
		$this->Cell ( 0, 4, "Street: $address->street", 0, 1, 'L' );
		$this->Cell ( 0, 4, "Postal code: $address->zipcode", 0, 1, 'L' );
		$this->Cell ( 0, 4, "City: $address->city", 0, 1, 'L' );
		$this->Cell ( 0, 4, "Country: $address->country", 0, 1, 'L' );
		$this->Cell ( 0, 4, "Planet: $address->pname", 0, 1, 'L' );
		$this->Cell ( 0, 4, "Galaxy: $address->gname", 0, 1, 'L' );
	}
	
	private function pdf_print_order($order_id) {
		global $shopdb;
		
		$query = sprintf("SELECT o.order_id, o.order_date, o.shipping_date, o.shipping_address, u.first_name, u.last_name FROM `order` o JOIN user u ON o.customer_id = u.user_id WHERE o.order_id=%s", $order_id);
		$order_attributes = $shopdb->get_row($query);
		
		$this->Cell ( 0, 4, "Order ID: $order_attributes->order_id", 0, 1, 'L' );
		$this->Cell ( 0, 4, "Order Date: $order_attributes->order_date", 0, 1, 'L' );
		$this->Cell ( 0, 4, "Shipping Date: $order_attributes->shipping_date", 0, 1, 'L' );
		$this->Cell ( 0, 4, "Name on address: $order_attributes->first_name $order_attributes->last_name", 0, 1, 'L' );
		
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 0, 10, 'Order Positions:', 0, 1, 'L' );
		$this->SetFont ( 'Arial', '', 10 );
		
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell( 20 ,5 ,'Quantity' ,1 ,0 , 'L', 0);
		$this->Cell( 140 ,5 ,'Product' ,1 ,0 , 'L', 0);
		$this->Cell( 30 ,5 ,'Price' ,1 ,0 , 'L', 0);
		$this->Ln();
		$this->SetFont ( 'Arial', '', 10 );
		
		$query = sprintf("SELECT od.quantity, od.product_id, p.name, p.price FROM order_detail od JOIN product p ON od.product_id = p.product_id WHERE od.order_id=%s;",
				$order_attributes->order_id);
		$order_positions = $shopdb->get_results($query);
		
		$total_price = 0;
		foreach($order_positions as $position) {
			$p = new ShopProduct($position->product_id);
			
			$this->Cell( 20 ,5 ,"$position->quantity" ,'LR' ,0 , 'L', 0);
			
			$this->SetFont ( 'Arial', 'B', 10 );
			$this->Cell( 140 ,5 ,"$position->name" ,'LR' ,0 , 'L', 0);
			$this->SetFont ( 'Arial', '', 10 );
			$this->Cell( 30 ,5 ,"" ,'LR' ,0 , 'L', 0);
			$this->Ln();
	
			// Here, get the custom attributes
			$query = sprintf("SELECT attribute_id, attribute_value FROM order_detail_attributes WHERE order_id=%s AND product_id=%s",
			$order_attributes->order_id, $position->product_id);
			$custom_attributes = $shopdb->get_results($query);
			if($custom_attributes != NULL) {
				
				$this->Cell( 20 ,5 ,"" ,'LR' ,0 , 'L', 0);
				$this->Cell( 140 ,5 ,"You chose the following custom attributes:" ,'LR' ,0 , 'L', 0);
				$this->Cell( 30 ,5 ,"" ,'LR' ,0 , 'L', 0);
				$this->Ln();
				foreach($custom_attributes as $attribute) {
					
					$attribute_name = $p->getAttributeNameForId($attribute->attribute_id);
					$attribute_value = urldecode($attribute->attribute_value);
					$this->Cell( 20 ,5 ,"" ,'LR' ,0 , 'L', 0);
					$this->Cell( 140 ,5 ,"- $attribute_name: $attribute_value" ,'LR' ,0 , 'L', 0);
					$this->Cell( 30 ,5 ,"" ,'LR' ,0 , 'L', 0);
					$this->Ln();
				}
			} else {
				$this->Cell( 20 ,5 ,"" ,'LR' ,0 , 'L', 0);
				$this->Cell( 140 ,5 ,"Product has no custom attributes" ,'LR' ,0 , 'L', 0);
				$this->Cell( 30 ,5 ,"" ,'LR' ,0 , 'L', 0);
				$this->Ln();
			}
		
		$position_price = $position->quantity * $position->price;
		$total_price += $position_price;
		
		$this->Cell( 20 ,5 ,"" ,'LRB' ,0 , 'L', 0);
		$this->Cell( 140 ,5 ,"" ,'LRB' ,0 , 'L', 0);
		$this->Cell( 30 ,5 ,"$position_price" ,'LRB' ,0 , 'R', 0);
		$this->Ln();
		}
		
		$this->Cell( 20 ,5 ,"Total price" ,0 ,0 , 'L', 0);
		$this->Cell( 140 ,5 ,"" ,0 ,0 , 'L', 0);
		$this->Cell( 30 ,5 ,"$total_price" ,'B' ,0 , 'R', 0);
		$this->Ln();

		$this->Ln ( 10 );
		$this->Line ( $this->GetX (), $this->GetY (), $this->GetX () + 190, $this->GetY () );
	}
}

?>