<?php
$status = 0;
$dest = $_POST['dest'];
//$dest='/xampp/htdocs/stage/';
$src = $_POST['src'];
//$src='/xampp/htdocs/nrm/0becb9d--bestin.dominic@wizmobi.com--2018-04-2610_09_18';
$files = scandir($src);
// Identify directories
$source = $src . "/";
$destination = $dest;
rcopy($source, $destination);
// Cycle through all source files

function rrmdir($dir)
{
    if (is_dir($dir)) {
        $files = scandir($dir);
        foreach ($files as $file)
            if ($file != "." && $file != "..") rrmdir("$dir/$file");
        rmdir($dir);
    } else if (file_exists($dir)) unlink($dir);
}

function rcopy($src, $dst)
{
    global $status;
    if (file_exists($dst))
        rrmdir($dst);
    if (is_dir($src)) {


        if (!@mkdir($dst)) {

            $status = "Cannot Create directory..";
        } else {
            $files = scandir($src);
            foreach ($files as $file)
                if ($file != "." && $file != "..")
                    rcopy("$src/$file", "$dst/$file");
            $status = "Success";
        }
    } else if (file_exists($src))
        copy($src, $dst);
    $status = "Success";
}

echo $status;
?>