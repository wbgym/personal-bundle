<?php

/**
 * WBGym
 * 
 * Copyright (C) 2017 Webteam Weinberg-Gymnasium Kleinmachnow
 * 
 * @package 	WGBym
 * @version 	0.3.0
 * @author 	    Johannes Cram <johannes@jonesmedia.de>
 * @license 	http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


$GLOBALS['TL_DCA']['tl_module']['palettes']['login'] = str_replace('{template_legend:hide}','{wbgym_legend},wb_settingsPage,wb_vplanPage,wb_profilePage,wb_emailLink,wb_webuntisLink,wb_messengerLink,wb_schulcloudLink;{template_legend:hide}',$GLOBALS['TL_DCA']['tl_module']['palettes']['login']);

$GLOBALS['TL_DCA']['tl_module']['fields']['wb_settingsPage'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['wb_settingsPage'],
	'exclude'           => true,
    'inputType'         => 'pageTree',
    'foreignKey'        => 'tl_page.title',
    'eval'              => array('fieldType'=>'radio', 'tl_class'=>'clr'),
    'relation'          => array('type'=>'hasOne', 'load'=>'lazy'),
    'sql'               => ['type' => 'integer', 'length' => 10, 'default' => 0, 'unsigned' => true]
);

$GLOBALS['TL_DCA']['tl_module']['fields']['wb_vplanPage'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['wb_vplanPage'],
	'exclude'           => true,
    'inputType'         => 'pageTree',
    'foreignKey'        => 'tl_page.title',
    'eval'              => array('fieldType'=>'radio', 'tl_class'=>'clr'),
    'relation'          => array('type'=>'hasOne', 'load'=>'lazy'),
    'sql'               => ['type' => 'integer', 'length' => 10, 'default' => 0, 'unsigned' => true]
);

$GLOBALS['TL_DCA']['tl_module']['fields']['wb_profilePage'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['wb_profilePage'],
	'exclude'           => true,
    'inputType'         => 'pageTree',
    'foreignKey'        => 'tl_page.title',
    'eval'              => array('fieldType'=>'radio', 'tl_class'=>'clr'),
    'relation'          => array('type'=>'hasOne', 'load'=>'lazy'),
    'sql'               => ['type' => 'integer', 'length' => 10, 'default' => 0, 'unsigned' => true]
);

$GLOBALS['TL_DCA']['tl_module']['fields']['wb_emailLink'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['wb_emailLink'],
	'exclude'           => true,
    'inputType'         => 'text',
    'eval'              => array('tl_class'=>'clr'),
    'sql'               => ['type' => 'string', 'length' => 255, 'default' => '']
);

$GLOBALS['TL_DCA']['tl_module']['fields']['wb_schulcloudLink'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['wb_schulcloudLink'],
	'exclude'           => true,
    'inputType'         => 'text',
    'eval'              => array('tl_class'=>'clr'),
    'sql'               => ['type' => 'string', 'length' => 255, 'default' => '']
);

$GLOBALS['TL_DCA']['tl_module']['fields']['wb_webuntisLink'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['wb_webuntisLink'],
	'exclude'           => true,
    'inputType'         => 'text',
    'eval'              => array('tl_class'=>'clr'),
    'sql'               => ['type' => 'string', 'length' => 255, 'default' => '']
);

$GLOBALS['TL_DCA']['tl_module']['fields']['wb_messengerLink'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['wb_messengerLink'],
	'exclude'           => true,
    'inputType'         => 'text',
    'eval'              => array('tl_class'=>'clr'),
    'sql'               => ['type' => 'string', 'length' => 255, 'default' => '']
);
