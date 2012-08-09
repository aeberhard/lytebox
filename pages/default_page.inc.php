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

/**
 * Options für die Selectbox aufbauen
 */
function add_cat_options(&$rxa_addon, &$select, &$cat, &$cat_ids, $groupName = '', $nbsp = '')
{
	global $REX_USER;
	if (empty($cat)) {
		return;
	}

	$cat_ids[] = $cat->getId();
	if( $REX_USER->isValueOf("rights","admin[]") || $REX_USER->isValueOf("rights","csw[0]") || $REX_USER->isValueOf("rights","csr[".$cat->getId()."]") || $REX_USER->isValueOf("rights","csw[".$cat->getId()."]") )
	{
		$sed = '';
		if (in_array($cat->getId(), $rxa_addon['cats']))
		{
			$sed  = ' selected="selected"';
		}
		$select .= '<option value="'.$cat->getId().'"'.$sed.'>' . $nbsp . $cat->getName();
		$select .= '</option>'."\n";

		$rxa_addon['catselectcount']+=1;

		$childs = $cat->getChildren();
		if (is_array($childs))
		{
			$nbsp = $nbsp.'&nbsp;&nbsp;&nbsp;&nbsp;';
			foreach ( $childs as $child)
			{
				add_cat_options($rxa_addon, $select, $child, $cat_ids, $cat->getName(), $nbsp);
			}
		}
	}
}

/**
 * Root-Artikel in Selectbox übernehmen
 */
function add_rootart_options($rxa_addon, &$select, $clang)
{
	$artroot = OOArticle::getRootArticles(false, $clang);
	if (count($artroot) > 0) {

		$select .= '<optgroup label="'.$rxa_addon['i18n']->msg('text_rootarticles').'">'."\n";

		foreach (OOArticle::getRootArticles(false, $clang) as $artroot)
		{
			$sed = '';
			if (in_array($artroot->getId().'r', $rxa_addon['cats']))
			{
				$sed  = ' selected="selected"';
			}
			$select .= '<option value="'.$artroot->getId().'r'.'"'.$sed.'>' . $artroot->getName();
			$select .= '</option>'."\n";
		}

		$select .= '</optgroup>'."\n";
	}
}

/**
 * Auswahl speichern
 */
	if ( isset($_POST['function']) and ($_POST['function']=='save') ) {
		if (isset($_POST['allcats'])) {
			$allcats = $_POST['allcats'];
		} else {
			$allcats = '';
		}
		if (trim($allcats=='')) $allcats = 0;

		if (isset($_POST['subcats'])) {
			$subcats = $_POST['subcats'];
		} else {
			$subcats = '';
		}
		if (trim($subcats=='')) $subcats = 0;

		$line = $allcats.','.$subcats."\n";
		if (isset($_POST['category_select'])) {
			$line .= serialize($_POST['category_select'])."\n";
		} else {
			$line .= "N;\n";
		}

		if (($fh = fopen($rxa_lytebox['path'].'/'.$rxa_lytebox['name'].'.ini', 'w')) === FALSE) {
			$rxa_lytebox['meldung'] = $rxa_lytebox['i18n']->msg('error_save',$rxa_lytebox['path'].'/'.$rxa_lytebox['name'].'.ini');
		} else {
			@fwrite($fh, $line);
			@fclose($fh);	
			$rxa_lytebox['meldung'] = $rxa_lytebox['i18n']->msg('msg_saved');
		}
	}

/**
 * Auswahl laden
 */
	if (($lines = file($rxa_lytebox['path'].'/'.$rxa_lytebox['name'].'.ini')) === FALSE) {
		$rxa_lytebox['meldung'] = $rxa_lytebox['i18n']->msg('error_read',$rxa_lytebox['path'].'/'.$rxa_lytebox['name'].'.ini');
	} else {
		$va = explode(',', trim($lines[0]));
		$allcats = trim($va[0]);
		$subcats = trim($va[1]);
		$rxa_lytebox['cats'] = unserialize(trim($lines[1]));
	}
	if (!is_array($rxa_lytebox['cats'])){
		$rxa_lytebox['cats'] = array();
	}
	
/**
 * Select-Klasse erstellen und mit "Leben" füllen
 */
	$cat_ids[] = '';
	$cat='0';
   $rxa_lytebox['catselectcount'] = 0;

   $select_cats = "\n";
	if ($cats = OOCategory::getRootCategories())
	{
		foreach( $cats as $cat)
		{
			add_cat_options($rxa_lytebox, $select_cats, $cat, $cat_ids);
		}
	}
	//Artikel aus dem Root ebenso in die Auswahl (selectbox) übernehmen
	add_rootart_options($rxa_lytebox, $select_cats, $clang);

	$selsize = $rxa_lytebox['catselectcount'] / 3;
	($selsize <= 15) ? $selsize = 15 : ( ($selsize >= 25) ? $selsize = 25 : $selsize = $selsize );

   $select_cats = '<select name="category_select[]" size="'.$selsize.'" id="id_category_select" style="width:100%;" multiple="multiple">'."\n" . $select_cats;
   $select_cats .= '</select>'."\n";
?>

<form action="index.php?page=<?php echo $rxa_lytebox['name']; ?>" method="post">
<input type="hidden" name="function" value="save" />

    <table border="0" width="770" class="rex-table">
      <tr>
        <td class="grey" style="padding:10px;">

<?php
	if ($rxa_lytebox['meldung']<>'') echo $rxa_lytebox['meldung'].'<br />';
	echo $rxa_lytebox['i18n']->msg('text_settings_intro');
?>
        <br /><br />

        <input type="checkbox" id="allcats" name="allcats" value="1" <?php if ($allcats == "1") echo "checked"; ?> />
		  <label for="allcats"><?php echo $rxa_lytebox['i18n']->msg('text_settings_allcats'); ?></label>
        <br />
        
        <input type="checkbox" id="subcats" name="subcats" value="1" <?php if ($subcats == "1") echo "checked"; ?> />
		  <label for="subcats"><?php echo $rxa_lytebox['i18n']->msg('text_settings_subcats'); ?></label>
        <br /><br />

<?php echo $rxa_lytebox['i18n']->msg('text_settings_help'); ?>

<?php
	echo $select_cats;
?>
        <br /><br />
        <input type="submit" value="<?php echo $rxa_lytebox['i18n']->msg('button_save'); ?>" />

        </td>
      </tr>
    </table>

</form>
