<?php
header('Content-Type: application/json');
	$date = date('YmdHis');
	if(isset($_FILES['file'])){
		if ( 0 < $_FILES['file']['error'] ) {
        //echo 'Error: ' . $_FILES['file']['error'] . '<br>';
				echo json_encode(array('status' => 'Error', 'message' =>$date .'_'. $_FILES['file']['error']));
    }
    else {
				//$target = $_SERVER['DOCUMENT_ROOT'] . '/metalpolis_git/www/market/attachment/';				
				$target = $_SERVER['DOCUMENT_ROOT'] . "/market/attachment/";				

				if (!file_exists($target)) {
					echo json_encode(array('status' => 'Director Error', 'path' => $target, 'error' => 'folder not exists'));
						return;
				}

				try{

					move_uploaded_file($_FILES['file']['tmp_name'], $target.$date .'_'. $_FILES['file']['name']);
				
				}catch(Exception $e){
					echo json_encode(array('status' => 'Upload Fail', 'message' =>$date .'_'. $_FILES['file']['name'], 'path' => $target, 'error' => $e->getMessage()));
					return;
				}

				echo json_encode(array('status' => 'Success', 'message' =>$date .'_'. $_FILES['file']['name'], 'path' => $target));
    }
	}
?>
