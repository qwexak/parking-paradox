<?php
$out = [];
foreach(get_loaded_extensions() as $ext){
 $out[$ext] = get_extension_funcs($ext);

}

print_r($out);