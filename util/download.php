<?php
 
ignore_user_abort(true);
set_time_limit(0); // disable the time limit for this script

$path = $_SERVER['DOCUMENT_ROOT']."/curriculo/"; // change the path to fit your websites document structure

if(file_exists($path.$_GET['download_file'].".pdf")){
	$fileName = $_GET['download_file'].".pdf";
}else if(file_exists($path.$_GET['download_file'].".doc")){
	$fileName = $_GET['download_file'].".doc";
}else if(file_exists($path.$_GET['download_file'].".docx")){
	$fileName = $_GET['download_file'].".docx";
}else{
	exit;
}
 
$dl_file = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).]|[\.]{2,})", '', $fileName); // simple file name validation
$dl_file = filter_var($dl_file, FILTER_SANITIZE_URL); // Remove (more) invalid characters
$fullPath = $path.$dl_file;
 
if ($fd = fopen ($fullPath, "r")) {
    $fsize = filesize($fullPath);
    $path_parts = pathinfo($fullPath);
    $ext = strtolower($path_parts["extension"]);
    switch ($ext) {
        case "pdf":
        header("Content-type: application/pdf");
        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a file download
        break;
		case "msword":
        header("Content-type: application/msword");
        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a file download
        break;
		case "vnd.openxmlformats-officedocument.wordprocessingml.document":
        header("Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a file download
        break;
        // add more headers for other content types here
        default;
        header("Content-type: application/octet-stream");
        header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
        break;
    }
    header("Content-length: $fsize");
    header("Cache-control: private"); //use this to open files directly
    while(!feof($fd)) {
        $buffer = fread($fd, 2048);
        echo $buffer;
    }
}
fclose ($fd);
exit;