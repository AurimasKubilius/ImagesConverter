<?php 

/***
*	Paveikslėlių failų formatų konvertavimo sistema
*
* 	convert_image() turi 3 privalomus parametus
*	$convert_type 	=> priima string'ą 'png', 'jpg' arba 'gif'
*   $target_dir  	=> "target directory"
*	$image_name		=> failo vardas, pavyzdžiui: 'image.jpg'
*
*	//Galimi parametrai
*	$image_quality 	=> galima nustatyti, jeigu nenorime 100% kokybės
*
***/


class Image_converter{
	
	//paveikslėlio konvertavimas
	function convert_image($convert_type, $target_dir, $image_name, $image_quality=100){
		$target_dir = "$target_dir/";
		
		$image = $target_dir.$image_name;
		
		//pašalinimas plėtinys
		$img_name = $this->remove_extension_from_image($image);
		
		//į png
		if($convert_type == 'png'){
			$binary = imagecreatefromstring(file_get_contents($image));
			//trečiasis parametras ImagePng yra nuo 0 iki 9
			//0 yra nesuspaustas, 9 yra suspaustas
			//Todėl konvertuoju 100 į 2 skaitmenų numerį dalindamas iš 10 ir atimdamas iš 10
			$image_quality = floor(10 - ($image_quality / 10));
			ImagePNG($binary, $target_dir.$img_name.'.'.$convert_type, $image_quality);
			return $img_name.'.'.$convert_type;
		}
		
		//į jpg
		if($convert_type == 'jpg'){
			$binary = imagecreatefromstring(file_get_contents($image));
			imageJpeg($binary, $target_dir.$img_name.'.'.$convert_type, $image_quality);
			return $img_name.'.'.$convert_type;
		}		
		//į gif
		if($convert_type == 'gif'){
			$binary = imagecreatefromstring(file_get_contents($image));
			imageGif($binary, $target_dir.$img_name.'.'.$convert_type, $image_quality);
			return $img_name.'.'.$convert_type;
		}				
		return false; 
	}

	
	//paveikslėlių įkėlimas
	public function upload_image($files, $target_dir, $input_name, $IsAdminOrVIP){
		
		$target_dir = "$target_dir/";
		
		//gauname pradinį paveikslėlio vardą
		$base_name = basename($files[$input_name]["name"]);

		//gauname paveikslėlio tipą
		$imageFileType = $this->get_image_type($base_name);
		
		//sukuriame dinaminį vardą paveikslėliui
		$new_name = $this->get_dynamic_name($base_name, $imageFileType);
		
		//nustatome failą įkėlimui
		$target_file = $target_dir . $new_name;
	
		// Maksimalus dydis 1MB
		$file_size = $this->check_file_size($files[$input_name]["size"], 1024*1024);
		if(!$file_size){
			echo "<p class='alert'> Negalite įkelti didesnio negu 1MB failo </p>";
			return false;
		}

		//Tikriname ar tai apskritai yra paveiksliukas
		$validate = $this->validate_image($files[$input_name]["tmp_name"]);
		if(!$validate){
			echo "<p class='alert'> Nepanašu, kad tai yra paveikslėlis :( </p>";
			return false;
		}

		// Leidžiama tik kelis formatus ir priklausomai nuo kategorijos galimi failų formatai
		$file_type = $this->check_only_allowed_image_types($imageFileType, $IsAdminOrVIP);
		if($IsAdminOrVIP){
			if(!$file_type){
				echo "<p class='alert'> Jūs negalite įkelti kitokio failo formato nei JPG, JPEG, PNG arba GIF.</p>";
				return false;
			}
		} elseif (!$file_type){
				echo "<p class='alert'> Jūs negalite įkelti kitokio failo formato nei JPG, JPEG, PNG.</p>";
				return false;
		}

		
		if (move_uploaded_file($files[$input_name]["tmp_name"], $target_file)) {
			//gražiname naują paveikslėlį su nauju formatu
			return array($new_name, $imageFileType);
		} else {
			echo "<p class='alert'> Ups, įvyko klaida įkeliant failą. </p>";
		}

	}
	
	protected function get_image_type($target_file){
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		return $imageFileType;
	}
	
	protected function validate_image($file){
		$check = getimagesize($file);
		if($check !== false) {
			return true;
		} 
		return false;
	}
	
	protected function check_file_size($file, $size_limit){
		if ($file > $size_limit) {
			return false;
		}
		return true;
	}
	
	protected function check_only_allowed_image_types($imagetype, $IsAdminOrVIP){
		if ($IsAdminOrVIP) {
			if($imagetype != "jpg" && $imagetype != "JPG"  && $imagetype != "png" && $imagetype != "PNG"  && $imagetype != "jpeg" && $imagetype != "JPEG"  && $imagetype != "gif" && $imagetype != "GIF" ) {
				return false;
			} return true;
		} elseif ($imagetype != "jpg" && $imagetype != "JPG"  && $imagetype != "png" && $imagetype != "PNG"  && $imagetype != "jpeg" && $imagetype != "JPEG") {
				return false;
			} return true;
	}
	
	protected function get_dynamic_name($basename, $imagetype){
		$only_name = basename($basename, '.'.$imagetype); // šalinti plėtinį
		$combine_time = $only_name.'_'.time();
		$new_name = $combine_time.'.'.$imagetype;
		return $new_name;
	}
	
	protected function remove_extension_from_image($image){
		$extension = $this->get_image_type($image); //gauti plėtinį
		$only_name = basename($image, '.'.$extension); // šalinti plėtinį
		return $only_name;
	}
}

function resize($width, $height){
	/* Gaunamas orginalaus failo x ir y*/
	list($w, $h) = getimagesize($_FILES['image']['tmp_name']);
	/* Skaičiuojamas naujas paveikslėlio dydis su ratio */
	$ratio = max($width/$w, $height/$h);
	$h = ceil($height / $ratio);
	$x = ($w - $width / $ratio) / 2;
	$w = ceil($width / $ratio);
	$limit = $w*$h;
	/* Naujas failo vardas */
	$path = 'uploads/'.$width.'x'.$height.'_'.$_FILES['image']['name'];
	/* Nuskaitomi dvejetainiai duomenys iš failo */
	$imgString = file_get_contents($_FILES['image']['tmp_name']);
	/* Sukuriamas paveiksliukas */
	$image = imagecreatefromstring($imgString);
	$tmp = imagecreatetruecolor($width, $height);
	imagecopyresampled($tmp, $image,
  	0, 0,
  	$x, 0,
  	$width, $height,
  	$w, $h);
	/* Saugojimas */
	switch ($_FILES['image']['type']) {
		case 'image/jpeg':
			imagejpeg($tmp, $path, 100);
			break;
		case 'image/png':
			imagepng($tmp, $path, 0);
			break;
		case 'image/gif':
			imagegif($tmp, $path);
			break;
		default:
			exit;
			break;
	}
	return $path;
	/* Atminties išvalymas */
	imagedestroy($image);
	imagedestroy($tmp);
	}

?>