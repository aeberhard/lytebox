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

	@include('../config.inc.php');
	if (!isset($rxa_lytebox['name'])) {
		echo '<font color="#cc0000"><strong>Fehler! Eventuell wurde die Datei config.inc.php nicht gefunden!</strong></font>';
		return;
	}
?>