<?php
header("Content-Type: text/plain");

session_start();
if(isset($_SESSION["conversation_id"])){
	$c_id = $_SESSION["conversation_id"];
}else{
	$c_id = $_POST["id"];
	$_SESSION["conversation_id"] = $c_id;
}


$workspace = "0df25935-eca2-48fb-8fb2-7e43fd553ed5";
$username = "33d18d58-3efc-420e-8c7f-f5e4d81558de";
$password = "EobKX78kTBIs";


$texto = $_POST["texto"];

$url = "https://gateway.watsonplatform.net/conversation/api/v1/workspaces/" . $workspace . "/message?version=2017-05-26";

$dados  = "{";
$dados .= "\"input\": ";
$dados .= "{\"text\": \"" . $texto . "\"},";
$dados .= "\"context\": {\"conversation_id\": \"" . $c_id . "\",";
$dados .= "\"system\": {\"dialog_stack\":[{\"dialog_node\":\"root\"}], \"dialog_turn_counter\": 1, \"dialog_request_counter\": 1}}";
$dados .= "}";


$headers = array('Content-Type:application/json');

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $dados);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

$retorno = curl_exec($curl);
curl_close($curl);

$retorno = json_decode($retorno);
echo json_encode($retorno, JSON_PRETTY_PRINT);

?>