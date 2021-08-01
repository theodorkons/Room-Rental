<?php
//FIXME check image not shown

$prevPage = $_SERVER['HTTP_REFERER'];

session_start();
require_once('Accommodation.php');
require_once('rental_database.php');

$user_id = $_SESSION['id'];

$db = new RentalDatabase();
$accommodation = new Accommodation();

$accommodation->setUsername($user_id);

$photos = getPhotos();
$accommodation->addImages($photos);
$accommodation->setTitle($_POST['title']);
$accommodation->setLocation($_POST['location']);
$accommodation->setDescription($_POST['description']);
$accommodation->setCheckIn($_POST['check-in']);
$accommodation->setCheckOut($_POST['check-out']);


if (!isset($_POST['title']) || trim($_POST['title']) == '') {
    display_error("You must specify a title address using the 'title' POST field.");
    return;
}

if (!isset($_POST['location']) || trim($_POST['location']) == '') {
    display_error("You must specify a location address using the 'location' POST field.");
    return;
}

if (!isset($_POST['description']) || trim($_POST['description']) == '') {
    display_error("You must specify a description using the 'description' POST field.");
    return;
}

if (!isset($_POST['check-in']) || trim($_POST['check-in']) == '') {
    display_error("You must specify check-in using the 'check-in' POST field.");
    return;
}

if (!isset($_POST['check-out']) || trim($_POST['check-out']) == '') {
    display_error("You must specify check-out using the 'check-out' POST field.");
    return;
}

$db->addAccommondation($accommodation);
header("Location: $prevPage", true, 303);


function getPhotos(){
    $photos_to_return = array();
    $target_dir = "housing_photos/";
    $photos = $_FILES["photos"];
    for($i = 0; $i < count($photos["name"]); $i++){
        $target_file = $target_dir . basename($photos['name'][$i]);

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if(isset($_POST["submit"])) {
            if(!isset($photos["tmp_name"][$i]) or $photos["tmp_name"][$i] == ""){
                continue;
            }
            $check = getimagesize($photos["tmp_name"][$i]);
            if($check !== false) {
//                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
//                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
//            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($photos["size"][$i] > 10000000) {
//            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
//            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
//            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($photos["tmp_name"][$i], $target_file)) {
                array_push($photos_to_return, $target_file);
//                echo "The file ". basename( $photos["name"][$i]). " has been uploaded.";
            } else {
//                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    return $photos_to_return;

}
 ?>