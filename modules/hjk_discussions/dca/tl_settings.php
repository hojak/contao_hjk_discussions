<?php

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{hjk_discussions_legend}'
    .',hjk_discussions_notification_enabled';
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'hjk_discussions_notification_enabled';
  
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['hjk_discussions_notification_enabled'] 
    = "hjk_discussions_notification_all,hjk_discussions_notification_sender_name,hjk_discussions_notification_sender_email,"
        ."hjk_discussions_notification_subject,hjk_discussions_notification_mail_template";

  
$GLOBALS['TL_DCA']['tl_settings']['fields']['hjk_discussions_notification_enabled'] = array
(
  'label'         => &$GLOBALS['TL_LANG']['tl_settings']['hjk_discussions_notification_enabled'],
  'exclude'       => true,
  'inputType'     => 'checkbox',
  'eval'          => array('submitOnChange' => true),
  'default'       => false,
);

        
$GLOBALS['TL_DCA']['tl_settings']['fields']['hjk_discussions_notification_sender_name'] = array
(
  'label'         => &$GLOBALS['TL_LANG']['tl_settings']['hjk_discussions_notification_sender_name'],
  'exclude'       => true,
  'inputType'     => 'text',
  'eval'          => array('tl_class' => 'w50'),
  'default'       => null,
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['hjk_discussions_notification_sender_email'] = array
(
  'label'         => &$GLOBALS['TL_LANG']['tl_settings']['hjk_discussions_notification_sender_email'],
  'exclude'       => true,
  'inputType'     => 'text',
  'eval'          => array("rgxp" => "email", 'tl_class' => 'w50'),
  'default'       => null,
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['hjk_discussions_notification_subject'] = array
(
  'label'         => &$GLOBALS['TL_LANG']['tl_settings']['hjk_discussions_notification_subject'],
  'exclude'       => true,
  'inputType'     => 'text',
  'eval'          => array( "mandatory" => true, "preserveTags" => true, "decodeEntities" => false, ),
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['hjk_discussions_notification_mail_template'] = array
(
  'label'         => &$GLOBALS['TL_LANG']['tl_settings']['hjk_discussions_notification_sender_email'],
  'exclude'       => true,
  'inputType'     => 'textarea',
  'eval'          => array( "mandatory" => true, "preserveTags" => true, "decodeEntities" => true, ),
);