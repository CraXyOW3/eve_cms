<?php
/*
#module_name,Forum
#module_description,Mini Forum!
#module_req,4
#module_id,11
*/
$self=$_GET['module'];
$module_public='./?module=forum';
$module_admin='./?module=admin&part=forum';
$module_data='./?module=data&part=forum';

$array= array('Admin'=>
array(array('link'=>'admin&part=forum','name'=>'Forum Admin')),
'Public'=>
array(array('link'=>'forum','name'=>'Forum'),array('link'=>'forum&a=directors','name'=>'DirectorForums'))
);
?>