<?php 
error_reporting(E_ALL);
session_start();
require_once('Kairos-SDK-PHP-master/Kairos.php');

$app_id  = '917bb4dc';
$api_key = '38b90fc66a94e16edc7854e7f12540d7';
$Kairos  = new Kairos($app_id, $api_key);

$obj_response   = json_decode($Kairos->listSubjectsForGallery('gallery1'));

foreach($obj_response->subject_ids as $str_subj_id){
	$Kairos->removeSubjectFromGallery($str_subj_id, 'gallery1');
}