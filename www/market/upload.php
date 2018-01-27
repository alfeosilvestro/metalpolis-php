<?php
header('Content-Type: application/json');
	$date = date('YmdHis');
	if(isset($_FILES['file'])){
		if ( 0 < $_FILES['file']['error'] ) {
        //echo 'Error: ' . $_FILES['file']['error'] . '<br>';
				echo json_encode(array('status' => 'Error', 'message' =>$date .'_'. $_FILES['file']['error']));
    }
    else {
				$target = $_SERVER['DOCUMENT_ROOT'] . '/metalpolis_git/www/market/attachment/';
        move_uploaded_file($_FILES['file']['tmp_name'], $target.$date .'_'. $_FILES['file']['name']);
				echo json_encode(array('status' => 'Success', 'message' =>$date .'_'. $_FILES['file']['name']));
    }
	}
?>
