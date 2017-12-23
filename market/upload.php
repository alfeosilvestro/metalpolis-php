<?php
	$date = date('YmdHis');
    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
        move_uploaded_file($_FILES['file']['tmp_name'], 'attachment/'.$date .'_'. $_FILES['file']['name']);
    }
	header('Content-Type: application/json');
	echo json_encode(array('status' => 'Success', 'message' =>$date .'_'. $_FILES['file']['name']));
?>