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
?>

<table border="0" width="770" class="rex-table">
  <tr>
    <td class="grey" style="padding:10px;">
<strong>Modul-Input:</strong><br /><br />
<textarea cols="50" rows="12" style="width:80%;">
<?php 
	echo htmlspecialchars(file_get_contents($rxa_lytebox['path'].'/modul-input.txt'));
?>
</textarea>
    </td>
  </tr>
  <tr>
    <td class="grey" style="padding:10px;">
<strong>Modul-Output:</strong><br /><br />
<textarea cols="50" rows="12" style="width:80%;">
<?php 
	echo htmlspecialchars(file_get_contents($rxa_lytebox['path'].'/modul-output.txt'));
?>
</textarea>
    </td>
  </tr>
</table>