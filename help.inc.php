<?php
/**
 * --------------------------------------------------------------------
 *
 * Redaxo Addon: Lytebox
 * Version: 1.1, 14.10.2011
 *
 * Autor: Tobias Krais, http://www.design-to-use.de
 *
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

	include('config.inc.php');
	if (!isset($rxa_lytebox['name'])) {
		echo '<font color="#cc0000"><strong>Fehler! Eventuell wurde die Datei config.inc.php nicht gefunden!</strong></font>';
		return;
	}
		
	echo $rxa_lytebox['i18n']->msg('text_help_title');
	$i=1;
	while ($rxa_lytebox['i18n']->msg('text_help_'.$i)<>'[translate:text_help_'.$i.']') {
		echo $rxa_lytebox['i18n']->msg('text_help_'.$i);
		$i++;
		if ($i>10) { break; }
	}
?>
