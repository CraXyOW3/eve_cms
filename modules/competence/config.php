<?php
/*
#module_name,Competence
#module_description,See the competence based on custom prefs.
#module_req,4
#module_id,11
*/
$self=$_GET['module'];
$module_public='./?module=competence';
$module_admin='./?module=admin&part=competence';
$module_data='./?module=data&part=competence';

$array= array('Admin'=>
array(array('link'=>'admin&part=competence','name'=>'Competence')),
'Public'=>
array(array('link'=>'competence','name'=>'Competence Diag'))
);
?>