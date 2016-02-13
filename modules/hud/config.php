<?php
/*
#module_name,HUD
#module_description,Heads Up Display
#module_req,4
#module_id,33
*/
if(isset($_GET['module'])){$hself=$_GET['module'];}else{$hself='';}
//$self=$_GET['module'];
$self=$hself;
$module_public='./?module=hud';
$module_admin='./?module=admin&part=hud';
$module_data='./?module=data&part=hud';

$array= array('Admin'=>
array(array('link'=>'admin&part=hud','name'=>'HUD')),
'Public'=>
array(array('link'=>'hud','name'=>'HUD'))
);
?>