<?php
$date = $_GET['date'];
$dir = 'uploads/' . $date;
$files = scandir($dir);

$zip = new ZipArchive();
$file_name = 'uploads/' .$date. '.zip';

if ($zip->open($file_name, ZipArchive::CREATE) !== TRUE)
{
//    echo "cannot";
    exit("cannot open <$file_name>\n");
}
foreach ($files as $file)
{
    if(is_file($dir.'/'.$file))
    {

        $zip->addFile($dir . '/' . $file, $file);
    }
}

$zip->close();
header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$date.'.zip');
header('Content-Length: ' . filesize($file_name));

readfile($file_name);

?>

