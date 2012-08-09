<?php
/**
 * --------------------------------------------------------------------
 *
 * Redaxo Addon: Lytebox
 * Version: 1.0, 02.07.2008
 *
 * Autor: Andreas Eberhard, andreas.eberhard@gmail.com
 *        http://rex.andreaseberhard.de
 *
 * Verwendet wird das Script von Markus F. Hay
 * http://www.dolem.com/lytebox/
 *
 * --------------------------------------------------------------------
 */

	unset($rxa_lytebox); 
	include('config.inc.php');
	
	if (!isset($rxa_lytebox['name'])) {
		echo '<font color="#cc0000"><strong>Fehler! Eventuell wurde die Datei config.inc.php nicht gefunden!</strong></font>';
		return;
	}

	// Dateien aus dem Ordner files/lytebox löschen
	if (isset($rxa_lytebox['filesdir']) and ($rxa_lytebox['filesdir']<>'') and ($rxa_lytebox['name']<>'') ) {
		if ($dh = opendir($rxa_lytebox['filesdir'])) {
			while ($el = readdir($dh)) {
				$path = $rxa_lytebox['filesdir'].'/'.$el;
				if ($el != '.' && $el != '..' && is_file($path)) {
					@unlink($path);
				}
			}
		}
	}
	@closedir($dh);
	@rmdir($rxa_lytebox['filesdir']);	
	
	// Evtl Ausgabe einer Meldung
	// De-Installation nicht erfolgreich
	if ( $rxa_lytebox['meldung']<>'' ) {
		$REX['ADDON']['installmsg'][$rxa_lytebox['name']] = '<br /><br />'.$rxa_lytebox['meldung'].'<br /><br />';
		$REX['ADDON']['install'][$rxa_lytebox['name']] = 1;
	// De-Installation erfolgreich
	} else {
		$REX['ADDON']['install'][$rxa_lytebox['name']] = 0;
	}
?>