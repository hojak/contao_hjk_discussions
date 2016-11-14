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
        'dataContainer'               => 'Table',
        'enableVersioning'            => false,
        'ptable'                      => 'tl_hjk_discussions_group',
        //'notDeletable'                => true,
        'notCopyable'                 => true,

        'sql' => array
        (
            'keys' => array
            (
                'id'            => 'primary',
                'discussion_id' => 'index',
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 1,
            'fields'                  => array('date_posted DESC'),
            'flag'                    => 1,
        ),
        'label' => array (
            'showColumns'       => true,
            'fields'            => array ('date_posted','member','subject'),
            'label_callback'    => array ('tl_hjk_discussions_post', 'getRowLabel'),
        ),
        'global_operations' => array
        (
        ),
        'operations' => array
		(
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_hjk_discussions_post']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),

            'toggle' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_hjk_discussions_post']['toggle'],
                'icon'                => 'visible.gif',
                'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback'     => array('tl_hjk_discussions_post', 'toggleIcon')
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
        'default'                     => '{content_legend},subject,content;{admin_legend},published;'
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
        'pid' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_post']['pid'],
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            "relation"                => array ("type" => "hasOne", 'load' => "eager" ),
            "foreignKey"              => 'tl_hjk_discussions_group.name',
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'parent_type' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_post']['parent_type']['label'],
            'sql'                     => "varchar(255) NOT NULL default 'module'",
            'inputType'               => 'select',
            'exclude'                 => true,
            'options'                 => array (
                'module'                 => &$GLOBALS['TL_LANG']['tl_hjk_discussions_post']['parent_type']['module'],
                'page'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_post']['parent_type']['page'],
                'url'                    => &$GLOBALS['TL_LANG']['tl_hjk_discussions_post']['parent_type']['url'],
            ),
        ),
        'discussion_id' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_post']['discussion_id'],
            'sql'                     => "varchar(255) NOT NULL default ''",
            'inputType'               => 'text',
            'exclude'                 => true,
        ),
        /*
        'discussion_order' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_post']['discussion_order'],
             'exclude'                 => true,
             'sql'                     => "int(10) unsigned NOT NULL default '0'",
        ),
         * */

           
        'reply_to' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_post']['reply_to'],
            'sql'                     => "int(10) unsigned NULL",
            'relation'                => array ('type' => 'hasOne', 'load' => 'lazy' ),
            'foreignKey'              => 'tl_hjk_discussions_post.id',
            'exclude'                 => true,
        ),
        /*
        'reply_depth' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_post']['reply_depth'],
            'sql'                     => "int(10) unsigned NULL",
            'exclude'                 => true,
        ),*/

        'member' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_post']['member'],
            'foreignKey'              => 'tl_member.username',
            'relation'                => array ('type' => 'hasOne', 'load' => 'eager' ),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'inputType'               => 'select',
        ),
        'date_posted' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_post']['date_posted'],
            'inputType'               => 'text',
            'exclude'                 => true,
            'eval'                    => array('rgxp'=>'datim'),
            'sql'                     => "int(10) NULL",
            'default'                 => time(),
        ),
        'published' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_post']['published'],
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('doNotCopy'=>true),
            'sql'                     => "char(1) NOT NULL default ''",
        ),
        'subject' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_post']['subject'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255),
            'sql'                     => 'varchar(255) NULL',
        ),
        'content' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_post']['content'],
            'inputType'               => 'textarea',
            'eval'                    => array('mandatory'=>true),
            'sql'                     => 'text NULL',
            'search'                  => true,
        ),
        'page_url' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_discussions_post']['page_url'],
            'inputType'               => 'text',
            'eval'                    => array(),
            'sql'                     => 'varchar(255) NULL',
            'search'                  => true,
        ),

    )
);



class tl_hjk_discussions_post extends Backend {


    public function getRowLabel ( $arrRow ) {
        $member = \MemberModel::findById ( $arrRow['member']);
        return array (
            date ( 'd.m.Y H:i', $arrRow['date_posted']),
            $member->username,
            $arrRow['subject'],
        );
    }


    public function toggleVisibility ( $id, $bVisible, DataContainer $dc = null ) {
        $post = HJK\Discussions\HjkDiscussionsPostModel::findById ( $id );

        $post->published = $bVisible;
        $post->save();
    }


    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
        if (strlen(Input::get('tid')))
        {
            $this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
            $this->redirect($this->getReferer());
        }

        $href .= '&amp;id='.Input::get('id').'&amp;tid='.$row['id'].'&amp;state='.!$row['published'];

        if (! $row['published'])
        {
                $icon = 'invisible.gif';
        }

        return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label, 'data-state="' . ($row['published'] ? 1 : 0) . '"').'</a> ';
    }



}
