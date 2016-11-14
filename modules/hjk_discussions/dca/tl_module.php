<?php

/**
 * extend tl_module with palette and fields for the discussion module
 */
 
// palette 
$GLOBALS['TL_DCA']['tl_module']['palettes']['hjk_discussion']  
    = '{title_legend},name,headline,type;'
    .'{discussion_legend},hjk_discussion_group,hjk_discussion_parent_type,hjk_discussion_reply,hjk_discussion_open;'
    //.'{redirect_legend},jumpTo;'
    .'{template_legend:hide},customTpl,hjk_discussion_postTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';


// fields
$GLOBALS['TL_DCA']['tl_module']['fields']['hjk_discussion_group'] = array (
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['hjk_discussion_group'],
    'sql'                     => "int(10) NOT NULL default '0'",
    'eval'                    => array ('mandatory' => true, 'includeBlankOption' => true, 'tl_class' => 'w50'),
    'inputType'               => 'select',
    'relation'                => array ("type" => "hasOne", 'load' => "eager" ),
    'foreignKey'              => 'tl_hjk_discussions_group.name',
    'exclude'                 => true,
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hjk_discussion_parent_type'] = array (
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['hjk_discussion_parent_type']['label'],
    'sql'                     => "varchar(255) NOT NULL default 'module'",
    'inputType'               => 'select',
    'exclude'                 => true,
    'eval'                    => array ('mandatory' => true, 'tl_class' => 'w50', 'includeBlankOption' => true),
    'options'                 => array (
        'module'                 => &$GLOBALS['TL_LANG']['tl_module']['hjk_discussion_parent_type']['module'],
        'page'                   => &$GLOBALS['TL_LANG']['tl_module']['hjk_discussion_parent_type']['page'],
        'url'                    => &$GLOBALS['TL_LANG']['tl_module']['hjk_discussion_parent_type']['url'],
        'globalObj'              => &$GLOBALS['TL_LANG']['tl_module']['hjk_discussion_parent_type']['globalObj'],
    ),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hjk_discussion_reply'] = array (
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['hjk_discussion_reply'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hjk_discussion_open'] = array (
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['hjk_discussion_open'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "char(1) NOT NULL default ''",
    'default'                 => 1,
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hjk_discussion_postTpl'] = array (
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['hjk_discussion_postTpl'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback'        => array('tl_module_hjk_disc', 'getPostTemplates'),
    'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);




class tl_module_hjk_disc extends \tl_module {

    public function getPostTemplates () {
        return $this->getTemplateGroup('mod_hjk_post');
    }

}
