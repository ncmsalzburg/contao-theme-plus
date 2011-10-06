<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Theme+
 * Copyright (C) 2010,2011 InfinitySoft <http://www.infinitysoft.de>
 *
 * Extension for:
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  2010,2011 InfinitySoft <http://www.infinitysoft.de>
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    Theme+
 * @license    LGPL
 */


/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_layout']['theme_plus_exclude_contaocss']     = array('Contao Core CSS nicht einbinden', 'Deaktiviert die Contao Core CSS (contao.css).');
$GLOBALS['TL_LANG']['tl_layout']['theme_plus_exclude_frameworkcss']  = array('Contao Framework CSS nicht einbinden', 'Deaktiviert den Contao Framework CSS Code.');
$GLOBALS['TL_LANG']['tl_layout']['theme_plus_stylesheets']           = array('Weitere Stylesheets', 'Weitere Stylesheets in das Layout einbinden');
$GLOBALS['TL_LANG']['tl_layout']['theme_plus_javascripts']           = array('Weitere JavaScripts', 'Weitere JavaScripts in das Layout einbinden');
$GLOBALS['TL_LANG']['tl_layout']['theme_plus_exclude_files']         = array('Dateien filtern', 'Dateien, bpsw. aus Plugins können mit diesem Feature deaktiviert werden. Geben Sie dazu jeden Dateipfad einzeln in ein Feld ein. Auf globaler Ebene kann dies auch über das Array <code>$GLOBALS[\'TL_THEME_EXCLUDE\']</code> erfolgen, z.B. <code>$GLOBALS[\'TL_THEME_EXCLUDE\'][] = \'system/contao.css\';</code>.', '');

?>