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
 * Table tl_hjk_discussions_post
 */
$GLOBALS['TL_DCA']['tl_hjk_discussions_post'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'table',
		'enableVersioning'            => false,
		'ptable'                      => 'tl_hjk_discussions_group',
		// 'notEditable'                 => true,
		//'notDeletable'                => true,
		'notCopyable'                 => true,
		// 'notCreatale'                 => true,
		'doNotCopyRecords'            => true,
        //'switchToEdit'                => true,
		
		'sql' => array
		(
			'keys' => array
			(
				'id'        => 'primary',
                'thread_id' => 'index',
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('date_cancelled, date_confirmed desc, date_applied, member'),
			'flag'                    => 11,
            'headerFields'            => array ('pid','start','instructor', 'no_of_slots'),
            'child_record_callback'   => array('tl_hjk_bookings_application', 'childRecordCallback'),
            'disableGrouping'         => true,
            
		),
		'global_operations' => array
		(
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_hjk_bookings_application']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
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
		'default'                     => '{general_legend},member,date_applied;{admin_legend:hide},date_cancelled,cancelled_by_admin,date_confirmed,date_cancel_latest,accounting;'
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
		'thread_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_bookings_application']['member'],
			'foreignKey'              => 'tl_member.username',
			'relation'                => array ('type' => 'hasOne', 'load' => 'eager' ),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'inputType'               => 'select',
            'eval'                    => array ('mandatory' => true,'includeBlankOption' => true),
            'options_callback'         => array ('tl_hjk_bookings_application','memberOptions'),
		),
		'reply_to' => array (
		),
		'member' => array (
		),
        'date_posted' => array (
        ),
        'date_confirmed' => array (
        ),
        'subject' => array (
        ),
        'content' => array (
        ),
        'thread_order' => array (
        ),

	)
);




class tl_hjk_bookings_application extends Backend {
    


}