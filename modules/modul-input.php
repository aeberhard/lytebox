<?php
/**
 * --------------------------------------------------------------------
 *
 * Modul-Input: Beispielmodul für Addon Lytebox
 *
 * Autor: Andreas Eberhard, andreas.eberhard@gmail.com
 *        http://rex.andreaseberhard.de
 *
 * --------------------------------------------------------------------
 */
?>

<table width="98%" border="0" cellpadding="0" cellspacing="3">

	<tr>
		<td valign="top">
			<strong style="display:block;width:185px;">Bild(er) ausw&auml;hlen ...</strong>
		</td>
		<td valign="top">
			REX_MEDIALIST_BUTTON[1]
			<div id="REX_MEDIALIST_PREVIEWC" style="display:none;margin-bottom:25px;">Vorschau:<br /><img id="REX_MEDIALIST_PREVIEW" src="../files/clear.gif" style="cursor:pointer;border:solid 1px #999;" alt="Vorschau" title="Vorschau" /></div>
			<div style="display:block;width:370px;"></div>
		</td>
	</tr>

	<tr>
		<td valign="top"><strong>maximale Bildgr&ouml;&szlig;e</strong></td>
		<td valign="top">
			<input type="text" style="width:70px;" name="VALUE[1]" value="REX_VALUE[1]" />
			<br />(w=Breite, h=H&ouml;he, a=die l&auml;ngere Seite, z.B.: 128w)
		</td>
	</tr>

	<tr>
		<td valign="top"><strong>CSS-Klasse für die Links</strong></td>
		<td valign="top">
			<input type="text" style="width:98%;" name="VALUE[2]" value="REX_VALUE[2]" />
		</td>
	</tr>


	<tr>
		<td valign="top"><strong>Litebox oder Liteshow</strong></td>
		<td valign="top">
<select name="VALUE[3]" >
<?php
foreach (array("lytebox","lyteshow") as $value) {
	echo '<option value="'.$value.'" ';
	
	if ( "REX_VALUE[3]"=="$value" ) {
		echo 'selected="selected" ';
	}
	echo '>'.$value.'</option>';
}
?>
</select>
</td>
	</tr>

	<tr>
		<td valign="top"><strong>Serie pro Seite oder pro Block</strong></td>
		<td valign="top">
<select name="VALUE[4]" >
<?php
foreach (array("Seite","Block") as $value) {
	echo '<option value="'.$value.'" ';
	
	if ( "REX_VALUE[4]"=="$value" ) {
		echo 'selected="selected" ';
	}
	echo '>'.$value.'</option>';
}
?>
</select>
</td>
	</tr>



</table>

<script type="text/javascript">
function addEvent( obj, type, fn )
{
	if (obj.addEventListener) {
		obj.addEventListener( type, fn, false );
	} else if (obj.attachEvent) {
		obj["e"+type+fn] = fn;
		obj[type+fn] = function() { obj["e"+type+fn]( window.event ); }
		obj.attachEvent( "on"+type, obj[type+fn] );
	}
}
function rex_media_preview(){
	var strFileName = document.getElementById("REX_MEDIALIST_SELECT_1").value;
	if ( (strFileName.lastIndexOf(".jpg")>0) || (strFileName.lastIndexOf(".jpeg")>0) || (strFileName.lastIndexOf(".gif")>0) || (strFileName.lastIndexOf(".png")>0) || (strFileName.lastIndexOf(".bmp")>0) ) {
		newImage = new Image();
		newImage.onload = function() {
			document.getElementById("REX_MEDIALIST_PREVIEW").src = newImage.src;
			document.getElementById("REX_MEDIALIST_PREVIEWC").style.display = "block";
		}
		newImage.src = "../index.php?rex_resize=196a__"+document.getElementById("REX_MEDIALIST_SELECT_1").value;
	} else {
		document.getElementById("REX_MEDIALIST_PREVIEWC").style.display = "none";
	}
}
function rex_media_hidepreview(){
		document.getElementById("REX_MEDIALIST_PREVIEWC").style.display = "none";
}
function rex_toggle_plusoptions(){
	if ( document.getElementById("moduleplusoptions").style.display == "none" ) {
		document.getElementById("moduleplusoptions").style.display = "block";
	} else {
		document.getElementById("moduleplusoptions").style.display = "none";
	}
}
addEvent(document.getElementById("REX_MEDIALIST_SELECT_1"), "change", rex_media_preview);
addEvent(document.getElementById("REX_MEDIALIST_SELECT_1"), "click", rex_media_preview);
addEvent(document.getElementById("REX_MEDIALIST_PREVIEW"), "click", rex_media_hidepreview);
</script>
