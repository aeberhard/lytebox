<?php
/**
 * --------------------------------------------------------------------
 *
 * Modul-Output: Beispielmodul für Addon Lytebox
 *
 * Autor: Andreas Eberhard, andreas.eberhard@gmail.com
 *        http://rex.andreaseberhard.de
 *		  Tobias Krais, http://www.design-to-use.de
 *
 * --------------------------------------------------------------------
 */

	unset($rxmodule);

	// REDAXO-Version
	$rxmodule['rexversion'] = isset($REX['VERSION']) ? $REX['VERSION'] . $REX['SUBVERSION']  : $REX['version'] . $REX['subversion'];

	// Bilddateien aus Medialist
	$rxmodule['imagelist'] = explode(',', trim("REX_MEDIALIST[1]"));

	// maximale Bildgröße
	$rxmodule['imgsize'] = trim("REX_VALUE[1]");
	if ($rxmodule['imgsize']=='')
	{
		$rxmodule['imgsize'] = '128a';
	}

	// CSS-Klasse
	$rxmodule['cssclass'] = trim("REX_VALUE[2]");

	// Zufallszahl für Ausgabe
	srand((double)microtime()*1000000);
	$rxmodule['random'] = rand (100,900) . rand (100,900); 

	// Links für die Bilder ausgeben
	foreach ($rxmodule['imagelist'] as $rxmodule['file']) {

		$rxmodule['media'] = OOMedia::getMediaByName($rxmodule['file']);

		if ($rxmodule['media']) {
			if ( in_array($rxmodule['rexversion'], array('3.01', '3.11', '32')) ) { // REDAXO 3.2.x, REDAXO 3.01, REDAXO 3.11
				$rxmodule['mediatitle'] = str_replace(array("\r\n", "\n", "\r"), ' ', $rxmodule['media']->getTitle());
			}
			if ( in_array($rxmodule['rexversion'], array('40', '41', '42', '43')) ) { // REDAXO 4.0.x, 4.1.x, 4.2.x
				$rxmodule['mediatitle'] = str_replace(array("\r\n", "\n", "\r"), ' ', $rxmodule['media']->getValue('title'));
			}
			if (trim($rxmodule['mediatitle']=='') or !$rxmodule['mediatitle']) {
				$rxmodule['mediatitle'] = $rxmodule['file'];
			}
			echo '<a class="' . $rxmodule['cssclass'] . '" rel="lytebox[lb' . $rxmodule['random']
					. ']" data-lyte-options="slide:true group:'. $rxmodule['random'] .'" '
					. 'href="' . $REX['HTDOCS_PATH'] . 'files/' . $rxmodule['file'] 
					. '" title="' . $rxmodule['mediatitle'] . '">';
			echo '<img src="' . $REX['HTDOCS_PATH'] . 'index.php?rex_resize=' . $rxmodule['imgsize'] . '__' . $rxmodule['file'] . '" alt="' . $rxmodule['mediatitle'] . '" />';
			echo '</a>' . "\n";
		}
	}
?>
