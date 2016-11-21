<?php
//import the converter class
require('class/image_converter.php');

//Only Admins and VIP's can convert GIF types.
$IsAdminOrVIP = false;
if ($session->logged_in && ($session->isAdmin() || $session->isManager())) {
    $IsAdminOrVIP = true;
}

if($_FILES){
	$obj = new Image_converter();
	//call upload function and send the $_FILES, target folder and input name
	$upload = $obj->upload_image($_FILES, 'uploads', 'fileToUpload', $IsAdminOrVIP);
	if($upload){
		$imageName = urlencode($upload[0]);
		$imageType = urlencode($upload[1]);
		
		if($imageType == 'jpeg'){
			$imageType = 'jpg';
		}
		header('Location: convert.php?imageName='.$imageName.'&imageType='.$imageType);
	}
}	
?>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8"/> 
    <link href="include/styles.css" rel="stylesheet" type="text/css" />
</head>
<script>
    function checkEmpty(){
        var img = document.getElementById('fileToUpload').value;
        if(img == ''){
            alert('Prašome įkelti paveikslėlį');
            return false;
        }
        return true;
    }
</script>
    <table width="500" align="center">
        <tr>
            <td align="center">
                <form action="" enctype="multipart/form-data" method="post" onsubmit="return checkEmpty()" />
                    <input type="file" name="fileToUpload" id="fileToUpload" />
                    <input type="submit" value="Upload" />
                </form>
            </td>
        </tr>
    </table>