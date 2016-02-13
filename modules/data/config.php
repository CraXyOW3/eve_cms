<?php
/*
#module_name,Handler
#module_description,Data Handler Core
#module_req,2
#module_id,2
*/
$self=$_GET['module'];
$module_public='./?module=bulletin';
$module_admin='./?module=admin&part=bulletin';
$module_data='./?module=data&part=bulletin';

$array= array('Admin'=>
array(),
'Public'=>
array()
);
?>