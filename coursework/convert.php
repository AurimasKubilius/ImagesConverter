<?php 
include("include/session.php");
if ($session->logged_in) {
//import the converter class
require('class/image_converter.php');

$imageType = '';
$download = false; 

//handle get method, when page redirects
if($_GET){	
	$imageType = urldecode($_GET['imageType']);
	$imageName = urldecode($_GET['imageName']);
}else{
	header('Location:convert.php');
}

//------------------------------------------------------------------------
if($_POST){
	$time_start = microtime(true);
	$convert_type = $_POST['convert_type'];
	//create object of image converter class
	$obj = new Image_converter();
	$target_dir = 'uploads';
	//convert image to the specified type
	$image = $obj->convert_image($convert_type, $target_dir, $imageName);	
	//If convert succesfull, activate download button
	if($image){
		$download = true;
	}
	$time_end = microtime(true);
	$time = $time_end-$time_start;
}
//------------------------------------------------------------------------
$types = array(
	'png' => 'PNG',
	'jpg' => 'JPG',
	'gif' => 'GIF',
);
?>

<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8"/> 
	<title>Konvertuoti failą</title>
	<link href="include/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>

<!-- First window after upload -->

	<?php if(!$download) {?>

	    <table class="center"><tr><td>
        <img src="pictures/header.png"/>

        <?php
        include("include/meniu.php");
        ?>     

        <table style="border-width: 2px; border-style: dotted;"><tr><td>
        Atgal į [<a href="index.php">Pradžia</a>]
        </td></tr></table><br> 
        
        <div style="text-align: center">
		<form method="post" action="">
			<table width="500" align="center">
				<tr>
					<td align="center">
						Paveikslėlis įkeltas! Pasirinkite norimą formatą.
						<img src="uploads/<?=$imageName;?>"  />
					</td>
				</tr>
				<tr>
					<td align="center">
						Konvertuoti į: 
							<select name="convert_type">
								<?php foreach($types as $key=>$type) {?>
									<?php if($key != $imageType){?>
									<option value="<?=$key;?>"><?=$type;?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<br /><br />
					</td>
				</tr>
				<tr>
					<td align="center"><input type="submit" value="Konvertuoti" /></td>
				</tr>
				<?php
            include("include/footer.php");
            ?>
			</table>
		</form>
	<?php } ?>

<!-- Second window after upload -->

	<?php if($download) {?>
	//
		<table class="center"><tr><td>
        <img src="pictures/header.png"/>
        <?php
        include("include/meniu.php");
        ?>              
        <table style="border-width: 2px; border-style: dotted;"><tr><td>
        Atgal į [<a href="index.php">Pradžia</a>]
        </td></tr></table><br> 
        <div style="text-align: center">

		<table width="500" align="center">
				<tr>
					<td align="center">
						Paveikslėlis konvertuotas į <?php echo ucwords($convert_type); ?>
						<br><img src="<?=$target_dir.'/'.$image;?>"  />
					</td>
				</tr>
				<tr>
				<td align="center">
				Konvertavimas užtruko <?php echo round($time , 3); ?> mikrosekundes</td>
					</td>
				</tr>
				<td align="center">
					<a href="download.php?filepath=<?php echo $target_dir.'/'.$image; ?>" />Parsisiųsti
					konvertuotą paveikslėlį</a>
				</td>
			</tr>
			<tr>
				<td align="center"><a href="operacija1.php">Konvertuoti kitą</a>
			</tr>

			<?php
            include("include/footer.php");
            ?>

		</table>
	<?php }
} else {
    header("Location: index.php");
} ?>
</body>
</html>