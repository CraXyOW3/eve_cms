<?php
/*
#module_name,Userlist
#module_description,List's Corps Users and extras.
#module_req,2
#module_id,19
*/
$self=$_GET['module'];
$module_public='./?module=userlist';
$module_admin='./?module=admin&part=userlist';
$module_data='./?module=data&part=userlist';
/*
$array= array('Admin'=>
array(array('link'=>'admin&part=userlist','name'=>'Manage userlist'),array('link'=>'admin&part=userlist&a=roles','name'=>'Manage userlistroles')),
'Public'=>
array(array('link'=>'fittings','name'=>'Fittings'))
);
*/
$array= array(
'Public'=>
array(array('link'=>'userlist','name'=>'Userlist'))
);
?>