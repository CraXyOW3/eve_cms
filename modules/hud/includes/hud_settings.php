<?php
include('../../../config.php');
include('../../../includes/database.php');
include('../../../includes/functions.php');
$charid=$_SERVER['HTTP_EVE_CHARID'];
$api_row = good_query_assoc("SELECT * FROM corp_members WHERE char_id='$charid'");
?>
<img height="80" width="1" src="./img/pixel_trans.gif">
<div>
If you want to factor in your own standings into the Locator Agent Locator, you need to put in your API standings.
</div><br /><br />
<fieldset>
<legend>API Configuration</legend>
<form id="ag_lvl_form" onsubmit="return submitForm();">
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>keyID</td>
		<td><input name="keyID" type="text" value="<?php echo $api_row['api_keyid']; ?>"></td>
	</tr>
	<tr>
		<td>vCode</td>
		<td><input name="vCode" type="text" value="<?php echo $api_row['api_vcode']; ?>" size="30"></td>
	</tr>
	<tr>
		<td><input type="hidden" name="charID" value="<?php echo $_SERVER['HTTP_EVE_CHARID']; ?>"><input name="submit" type="submit" value="save"></td>
	</tr>
</table>
<div class="form_result"> </div>
</form>
</fieldset>
<script type="text/javascript">
	function loadxml(id) {
		$("#contentxml").load("./modules/hud/hud_handler.php?set=fetch&char_id="+id+"");
	}
</script>
<br />
<fieldset>
<legend>Resource Actions</legend>
<?php
if(empty($api_row['api_keyid']) || $api_row['api_keyid']=='0'){
echo'<a href="https://support.eveonline.com/api/Key/CreatePredefined/524288" target="_blank">Please set API!</a>';
}else{
echo '<a href="javascript:loadxml(\''.$_SERVER['HTTP_EVE_CHARID'].'\');">Fetch ApiSheet</a>';
echo '<div id="contentxml">&nbsp;</div>';
}
?>
</fieldset>
