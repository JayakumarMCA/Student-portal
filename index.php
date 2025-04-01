<?php 

$user_hostname = "localhost";
$user_username = "u378146579_ksk_selva_db";
$user_password = "!jRE@Wp4";
$user_database = "u378146579_event_booking";

try {
    $j2b_db = new PDO("mysql:host=$user_hostname;dbname=$user_database", $user_username, $user_password);
}
catch(PDOException $e){ echo $e->getMessage(); }
  
?>
