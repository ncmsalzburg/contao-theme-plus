<?php

/**
 * Theme+ - Theme extension for the Contao Open Source CMS
 *
 * Copyright (C) 2013 bit3 UG <http://bit3.de>
 *
 * @package    Theme+
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @link       http://www.themeplus.de
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace ThemePlus\DataContainer;

use ContaoAssetic\Model\FilterModel;
use ContaoAssetic\Model\FilterChainModel;
use Ikimea\Browser\Browser;

/**
 * Class ThemePlus
 */
class File
	extends \Backend
{
	public function __construct()
	{
		parent::__construct();
	}

	static public function renderFilterRules(array $row)
	{
		if (strlen($row['filter'])) {
			$rules      = deserialize($row['filterRule'], true);
			$conditions = array();
			foreach ($rules as $rule) {
				$condition = array();

				if (!empty($rule['system'])) {
					$condition[] = $rule['system'];
				}
				if (!empty($rule['browser'])) {
					if (!empty($rule['comparator']) && !empty($rule['browser_version'])) {
						switch ($rule['comparator']) {
							case 'lt':
								$rule['comparator'] = '<';
								break;
							case 'lte':
								$rule['comparator'] = '<=';
								break;
							case 'gte':
								$rule['comparator'] = '>=';
								break;
							case 'gt':
								$rule['comparator'] = '>';
								break;
						}
						$condition[] = sprintf(
							'%s %s %s',
							$rule['browser'],
							$rule['comparator'],
							$rule['browser_version']
						);
					}
					else {
						$condition[] = $rule['browser'];
					}
				}
				if (!empty($rule['platform'])) {
					$condition[] = $GLOBALS['TL_LANG']['tl_theme_plus_filter'][$rule['platform']];
				}

				$condition = implode(' and ', $condition);

				if ($rule['invert']) {
					$condition = sprintf(
						'not (%s)',
						$condition
					);
				}

				$conditions[] = $condition;
			}

			return sprintf(
				'[%s]',
				implode(' or ', $conditions)
			);
		}
		return '';
	}

	/**
	 * List an file
	 *
	 * @param array
	 *
	 * @return string
	 */
	public function listFile($row)
	{
		switch ($row['type']) {
			case 'code':
				$label = $row['code_snippet_title'];
				break;

			case 'url':
				$label = preg_replace('#/([^/]+)$#', '/<strong>$1</strong>', $row['url']);
				break;

			case 'file':
				if ($row['filesource'] == $GLOBALS['TL_CONFIG']['uploadPath'] && version_compare(VERSION, '3', '>=')) {
					$file = (version_compare(VERSION, '3.2', '>=') ? \FilesModel::findByUuid($row['file']) : \FilesModel::findByPk($row['file']));

					if ($file) {
						$label = preg_replace('#/([^/]+)$#', '/<strong>$1</strong>', $file->path);
						break;
					}
				}
				else {
					$label = preg_replace('#([^/]+)$#', '<strong>$1</strong>', $row['file']);
					break;
				}

			default:
				$label = '?';
		}

		if (strlen($row['position'])) {
			$label = '[' . strtoupper($row['position']) . '] ' . $label;
		}

		if (strlen($row['cc'])) {
			$label .= ' <span style="padding-left: 3px; color: #B3B3B3;">[' . $row['cc'] . ']</span>';
		}

		$filterRules = static::renderFilterRules($row);
		if ($filterRules) {
			$label .= sprintf(
				'<br><span style="margin-left: 20px; padding-left: 3px; color: #B3B3B3;">[%s]</span>',
				$filterRules
			);
		}

		$image = 'system/modules/theme-plus/assets/images/' . $row['type'] . '.png';

		return '<div>' . ($image
			? $this->generateImage(
				$image,
				$label,
				'style="vertical-align:-3px"'
			) . ' '
			: '') . $label . "</div>\n";

	}

	protected function buildAsseticFilterOptions($type)
	{
		$this->loadLanguageFile('assetic');

		$options = array();

		$filterChain = FilterChainModel::findBy(
			'type',
			$type,
			array('order' => 'type')
		);
		if ($filterChain) {
			while ($filterChain->next()) {
				$label = '[';
				$label .= $GLOBALS['TL_LANG']['tl_assetic_filter_chain']['types'][$filterChain->type]
					? : $filterChain->type;
				$label .= '] ';
				$label .= $filterChain->name;

				$GLOBALS['TL_LANG']['assetic']['chain:' . $filterChain->id] = $label;

				$options['chain'][] = 'chain:' . $filterChain->id;
			}
		}

		$filter = FilterModel::findAll(array('order' => 'type'));
		if ($filter) {
			while ($filter->next()) {
				if (!in_array(
					$filter->type,
					$GLOBALS['ASSETIC'][$type]
				)
				) {
					continue;
				}

				$label = $GLOBALS['TL_LANG']['assetic'][$filter->type]
					? : $filter->type;

				if ($filter->note) {
					$label .= ' [' . $filter->note . ']';
				}

				$GLOBALS['TL_LANG']['assetic']['filter:' . $filter->id] = $label;

				$options['filter'][] = 'filter:' . $filter->id;
			}
		}

		return $options;
	}

	protected function filterBrowserProperties($prefix)
	{
		$options   = array();
		$regexp    = '#^' . preg_quote($prefix) . '#';
		$class     = new \ReflectionClass('Ikimea\Browser\Browser');
		$constants = $class->getConstants();

		foreach ($constants as $name => $value) {
			if (preg_match($regexp, $name)) {
				$options[$value] = $value;
			}
		}

		uksort($options, 'strcasecmp');

		return $options;
	}

	public function changeFileSource($dc)
	{
		$file = \Database::getInstance()
			->query('SELECT * FROM ' . $dc->table . ' WHERE id=' . intval($dc->id));
		if ($file->type == 'file') {
			if ($file->filesource != $GLOBALS['TL_CONFIG']['uploadPath'] && version_compare(VERSION, '3', '>=')) {
				$GLOBALS['TL_DCA'][$dc->table]['fields']['file']['inputType'] = 'fileSelector';
			}
			$GLOBALS['TL_DCA'][$dc->table]['fields']['file']['eval']['path'] = $file->filesource;
		}
	}

	public function getSystems()
	{
		return $this->filterBrowserProperties('PLATFORM_');
	}

	public function getBrowsers()
	{
		return $this->filterBrowserProperties('BROWSER_');
	}

	public function listLayouts()
	{
		$layout = \Database::getInstance()
			->query(
				'SELECT l.*, t.name AS theme
				 FROM tl_layout l
				 INNER JOIN tl_theme t
				 ON t.id=l.pid
				 ORDER BY t.name, l.name');

		$options = array();

		while ($layout->next()) {
			$options[$layout->theme][$layout->id] = $layout->name;
		}

		return $options;
	}

	public function loadLayoutsFor($field, $dc)
	{
		$layout = \Database::getInstance()
			->query('SELECT * FROM tl_layout');

		$values = array();

		while ($layout->next()) {
			$selected = deserialize($layout->$field, true);
			if (in_array($dc->id, $selected)) {
				$values[] = $layout->id;
			}
		}

		return $values;
	}

	public function saveLayoutsFor($field, $value, $dc)
	{
		$layouts = deserialize($value, true);

		$layout = \Database::getInstance()
			->query('SELECT * FROM tl_layout');

		while ($layout->next()) {
			$selected = deserialize($layout->$field, true);

			// select a new layout
			if (in_array($layout->id, $layouts) && !in_array($dc->id, $selected)) {
				$selected[] = $dc->id;
			}

			// deselect a layout
			else if (!in_array($layout->id, $layouts) && in_array($dc->id, $selected)) {
				$index = array_search($dc->id, $selected);
				unset($selected[$index]);
			}

			// nothing changed
			else {
				continue;
			}

			\Database::getInstance()
				->prepare('UPDATE tl_layout %s WHERE id=?')
				->set(array($field => serialize(array_values($selected))))
				->execute($layout->id);
		}

		return null;
	}
}
