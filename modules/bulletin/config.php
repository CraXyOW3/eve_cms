<?php
/*
#module_name,Bulletin
#module_description,A simple Bulletin!
#module_req,4
#module_id,10
*/
$self=$_GET['module'];
$module_public='./?module=bulletin';
$module_admin='./?module=admin&part=bulletin';
$module_data='./?module=data&part=bulletin';

$array= array('Admin'=>
array(array('link'=>'admin&part=bulletin','name'=>'Bulletin Admin')),
'Public'=>
array(array('link'=>'bulletin','name'=>'Bulletin'))
);
?>