<?php
if (isset($_POST['submit'])) {
    $shop = $_POST['shop'];
   }
echo $shop;
// Set variables for our request
$api_key = "1ad16161f1d79d041faa271898ce163f";
$scopes = "read_orders,write_products";
$redirect_uri = "https://5fa015be.ngrok.io/proj/main_controller.php";
// Build install/approval URL to redirect to
$install_url = "https://" . $shop . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);
// Redirect
header("Location: " . $install_url);

die();

?>
