
		<div id="content">
			<div id="maincontent">
				
				<?php 
				/** Dummy query */
					$users = $shopdb->get_results('SELECT user_id FROM user');
					foreach($users as $user) {
						echo $user->user_id;
					}
				?>
				
			</div>
			<?php include('sidebar.php'); ?>
		</div>