<?php
/**
 * --------------------------------------------------------------------
 *
 * Modul-Output: Lytebox Video
 *
 * --------------------------------------------------------------------
 */

$breite_media = "REX_VALUE[1]" == "" ? "800" : trim("REX_VALUE[1]");
$hoehe_media = "REX_VALUE[2]" == "" ? "600" : trim("REX_VALUE[2]");
$breite_vorschau = "REX_VALUE[3]" == "" ? "155" : trim("REX_VALUE[3]");

// Vorschaubild berechnen
$vorschaubild = OOMedia::getMediaByName(trim("REX_MEDIA[2]"));
if($vorschaubild instanceof OOMedia) {
	$vorschau_orig_breite = $vorschaubild -> getWidth();
	$vorschau_orig_hoehe = $vorschaubild -> getHeight();
	$hoehe_vorschau = $vorschau_orig_hoehe;
	if($vorschau_orig_breite > $breite_vorschau) {
		$hoehe_vorschau = round($breite_vorschau * $vorschau_orig_hoehe / $vorschau_orig_breite);
	}
	if($breite_vorschau > $vorschau_orig_breite) {
		$breite_vorschau = $vorschau_orig_breite;
	}
}

// Hoehe Play Icon
$play_icon = OOMedia::getMediaByName("play_icon.png");
$play_icon_orig_breite = $play_icon -> getWidth();
$play_icon_orig_hoehe = $play_icon -> getHeight();

$icon_hoehe = $hoehe_vorschau;
if($breite_vorschau < $hoehe_vorschau) {
	$icon_hoehe = $breite_vorschau;
}
$icon_hoehe -= round($icon_hoehe * 0.2);
$position_play_icon = round(($hoehe_vorschau - $icon_hoehe) / 2);
// ENDE Berechungen

// Zufallszahl fuer Ausgabe falls mehrere Media Module auf einer Seite sind
srand((double)microtime() * 1000000);
$random = rand (100, 900) . rand (100, 900); 

print "<div id='lytebox-thumb' style='margin: 10px; position:relative; width: ". $breite_vorschau ."px; height: ". $hoehe_vorschau ."px; background-color: black'>";
print '<a class="lytebox" rel="lytebox[lb'. $random	. ']" data-lyte-options="width:'.
		$breite_media .'px height:'. $hoehe_media .'px" '
		.'href="'. $REX['HTDOCS_PATH'] .'files/'. trim("REX_MEDIA[1]") . '" >';
if($vorschaubild instanceof OOMedia) {
	print '<img src="'. $REX['HTDOCS_PATH'] .'index.php?rex_resize='. $breite_vorschau .'w__'. $vorschaubild -> getFileName() .'" />';
}

print "<span style=' opacity: 0.75; ".
		"width: 100%; position: absolute; bottom: 0px; left: 0px; text-align: center; ".
		"height: ". $hoehe_vorschau ."px;'>";
print "<img src='". $REX['HTDOCS_PATH'] ."index.php?rex_resize=". $icon_hoehe ."h__".
		$play_icon -> getFileName() ."' style='padding-top: ". $position_play_icon ."px'>";
print "</span>";

print '</a></div>'. "\n";
?>
