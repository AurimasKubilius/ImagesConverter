<?php
include("class/image_converter.php");
// Nustatymai
$max_file_size = 1024*1024; // 1MB
$valid_exts = array('jpeg', 'jpg', 'png', 'gif'); //galimi plėtiniai - "extension'ai"
$gps_exts = array('gpx', 'gps'); //gps failo radimui

if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_FILES['image'])) {
	if( $_FILES['image']['size'] < $max_file_size ){
		// to get file extension
		$ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
		if (!in_array($ext, $gps_exts)) {
			if (in_array($ext, $valid_exts)) {
				/* Original file x and y dimensions*/
				list($w, $h) = getimagesize($_FILES['image']['tmp_name']);

				$width = $_POST['width'];
				$height = $_POST['height'];
				$sizes = array($width => $height);

				if ($w > $width && $h > $height ) { //Sąlyga nr.2 citata "(Galima tik mažinti)" 
					foreach ($sizes as $w => $h) {
						$files[] = resize($w, $h);
					}
				} else{ 
				$msg = 'Paveikslėlius galima tik mažinti (Įvestas didesnis plotis arba aukštis, negu buvo)'; 
				}	
			} else {
				$msg = 'Nepalaikomas failo formatas. Galimi formatai: jpeg, jpg, png, gif';
			}
		}else{
			$msg = 'Tai yra GPS failas';
		}	
	} else{
		$msg = 'Prašome įkelti failą ne didesnį kaip 1MB';
	}
}

?>
	<?php if(isset($msg)): ?>
	<p class='alert'><?php echo $msg ?></p>
	<?php endif ?>
		
	<!-- File uploading form -->
		<form action="" method="post" enctype="multipart/form-data">
			<label>
			<span>Pasirinkite paveikslėlį:</span><br>
			<input type="file" name="image" accept="image/*" /><br>
			</label>

			<label for="width">Įveskite norimą plotį:</label><br>
            <input type="text" name="width" id="width" required="true" /><br>

			<label for="height">Įveskite norimą aukštį:</label><br>
            <input type="text" name="height" id="height" required="true" /><br><br>

			<input type="submit" value="Keisti matmenis" />
		</form>
		
		<?php
		// Show "thumbnail"
		if(isset($files)){
			foreach ($files as $image) {
				echo "<img class='img' src='{$image}' /> <br>";
			}
		}
?>