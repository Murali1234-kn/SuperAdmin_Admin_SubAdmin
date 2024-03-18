<?php
$zip = new ZipArchive();
if(isset($_GET['unzip_date']))
{
$file_path = 'C:\Users\91630\Downloads'.$_GET['unzip_date'].'.zip';
if ($zip->open($file_path) === TRUE)
{
$zip->extractTo('./uploads/');
$zip->close();
echo '<script>alert("Folder extracted successfully!"); </script>';
header('Location: New_Images.php');
} else {
echo '<script>alert("Failed to extract folder!");</script>';
header('Location: New_Images.php');
  }
}
?>