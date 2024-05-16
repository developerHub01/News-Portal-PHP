<?php

function modify_file_name($file_name){
  $file_name = explode(" ",$file_name);
  $file_name = implode("_",$file_name);

  $file_name = explode(".", $file_name);
  $file_temp_extension = $file_name[count($file_name)-1];
  $current_time_in_miliseconds = time()*1000;
  $file_name[count($file_name)-1] = $current_time_in_miliseconds;
  $file_name = implode("_", $file_name);
  $file_name = [$file_name, $file_temp_extension];
  $file_name = implode(".", $file_name);

  return $file_name;
}

function upload_image($img_name){
  
  if(isset($_FILES[$img_name])){
    $error = [];
    
    $file_name = $_FILES[$img_name]['name'];
    $file_name = modify_file_name($_FILES[$img_name]['name']);

    $file_size = $_FILES[$img_name]['size'];
    $file_temp_name = $_FILES[$img_name]['tmp_name'];
    $file_type = $_FILES[$img_name]['type'];

    
    $file_extension = explode("/", $file_type);
    $file_extension = $file_extension[count($file_extension)-1];
    
    $allowed_extensions = ['jpeg', 'jpg', 'png'];

    if($file_name || $file_size || $file_temp_name || $file_type || $file_extension)
    if(!in_array($file_extension, $allowed_extensions)){
      $error[] = "Extension not supported.";
      return "";
    }
    if($file_size > 2*1024*1024) $error[] = "Max file size 2MB";

    if(empty($error)){
      move_uploaded_file($file_temp_name, "./upload/" . $file_name);
      return $file_name;
    }else{
      return "";
    }
  }
}
?>