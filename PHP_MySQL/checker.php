<?php 
	require_once ('db.php'); 
	$db = new db();

	//set initial value of update to false
	$data['update'] = false;
	//get counter from database
	$data['current'] = (int)$db->check_changes();
	// if the current counter is different from database
	if(isset($_POST) && !empty($_POST['counter']) && (int)$_POST['counter']!=$data['current']){
		// get new click info
		$data['click'] = $db->get_clicks();
		$data['update'] = true;
	}

	echo json_encode($data);
/* End of file checker.php */
