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
		$REX['ADDON']['install'][$rxa_lytebox['name']] = 0;
		return;
	}

	// Verzeichnis files/lytebox anlegen
	if ( !@is_dir($rxa_lytebox['filesdir']) ) {
		if ( !@mkdir($rxa_lytebox['filesdir']) ) {
			$rxa_lytebox['meldung'] .= $rxa_lytebox['i18n']->msg('error_createdir', $rxa_lytebox['filesdir']);
		}
	}

	// Dateien ins Verzeichnis files/lytebox kopieren
	if ($dh = opendir($rxa_lytebox['sourcedir'])) {
		while ($el = readdir($dh)) {
			$rxa_lytebox['file'] = $rxa_lytebox['sourcedir'].'/'.$el;
			if ($el != '.' && $el != '..' && is_file($rxa_lytebox['file'])) {
				if ( !@copy($rxa_lytebox['file'], $rxa_lytebox['filesdir'].'/'.$el) ) {
					$rxa_lytebox['meldung'] .= $rxa_lytebox['i18n']->msg('error_copyfile', $el, $REX['HTDOCS_PATH'].'files/'.$rxa_lytebox['name'].'/');
				}
			}
		}
	} else {
		$rxa_lytebox['meldung'] .= $rxa_lytebox['i18n']->msg('error_readdir',$rxa_lytebox['sourcedir']);
	}
	
	// Evtl Ausgabe einer Meldung
	// $rxa_lytebox['meldung'] = 'Das Addon wurde nicht installiert, weil...';
	if ( $rxa_lytebox['meldung']<>'' ) {
		$REX['ADDON']['installmsg'][$rxa_lytebox['name']] = '<br /><br />'.$rxa_lytebox['meldung'].'<br /><br />';
		$REX['ADDON']['install'][$rxa_lytebox['name']] = 0;
	} else {
	// Installation erfolgreich
		$REX['ADDON']['install'][$rxa_lytebox['name']] = 1;
	}
?>
