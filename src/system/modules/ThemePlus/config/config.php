<?php

/**
 * Theme+ - Theme extension for the Contao Open Source CMS
 *
 * Copyright (C) 2012 InfinitySoft <http://www.infinitysoft.de>
 *
 * @package    Theme+
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @link       http://www.themeplus.de
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Back end modules
 */
$GLOBALS['BE_MOD']['design']['themes']['tables'][] = 'tl_theme_plus_file';
$GLOBALS['BE_MOD']['design']['themes']['tables'][] = 'tl_theme_plus_variable';


/**
 * Front end modules
 */
$GLOBALS['FE_MOD']['includes']['script_source'] = 'InfinitySoft\ThemePlus\Hybrid\JavaScript';


/**
 * Content elements
 */
$GLOBALS['TL_CTE']['includes']['script_source'] = 'InfinitySoft\ThemePlus\Hybrid\JavaScript';


/**
 * Settings
 */
$GLOBALS['TL_CONFIG']['theme_plus_exclude_contaocss'] = '';
$GLOBALS['TL_CONFIG']['theme_plus_exclude_mootools']  = '';
$GLOBALS['TL_CONFIG']['theme_plus_lesscss_mode']      = 'phpless';
$GLOBALS['TL_CONFIG']['css_embed_images']             = 16384;


/**
 * HOOKs
 */
//$GLOBALS['TL_HOOKS']['replaceInsertTags'][]     = array('ThemePlus', 'hookReplaceInsertTags');
//$GLOBALS['TL_HOOKS']['outputBackendTemplate'][] = array('ThemePlus', 'hookOutputBackendTemplate');


/**
 * Page types
 */
$GLOBALS['TL_PTY']['regular'] = 'ThemePlusPageRegular';


/**
 * easy_themes integration
 */
$GLOBALS['TL_EASY_THEMES_MODULES']['theme_plus_stylesheet']     = array
(
	'href_fragment' => 'table=tl_theme_plus_stylesheet',
	'icon'          => 'system/modules/ThemePlus/assets/images/stylesheet.png'
);
$GLOBALS['TL_EASY_THEMES_MODULES']['theme_plus_javascript']     = array
(
	'href_fragment' => 'table=tl_theme_plus_javascript',
	'icon'          => 'system/modules/ThemePlus/assets/images/javascript.png'
);
$GLOBALS['TL_EASY_THEMES_MODULES']['theme_plus_variable'] = array
(
	'href_fragment' => 'table=tl_theme_plus_variable',
	'icon'          => 'system/modules/ThemePlus/assets/images/variable.png'
);


/**
 * Script frameworks
 */
$GLOBALS['TL_SCRIPT_FRAMEWORKS']['mooSource']['moo_googleapis'] = array('ThemePlus', 'addMooGoogleAPIs');
$GLOBALS['TL_SCRIPT_FRAMEWORKS']['mooSource']['moo_local']      = array('ThemePlus', 'addMooLocal');


/**
 * Mime types
 */
$GLOBALS['TL_MIME']['less'] = array('text/css', 'iconCSS.gif');


/**
 * Helper function
 */
if (!function_exists('array_concat')) {
	function array_concat()
	{
		$args  = func_get_args();
		$array = array_shift($args);
		while (count($args))
		{
			$temp = array_shift($args);
			foreach ($temp as $v)
			{
				$array[] = $v;
			}
		}
		return $array;
	}
}