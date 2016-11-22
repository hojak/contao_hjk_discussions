<?php

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{hjk_discussions_legend}'
    .',hjk_discussions_admin_email';
  


        
$GLOBALS['TL_DCA']['tl_settings']['fields']['hjk_discussions_admin_email'] = array
(
  'label'         => &$GLOBALS['TL_LANG']['tl_settings']['hjk_discussions_admin_email'],
  'exclude'       => true,
  'inputType'     => 'text',
  'eval'          => array(),
  'default'       => '',
);