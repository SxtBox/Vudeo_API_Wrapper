<?php
require_once "vendor/autoload.php";
$client = new \GuzzleHttp\Client();

$api = new \Vudeo\Streaming\Api($client);
// Your own api key from https://vudeo.io/?op=my_account
$api->set_api_key("ENTER_API_KEY_HERE");

// full url https://vudeo.io/aqgypxct9pmq.html
$direct_link = $api->get_direct_link("aqgypxct9pmq"); // file id
//echo json_encode($direct_link);

$account_info = $api->get_account_info();
//echo json_encode($account_info);

$account_stats = $api->get_account_stats();
//echo json_encode($account_stats);

$account_stats_last = $api->get_account_stats_last("7");
//echo json_encode($account_stats_last);

/*
VIDEO UPLOADER
URL TO UPLOADING
*/
// example url https://my_server.io/video.mp4
$upload = $api->upload("VIDEO_URL_TO_UPLOADING_HERE");
//echo json_encode($upload);

// GET UPLOADING SERVER
$upload_server = $api->get_uploading_server();
//echo json_encode($upload_server);

// full url https://vudeo.io/aqgypxct9pmq.html
$get_file_info = $api->get_file_info("aqgypxct9pmq"); // file id
//echo json_encode($get_file_info);

//GET ALL JSON DATA
$get_file_list = $api->get_file_list();
//echo json_encode($get_file_list);

// Group Folders
// example https://vudeo.io/?op=my_files&fld_id=772
$get_folder_list = $api->get_folder_list("772"); // folder id
//echo json_encode($get_folder_list);
?>
