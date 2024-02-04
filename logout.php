<?php
if(isset($_POST['Logout'])){
unset($Consumer_ID);
unset($Admin_ID);
header('Refresh:1; url=Landing_Page.php');
}
?>