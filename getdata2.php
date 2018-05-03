<?php

$dir = $_POST['path'];

//$dir ='/opt/lampp/htdocs/phplist/nrm/nrm1/newfile';


//$filename = $_POST['filename'];

$home = '/opt/builds';




if (!empty($_POST['path'])) {
//   if(true){

    $data = array();
    $files1 = scandir($dir);
	$base = basename($dir);
    $split = explode('/', $dir);
	
    $pathd="";
    for($j =0 ; $j <count($split); $j++ ){
        if($split[$j] == '..'){
           $temp = explode('/', $pathd);
           $pathd="";
            for($k =0 ; $k <count($temp)-1; $k++ ) {
            if($k !== 0)
            $pathd = $pathd."/".$temp[$k];
            else
                $pathd = $pathd.$temp[$k];
            }
        }else{
        if($j !== 0)
         $pathd= $pathd ."/".$split[$j];
        else
            $pathd= $pathd .$split[$j];
        }
    }
	$tem=0;
	
	if($pathd==$home){
	$tem=2;
	}
	//echo $dir . '/' . $files1[$i];
    for ($i = $tem; $i < count($files1); $i++) {
        if (is_dir($dir . '/' . $files1[$i])) {
            $icon = "<img src='images/folder.png' style='width:20px'/>";
        } else {
            $icon = "<img src='images/icon.png' style='width:20px'/>";
        }


        $files = $files1[$i];
        $size= filesize($dir . '/' . $files1[$i]);
        $data[] = array('icon' => $icon, 'name' => $files1[$i],'size' => $size);


    }
   
	

    $data[] = array('path' => $pathd,'base'=> $base);



//returns data as JSON format
    echo json_encode($data);
}
else {
    $icon = "<img src='images/folder.png' style='width:25px'/>";

    $data[] = array('icon' => 'icon', 'name' => '..','size' => '0');
    $base = basename($dir);

    $split = explode('/', $dir);
    $pathd="";

    for($j =0 ; $j <count($split); $j++ ){
        if($split[$j] == '..'){
            $j++;
        }else{
            $pathd= $pathd . $split[$j];
        }
    }

    $data[] = array('path' => $pathd,'base'=> $base);

    echo json_encode($data);

}

?>