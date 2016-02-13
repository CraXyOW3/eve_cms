<?php
/*
#module_name,Fittings
#module_description,Fittings Library (Req: EVEDB)!
#module_req,4
#module_id,9
*/
$self=$_GET['module'];
$module_public='./?module=fittings';
$module_admin='./?module=admin&part=fittings';
$module_data='./?module=data&part=fittings';

$array= array('Admin'=>
array(array('link'=>'admin&part=fittings','name'=>'Manage Fittings'),array('link'=>'admin&part=fittings&a=roles','name'=>'Manage Roles')),
'Public'=>
array(array('link'=>'fittings','name'=>'Fittings'))
);
?>