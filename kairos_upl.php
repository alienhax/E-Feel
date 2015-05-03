<?php 
error_reporting(E_ALL);
session_start();
require_once('Kairos-SDK-PHP-master/Kairos.php');

$app_id  = '917bb4dc';
$api_key = '38b90fc66a94e16edc7854e7f12540d7';
$Kairos  = new Kairos($app_id, $api_key);

$str_to_time = strtotime('now');
$str_to_time2 = $str_to_time + 1;
$str_to_time3 = $str_to_time2 + 1;
$str_to_time4 = $str_to_time3 + 1;
$str_to_time5 = $str_to_time4 + 1;

$subject_id = "subject{$str_to_time}";
$subject_id2 = "subject{$str_to_time2}";
$subject_id3 = "subject{$str_to_time3}";
$subject_id4 = "subject{$str_to_time4}";
$subject_id5 = "subject{$str_to_time5}";

$gallery_id = "gallery1";

$arr_errors = array();
$arr_enroll_subj_ids = array();
$arr_matched_subj_ids = array();
		
//upload file, determine if previous match exists
if($_FILES['file_img1']['tmp_name'] != '') {
	
	$str_target_path = '/home/e-feel/e-feel.club/uploaded_images/';
	//$str_target_path = $str_target_path . $_FILES['file_img1']['name']; 
	$str_target_path = "{$str_target_path}{$subject_id}.jpg";

	if(move_uploaded_file($_FILES['file_img1']['tmp_name'], $str_target_path)) {
		//do api recognize
		$obj_recognize = json_decode($Kairos->recognizeImageWithPath($str_target_path, $gallery_id));

		//do detect
		if($obj_recognize->images[0]->transaction->status == 'failure'){
			//no match, enroll
			$obj_enroll = json_decode($Kairos->enrollImageWithPath($str_target_path, $gallery_id, $subject_id));
			foreach ($obj_enroll->images as $key => $value) {
				array_push($arr_enroll_subj_ids, $value->transaction->subject_id);
			}
		} else{
			//match found, include in results
			//TEST remove
			array_push($arr_matched_subj_ids, $obj_recognize->images[0]->transaction->subject);
			//enroll anyway 
			$obj_enroll = json_decode($Kairos->enrollImageWithPath($str_target_path, $gallery_id, $subject_id));
			foreach ($obj_enroll->images as $key => $value) {
				array_push($arr_enroll_subj_ids, $value->transaction->subject_id);
			}
		}
		
	} else {
		array_push($arr_errors, "{$_FILES['file_img1']} could not be uploaded.");
	}

}


if($_FILES['file_img2']['tmp_name'] != '') {
	
	$str_target_path = '/home/e-feel/e-feel.club/uploaded_images/';
	//$str_target_path = $str_target_path . $_FILES['file_img1']['name']; 
	$str_target_path = "{$str_target_path}{$subject_id2}.jpg";

	if(move_uploaded_file($_FILES['file_img2']['tmp_name'], $str_target_path)) {
		//do api recognize
		$obj_recognize = json_decode($Kairos->recognizeImageWithPath($str_target_path, $gallery_id));
		//var_dump($obj_recognize->images[0]->transaction);

		//do detect
		if($obj_recognize->images[0]->transaction->status == 'failure'){
			//no match, enroll
			$obj_enroll = json_decode($Kairos->enrollImageWithPath($str_target_path, $gallery_id, $subject_id2));
			foreach ($obj_enroll->images as $key => $value) {
				array_push($arr_enroll_subj_ids, $value->transaction->subject_id);
			}
		} else{
			//match found, include in results
			//TEST remove
			$obj_remove = $Kairos->removeSubjectFromGallery($obj_recognize->images[0]->transaction->subject, $gallery_id);
			array_push($arr_matched_subj_ids, $obj_recognize->images[0]->transaction->subject);
			//enroll anyway
			$obj_enroll = json_decode($Kairos->enrollImageWithPath($str_target_path, $gallery_id, $subject_id2));
			foreach ($obj_enroll->images as $key => $value) {
				array_push($arr_enroll_subj_ids, $value->transaction->subject_id);
			}
		}
		
	} else {
		array_push($arr_errors, "{$_FILES['file_img2']} could not be uploaded.");
	}

}		


if($_FILES['file_img3']['tmp_name'] != '') {
	
	$str_target_path = '/home/e-feel/e-feel.club/uploaded_images/';
	//$str_target_path = $str_target_path . $_FILES['file_img1']['name']; 
	$str_target_path = "{$str_target_path}{$subject_id3}.jpg";

	if(move_uploaded_file($_FILES['file_img3']['tmp_name'], $str_target_path)) {
		//do api recognize
		$obj_recognize = json_decode($Kairos->recognizeImageWithPath($str_target_path, $gallery_id));

		//do detect
		if($obj_recognize->images[0]->transaction->status == 'failure'){
			//no match, enroll
			$obj_enroll = json_decode($Kairos->enrollImageWithPath($str_target_path, $gallery_id, $subject_id3));
			foreach ($obj_enroll->images as $key => $value) {
				array_push($arr_enroll_subj_ids, $value->transaction->subject_id);
			}
		} else{
			//match found, include in results
			//TEST remove
			array_push($arr_matched_subj_ids, $obj_recognize->images[0]->transaction->subject);
			var_dump($arr_matched_subj_ids);
			die('XX_XX');
			//enroll anyway
			$obj_enroll = json_decode($Kairos->enrollImageWithPath($str_target_path, $gallery_id, $subject_id3));
			foreach ($obj_enroll->images as $key => $value) {
				array_push($arr_enroll_subj_ids, $value->transaction->subject_id);
			}
		}
		
	} else {
		array_push($arr_errors, "{$_FILES['file_img3']} could not be uploaded.");
	}

}


if($_FILES['file_img4']['tmp_name'] != '') {
	
	$str_target_path = '/home/e-feel/e-feel.club/uploaded_images/';
	//$str_target_path = $str_target_path . $_FILES['file_img1']['name']; 
	$str_target_path = "{$str_target_path}{$subject_id4}.jpg";

	if(move_uploaded_file($_FILES['file_img4']['tmp_name'], $str_target_path)) {
		//do api recognize
		$obj_recognize = json_decode($Kairos->recognizeImageWithPath($str_target_path, $gallery_id));
		//do detect
		if($obj_recognize->images[0]->transaction->status == 'failure'){
			//no match, enroll
			$obj_enroll = json_decode($Kairos->enrollImageWithPath($str_target_path, $gallery_id, $subject_id4));
			foreach ($obj_enroll->images as $key => $value) {
				array_push($arr_enroll_subj_ids, $value->transaction->subject_id);
			}
		} else{
			//match found, include in results
			//TEST remove
			array_push($arr_matched_subj_ids, $obj_recognize->images[0]->transaction->subject);
			//enroll anyway
			$obj_enroll = json_decode($Kairos->enrollImageWithPath($str_target_path, $gallery_id, $subject_id4));
			foreach ($obj_enroll->images as $key => $value) {
				array_push($arr_enroll_subj_ids, $value->transaction->subject_id);
			}
		}
		
	} else {
		array_push($arr_errors, "{$_FILES['file_img4']} could not be uploaded.");
	}

}


if($_FILES['file_img5']['tmp_name'] != '') {
	
	$str_target_path = '/home/e-feel/e-feel.club/uploaded_images/';
	//$str_target_path = $str_target_path . $_FILES['file_img1']['name']; 
	$str_target_path = "{$str_target_path}{$subject_id5}.jpg";

	if(move_uploaded_file($_FILES['file_img5']['tmp_name'], $str_target_path)) {
		//do api recognize
		$obj_recognize = json_decode($Kairos->recognizeImageWithPath($str_target_path, $gallery_id));
		//var_dump($obj_recognize->images[0]->transaction);

		//do detect
		if($obj_recognize->images[0]->transaction->status == 'failure'){
			//no match, enroll
			$obj_enroll = json_decode($Kairos->enrollImageWithPath($str_target_path, $gallery_id, $subject_id5));
			foreach ($obj_enroll->images as $key => $value) {
				array_push($arr_enroll_subj_ids, $value->transaction->subject_id);
			}
		} else{
			//match found, include in results
			//TEST remove
			array_push($arr_matched_subj_ids, $obj_recognize->images[0]->transaction->subject);
			//enroll anyway
			$obj_enroll = json_decode($Kairos->enrollImageWithPath($str_target_path, $gallery_id, $subject_id5));
			foreach ($obj_enroll->images as $key => $value) {
				array_push($arr_enroll_subj_ids, $value->transaction->subject_id);
			}
		}
		
	} else {
		array_push($arr_errors, "{$_FILES['file_img5']} could not be uploaded.");
	}

}

//MP3
if($_FILES['file_mp3']['tmp_name'] != '') {
	$str_target_path = '/home/e-feel/e-feel.club/uploaded_images/';
	$str_target_path = "{$str_target_path}uploaded.mp3";
	if(move_uploaded_file($_FILES['file_mp3']['tmp_name'], $str_target_path)) {
		$_SESSION['str_mp3_file'] = $_FILES['file_mp3']['name'];
	}
}



$_SESSION['arr_found'] = $arr_matched_subj_ids;
$_SESSION['arr_errors'] = $arr_errors;
$_SESSION['arr_enrolled'] = $arr_enroll_subj_ids;

header('Location: /confirmation.php');