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
 * Table tl_hjk_discussions_watch
 */
$GLOBALS['TL_DCA']['tl_hjk_discussions_watch'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => false,
		'doNotCopyRecords'            => true,
		
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
			'fields'                  => array('user', 'member'),
			'flag'                    => 1
		),
        'label' => array (
            'showColumns'     => true,
            'fields'          => array ('user', 'member', 'discussion_group','uri'),
            'label_callback'  => array ('tl_hjk_discussions_watch', 'getRowLabel' ),
        ),
		'global_operations' => array
		(
		),
		'operations' => array
		(
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_hjk_discussions_watch']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(''),
		'default'                     => '{general_legend},user,discussion_group;'
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
		'member' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_watch']['member'],
			'foreignKey'              => 'tl_member.username',
			'relation'                => array ('type' => 'hasOne', 'load' => 'eager' ),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'inputType'               => 'select',
		),
        'parent_type' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_watch']['parent_type'],
            'sql'                     => "varchar(255) NULL",
            'exclude'                 => true,
        ),
        'discussion_id' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_watch']['discussion_id'],
            'sql'                     => "varchar(255) NULL",
            'inputType'               => 'text',
            'exclude'                 => true,
        ),
        'uri' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_watch']['uri'],
            'sql'                     => "varchar(255) NULL",
            'inputType'               => 'text',
            'exclude'                 => true,        
        ),
		'user' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_watch']['user'],
			'foreignKey'              => 'tl_user.username',
			'relation'                => array ('type' => 'hasOne', 'load' => 'eager' ),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'eval'                    => array ('includeBlankOption' => true, 'mandatory' => true,),
            'inputType'               => 'select',
		),        
        'discussion_group' => array (
			'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_watch']['discussion_group'],
			'foreignKey'              => 'tl_hjk_discussions_group.name',
			'relation'                => array ('type' => 'hasOne', 'load' => 'eager' ),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'eval'                    => array ('includeBlankOption' => true, 'mandatory' => true,),
            'inputType'               => 'select',        
        ),
        /*
         * 'module' ?
         */
        /*
        'general' => array (
        ),
         **/
    ),
);



class tl_hjk_discussions_watch {
    
	/**
	 * callback for the display of each table row in the backend overview
	 * @param <unknown> $row
	 * @param <unknown> $label
	 * @param \DataContainer $dc
	 * @param <unknown> $args
	 * @return
	 */
	public function getRowLabel ($row, $label, DataContainer $dc, $args ) {
        $watch = \HJK\Discussions\HjkDiscussionsWatchModel::findById ( $row['id']);
        
        return array (
            $watch->getRelated('user')->username,
            $watch->getRelated('member')->username,
            $watch->getRelated('discussion_group')->name,
            $watch->discussion_id
        );
    }
    
    
}