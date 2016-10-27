<?php
define("DESTINATION_FOLDER", $_POST['upUrl']);
//source file $_FILES['file']['name'] 
//$newfile = $_FILES['file']['name'];
/*if(is_file(DESTINATION_FOLDER . "/" . $_FILES['file']['name'])) { 
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
}*/
//target file with now time stamp
$now_timestamp = date_timestamp_get(date_create());
//get source file type name
$filetype = end(explode('.', $_FILES['file']['name']));
$newfile_custom = "pic".$now_timestamp.".".$filetype;

if($_POST['pathUrl'] <> ""){
    $image_url =  $_POST['pathUrl'].'/'.$newfile_custom;
}else{
    $image_url = $_POST['upUrl'].'/'.$newfile_custom;
}
// echo $image_url."<br>";
echo "1.tmp_name = ".$_FILES['file']['tmp_name']."<br>";
echo "2. DESTINATION_FOLDER = ".$DESTINATION_FOLDER."<br>";
if(move_uploaded_file($_FILES['file']['tmp_name'], DESTINATION_FOLDER . "/" . $newfile_custom)){
	echo "ok";
} else {
	echo "no";
}

echo "prevImg = ".$_POST['prevImg']."<br>";
echo "image_url = ".$image_url."<br>";
echo "reItem = ".$_POST['reItem']."<br>";
echo "newfile_custom = ".$newfile_custom."<br>";
echo "pathUrl = ".$_POST['pathUrl']."<br>";
?>

<script language = "JavaScript">
// window.opener.<?php echo $_POST['useForm']; ?>.<?php echo $_POST['prevImg']; ?>.src = '<?php echo $image_url; ?>';
// window.opener.<?php echo $_POST['useForm']; ?>.<?php echo $_POST['reItem']; ?>.value = '<?php echo $newfile_custom; ?>';
// window.close();
</Script>