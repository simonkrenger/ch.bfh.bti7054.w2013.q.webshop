<form class="form" name="registrationForm" id="registrationForm" action="<?php echo get_href("sendReg"); ?>" method="post"
	onsubmit="submitForm()" onreset="resetForm()">
	
	

<div class="form">

		<?php

		echo "<div class=\"formField\"> 
		<label for =\"firstname\">" . get_translation("FORM_REG_FIRSTNAME") . "</label>
		<input type=\"text\" name=\"firstname\" size=\"50\" maxlength=\"100\" id=\"firstname\" placeholder =\"" . get_translation("FORM_REG_FIRSTNAME") . "\" ></input></div>";
		
		echo "<label for =\"lastname\">" . get_translation("FORM_REG_LASTNAME") . "</label>
		<input type=\"text\" name=\"lastname\" size=\"50\" maxlength=\"100\" id=\"lastname\" placeholder =\"" . get_translation("FORM_REG_LASTNAME") . "\" ></input></div>";

		echo "<label for =\"street\">" . get_translation("FORM_REG_STREET") . "</label>
		<input type=\"text\" name=\"street\" size=\"50\" maxlength=\"100\" id=\"street\" placeholder =\"" . get_translation("FORM_REG_STREET") . "\" ></input></div>";
		
		echo "<label for =\"nr\">" . get_translation("FORM_REG_NR") . "</label>
		<input type=\"number\" name=\"nr\" size=\"5\" maxlength=\"10\" id=\"nr\" placeholder =\"" . get_translation("FORM_REG_NR") . "\" ></input></div>";
		
		echo "<label for =\"ac\">" . get_translation("FORM_REG_AREACODE") . "</label>
		<input type=\"number\" name=\"ac\" size=\"5\" maxlength=\"20\" id=\"ac\" placeholder =\"" . get_translation("FORM_REG_AREACODE") . "\" ></input></div>";

		echo "<label for =\"city\">" . get_translation("FORM_REG_CITY") . "</label>
		<input type=\"text\" name=\"city\" size=\"50\" maxlength=\"100\" id=\"city\" placeholder =\"" . get_translation("FORM_REG_CITY") . "\" ></input></div>";
		
		echo "<label for =\"ct\">" . get_translation("FORM_REG_COUNTRY") . "</label>
		<input type=\"text\" name=\"ct\" size=\"50\" maxlength=\"100\" id=\"ct\" placeholder =\"" . get_translation("FORM_REG_COUNTRY") . "\" ></input></div>";
		
		echo "<label for =\"pt\">" . get_translation("FORM_REG_PLANET") . "</label>
		<input type=\"text\" name=\"pt\" size=\"50\" maxlength=\"100\" id=\"pt\" placeholder =\"" . get_translation("FORM_REG_PLANET") . "\" ></input></div>";
		
		echo "<label for =\"gx\">" . get_translation("FORM_REG_GALAXY") . "</label>
		<input type=\"text\" name=\"gx\" size=\"50\" maxlength=\"100\" id=\"gx\" placeholder =\"" . get_translation("FORM_REG_GALAXY") . "\" ></input></div>";
		
		echo "<label for =\"mail\">" . get_translation("FORM_REG_EMAIL") . "</label>
		<input type=\"email\" name=\"mail\" size=\"50\" maxlength=\"100\" id=\"mail\" placeholder =\"" . get_translation("FORM_REG_EMAIL") . "\" ></input></div>";
		
		echo "<label for =\"phone\">" . get_translation("FORM_REG_PHONE") . "</label>
		<input type=\"tel\" name=\"phone\" size=\"50\" maxlength=\"100\" id=\"phone\" placeholder =\"" . get_translation("FORM_REG_PHONE") . "\" ></input></div>";
		
		echo "<label for =\"bd\">" . get_translation("FORM_REG_BIRTHDATE") . "</label>
		<input type=\"date\" name=\"bd\" size=\"50\" maxlength=\"100\" id=\"bd\" placeholder =\"" . get_translation("FORM_REG_BIRTHDATE") . "\" ></input></div>";
		
		echo "<label for =\"usr\">" . get_translation("FORM_REG_USER") . "</label>
		<input type=\"text\" name=\"usr\" size=\"50\" maxlength=\"100\" id=\"usr\" placeholder =\"" . get_translation("FORM_REG_USER") . "\" ></input></div>";
		
		echo "<label for =\"pwd\">" . get_translation("FORM_REG_PASS") . "</label>
		<input type=\"password\" name=\"pwd\" size=\"50\" maxlength=\"100\" id=\"pwd\" placeholder =\"" . get_translation("FORM_REG_PASS") . "\" ></input></div>";
				
		?>
	
		<div>
			<input type="button" name="submitted" value="<?php get_translation("FORM_REG_REG")?>" onclick="verifyForm()"/>
		</div>
</div>
</form>

