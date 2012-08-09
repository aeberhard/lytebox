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

	// Name des Addons und Pfade
	unset($rxa_lytebox);
	$rxa_lytebox['name'] = 'lytebox';

	$REX['ADDON']['version'][$rxa_lytebox['name']] = '1.8';
	$REX['ADDON']['author'][$rxa_lytebox['name']] = 'Andreas Eberhard';

	$rxa_lytebox['path'] = $REX['INCLUDE_PATH'].'/addons/'.$rxa_lytebox['name'];
	$rxa_lytebox['basedir'] = dirname(__FILE__);
	$rxa_lytebox['lang_path'] = $REX['INCLUDE_PATH']. '/addons/'. $rxa_lytebox['name'] .'/lang';
	$rxa_lytebox['sourcedir'] = $REX['INCLUDE_PATH']. '/addons/'. $rxa_lytebox['name'] .'/'. $rxa_lytebox['name'];
	$rxa_lytebox['filesdir'] = $REX['HTDOCS_PATH'].'files/'.$rxa_lytebox['name'];
	$rxa_lytebox['meldung'] = '';
	$rxa_lytebox['rexversion'] = isset($REX['VERSION']) ? $REX['VERSION'] . $REX['SUBVERSION'] : $REX['version'] . $REX['subversion'];

/**
 * --------------------------------------------------------------------
 * Nur im Backend
 * --------------------------------------------------------------------
 */
	if ($REX['REDAXO']) {
		// Sprachobjekt anlegen
		$rxa_lytebox['i18n'] = new i18n($REX['LANG'],$rxa_lytebox['lang_path']);

		// Anlegen eines Navigationspunktes im REDAXO Hauptmenu
		$REX['ADDON']['page'][$rxa_lytebox['name']] = $rxa_lytebox['name'];
		// Namensgebung für den Navigationspunkt
		$REX['ADDON']['name'][$rxa_lytebox['name']] = $rxa_lytebox['i18n']->msg('menu_link');

		// Berechtigung für das Addon
		$REX['ADDON']['perm'][$rxa_lytebox['name']] = $rxa_lytebox['name'].'[]';
		// Berechtigung in die Benutzerverwaltung einfügen
		$REX['PERM'][] = $rxa_lytebox['name'].'[]';		
	}

/**
 * --------------------------------------------------------------------
 * Outputfilter für das Frontend
 * --------------------------------------------------------------------
 */
	if (!$REX['REDAXO']) {
		rex_register_extension('OUTPUT_FILTER', 'lytebox_opf');

		// Prüfen ob die aktuelle Kategorie mit der Auswahl übereinstimmt
		function lytebox_check_cat($acat, $aart, $subcats, $lytebox_cats)
		{

			// prüfen ob Kategorien ausgewählt
			if (!is_array($lytebox_cats)) return false;

			// aktuelle Kategorie in den ausgewählten dabei?
			if (in_array($acat, $lytebox_cats)) return true;

			// Prüfen ob Parent der aktuellen Kategorie ausgewählt wurde
			if ( ($acat > 0) and ($subcats == 1) )
			{
				$cat = OOCategory::getCategoryById($acat);
				while($cat = $cat->getParent())
				{
					if (in_array($cat->_id, $lytebox_cats)) return true;
				}
			}

			// evtl. noch Root-Artikel prüfen
			if (strstr(implode('',$lytebox_cats), 'r'))
			{
				if (in_array($aart.'r', $lytebox_cats)) return true;
			}

			// ansonsten keine Ausgabe!
			return false;
		}

      // Output-Filter
		function lytebox_opf($params)
		{
			global $REX, $REX_ARTICLE;
			global $rxa_lytebox;

			$content = $params['subject'];
			
			if ( !strstr($content,'</head>') or !file_exists($rxa_lytebox['path'].'/'.$rxa_lytebox['name'].'.ini')
			 or ( strstr($content,'<script type="text/javascript" src="files/lytebox/lytebox.js"></script>') and strstr($content,'<link rel="stylesheet" href="files/lytebox/lytebox.css" type="text/css" media="screen" />') ) ) {
				return $content;
			}

			// Einstellungen aus ini-Datei laden
			if (($lines = file($rxa_lytebox['path'].'/'.$rxa_lytebox['name'].'.ini')) === FALSE) {
				return $content;
			} else {
				$va = explode(',', trim($lines[0]));
				$allcats = trim($va[0]);
				$subcats = trim($va[1]);
				$lytebox_cats = array();
				$lytebox_cats = unserialize(trim($lines[1]));
			}

			// aktuellen Artikel ermitteln
			$artid = isset($_GET['article_id']) ? $_GET['article_id']+0 : 0;
			if ($artid==0) {
//				$artid = $REX_ARTICLE->getValue('article_id') + 0;
			}
			if ($artid==0) { $artid = $REX['START_ARTICLE_ID']; }

			if (!$artid) { return $content; }

			$article = OOArticle::getArticleById($artid);
			if (!$article) { return $content; }

			// aktuelle Kategorie ermitteln
			if ( in_array($rxa_lytebox['rexversion'], array('3.11')) ) {
				$acat = $article->getCategoryId();
			}
			if ( in_array($rxa_lytebox['rexversion'], array('32', '40', '41', '42', '43')) ) {
				$cat = $article->getCategory();
				if ($cat) {
					$acat = $cat->getId();
				}
			}
			// Wenn keine Kategorie ermittelt wurde auf -1 setzen für Prüfung in lytebox_check_cat, Prüfung auf Artikel im Root
			if (!isset($acat) or !$acat) { $acat = -1; }

         // Array anlegen falls keine Kategorien ausgewählt wurden
			if (!is_array($lytebox_cats)){
				$lytebox_cats = array();
			}

			// Code für lytebox im head-Bereich ausgeben
			if ( ($allcats==1) or (lytebox_check_cat($acat, $artid, $subcats, $lytebox_cats) == true) )
			{
				$rxa_lytebox['output'] = '	<!-- Addon Lytebox '.$REX['ADDON']['version'][$rxa_lytebox['name']].' -->'."\n";
				$rxa_lytebox['output'] .= '	<script type="text/javascript" src="files/lytebox/lytebox.js"></script>'."\n";
				$rxa_lytebox['output'] .= '	<link rel="stylesheet" href="files/lytebox/lytebox.css" type="text/css" media="screen" />'."\n";
				$content = str_replace('</head>', $rxa_lytebox['output'].'</head>', $content);
			}

			return $content;
		}
	}
?>
