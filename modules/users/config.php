<?php
/*
#module_name,Users
#module_description,User Manager
#module_req,4
#module_id,14
*/
$self=$_GET['module'];
//$module_public='./?module=bulletin';
$module_admin='./?module=admin&part=users';
$module_data='./?module=data&part=users';

$array= array('Admin'=>
array(array('link'=>'admin&part=users','name'=>'Users'))
);
?>