<?php
	require 'compress.php';
	//file_put_contents('output.php',replace_php_src('CodeIgniter/system/core/CodeIgniter.php'));

	$dir = "./CodeIgniter/system/core";  //要获取的目录
	a($dir);
	function a($dir){
		if (is_dir($dir)){
			if ($dh = opendir($dir)){
				while (($file = readdir($dh))!= false){
					$filePath = $dir . "/" . $file;
					if(is_dir($filePath)){
						if(!($file=="." || $file=="..")){
							a($filePath);
						}
					}else{
						//print($filePath . "\n");
file_put_contents('./core/' . $file,replace_php_src($filePath));
					}
					
				}
				closedir($dh);
			}
		}
	}
?>
