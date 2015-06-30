<?php
//checking values in session variable
//    session_start();
//    echo sizeof($_SESSION);
//    foreach ($_SESSION as $key=>$value)
//    {
//        echo "<br/>".$key;
//        echo "&nbsp;&nbsp;".$_SESSION[$key];
//    }

//create directory
//$path = "/Users/vipinsharma/NetBeansProjects/BugHound/uploadedAttachments/100";
//mkdir($path);

//upload a file

?>

<?php
echo "fileToUpload size".sizeof($_FILES["fileToUpload"]);
echo "<br/>fileToUpload name size".sizeof($_FILES["fileToUpload"]["name"]);
$bugId = 101;

$target_dir = "/Users/vipinsharma/NetBeansProjects/BugHound/uploadedAttachments/".$bugId;
mkdir($target_dir);

$count=sizeof($_FILES["fileToUpload"]["name"]);
echo "target Dir".$target_dir;

for($i=0;$i<$count;$i++)
{
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
    echo "<br/>targetFile".$target_file;
    $uploadOk = 1;
//    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
//    echo "<br/>imageFileType".$imageFileType;
//    // Check if image file is a actual image or fake image
//
//    if(isset($_POST["submit"])) {
//        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$i]);
//        echo "<br/>check".$check;
//        if($check !== false) {
//            echo "<br/>File is an image - " . $check["mime"] . ".";
//            $uploadOk = 1;
//        } else {
//            echo "<br/>File is not an image.";
//            $uploadOk = 0;
//        }
//    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "<br/>Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    //if ($_FILES["fileToUpload"]["size"] > 500000) {
    //    echo "Sorry, your file is too large.";
    //    $uploadOk = 0;
    //}
    // Allow certain file formats
    //if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    //&& $imageFileType != "gif" ) {
    //    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    //    $uploadOk = 0;
    //}
    //// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<br/>Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
            echo "<br/>The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
        } else {
            echo "<br/>Sorry, there was an error uploading your file.";
        }
    }
}
?>