<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @package   HJK\Discussions
 * @author    Holger Janßen-Kroll
 * @license   proprietär
 * @copyright Holger Janßen-Kroll, 2016 <http://ho-jk.de>
 */


/**
 * Table tl_hjk_discussions_group
 */
$GLOBALS['TL_DCA']['tl_hjk_discussions_group'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => false,
        'ctable'                      => array ( 'tl_hjk_discussions_post'),

		//'notEditable'                 => true,
		//'notDeletable'                => true,
		//'notCopyable'                 => true,
		// 'notCreatale'                 => true,
		'doNotCopyRecords'            => true,
        //'switchToEdit'                => true,
		
		'sql' => array
		(
			'keys' => array
			(
				'id'        => 'primary',
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('date_last_post DESC','name'),
			'flag'                    => 1
		),
        'label' => array (
            'showColumns'     => true,
            'fields'          => array ('name', 'date_last_post'),
            'label_callback'  => array ('tl_hjk_discussions_group', 'getRowLabel'),

        ),
		'global_operations' => array
		(
        
                
            'watches' => array
                (
                    'label'               => &$GLOBALS['TL_LANG']['tl_hjk_discussions_group']['watches'],
                    'href'                => 'table=tl_hjk_discussions_watch',
                    'icon'                => 'visible.gif',
                )
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_hjk_discussions_group']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'show_posts' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_hjk_discussions_group']['show_posts'],
				'href'                => 'table=tl_hjk_discussions_post',
				'icon'                => 'system/modules/hjk_discussions/assets/img/comments.png',
			),
		)
	),

	// Select
	'select' => array
	(
		'buttons_callback' => array()
	),

	// Edit
	'edit' => array
	(
		'buttons_callback' => array()
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(''),
		'default'                     => '{general_legend},name;'
	),

	// Subpalettes
	'subpalettes' => array
	(
		''                            => ''
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),	
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_group']['name'],
			'sql'                     => "varchar(255) NOT NULL default ''",
            'inputType'               => 'text',
            'eval'                    => array ('mandatory' => true ),
            'exclude'                 => true,
		),
        /*
        'allow_bb' => array (
			'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_group']['allow_bb'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'sql'                     => "char(1) NOT NULL default ''",
        ),
         * */
        'date_last_post' => array (
			'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_group']['date_last_post'],
            'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array("rgxp" => "datim"),
			'sql'                     => "int(10) unsigned NULL",
        ),
	)
);




class tl_hjk_discussions_group extends Backend {
    
    public function getRowLabel ( $arrRow  ) {
        return array (
            $arrRow['name'],
            date('d.m.Y H:i', $arrRow['date_last_post'])
        );
    }

}
