<?php include('session_check.php'); ?>
<?php
define("DESTINATION_FOLDER", $_POST['upUrl']);
$newfile = $_FILES['file']['name'];
if(is_file(DESTINATION_FOLDER . "/" . $_FILES['file']['name'])) { 
	$spildname = explode(".", $_FILES['file']['name']);	
	for ($i=1;$i<100;$i++) {
		if ($i<10) {
			$newname = $spildname[0].'0'.$i;
		}else{
			$newname = $spildname[0].$i;
		}
		$newfile = $newname.".".$spildname[1];
		if(!is_file(DESTINATION_FOLDER . "/" . $newfile)) {
			$i = 100;
		}		
	}
}
if(move_uploaded_file($_FILES['file']['tmp_name'],DESTINATION_FOLDER . "/" . $newfile)){
	echo "ok";
} else {
	echo "no";
}
?>
<script language = "JavaScript">
window.opener.<?php echo $_POST['useForm']; ?>.<?php echo $_POST['prevImg']; ?>.src = '<?php echo $_POST['upUrl']; ?>'+'/'+'<?php echo $newfile; ?>';
window.opener.<?php echo $_POST['useForm']; ?>.<?php echo $_POST['reItem']; ?>.value = '<?php echo $newfile; ?>';
window.close();
</Script>