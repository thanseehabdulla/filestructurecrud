<?php

$dir = $_POST['path'];

//$dir ='/opt/lampp/htdocs/phplist/nrm/nrm1/newfile';


//$filename = $_POST['filename'];

$home = '/opt/builds';


if (!empty($_POST['path'])) {
//   if(true){

    $data = array();

    function scan_dir($dir)
    {
        $ignored = array('.', '..', '.svn', '.htaccess');

        $files = array();
        foreach (scandir($dir) as $file) {
            if (in_array($file, $ignored)) continue;
//                $files[$file] = filemtime($dir . '/' . $file);
            $splits = explode('--', $file);
            $files[$file] = $splits[2];
        }

        arsort($files);
        $files = array_keys($files);

        return ($files) ? $files : false;
    }


    $base = basename($dir);
    $split = explode('/', $dir);

    $pathd = "";
    for ($j = 0; $j < count($split); $j++) {
        if ($split[$j] == '..') {
            $temp = explode('/', $pathd);
            $pathd = "";
            for ($k = 0; $k < count($temp) - 1; $k++) {
                if ($k !== 0)
                    $pathd = $pathd . "/" . $temp[$k];
                else
                    $pathd = $pathd . $temp[$k];
            }
        } else {
            if ($j !== 0)
                $pathd = $pathd . "/" . $split[$j];
            else
                $pathd = $pathd . $split[$j];
        }
    }
    $tem = 0;


    if ($pathd == $home) {
        $files1 = scan_dir($home);
    } else {

        $files1 = scandir($dir);

    }


    arsort($files1);


//    if ($pathd == $home) {
////        $tem = 2;
//    }
    //echo $dir . '/' . $files1[$i];
    for ($i = $tem; $i < count($files1); $i++) {
        if (is_dir($dir . '/' . $files1[$i])) {
            $icon = "<img src='images/folder.png' style='width:45px'/>";
        } else {
            $icon = "<img src='images/icon.png' style='width:45px'/>";
        }


        $files = $files1[$i];
        $size = filesize($dir . '/' . $files1[$i]);
        $data[] = array('icon' => $icon, 'name' => $files1[$i], 'size' => $size);


    }


    $data[] = array('path' => $pathd, 'base' => $base);


//returns data as JSON format
    echo json_encode($data);
} else {
    $icon = "<img src='images/folder.png' style='width:45px'/>";

    $data[] = array('icon' => 'icon', 'name' => '..', 'size' => '0');
    $base = basename($dir);

    $split = explode('/', $dir);
    $pathd = "";

    for ($j = 0; $j < count($split); $j++) {
        if ($split[$j] == '..') {
            $j++;
        } else {
            $pathd = $pathd . $split[$j];
        }
    }

    $data[] = array('path' => $pathd, 'base' => $base);

    echo json_encode($data);

}

?>
