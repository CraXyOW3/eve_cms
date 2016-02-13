<?php
/*
#module_name,Primetime
#module_description,Best online times.
#module_req,1
#module_id,66
*/
//$self=$_GET['module'];
$module_public='./?module=primetime';
//$module_admin='./?module=admin&part=page';
$module_data='./?module=data&part=primetime';

$array= array('Admin'=>
array(),
'Public'=>
array(array('link'=>'primetime','name'=>'Primetime'))
);
?>