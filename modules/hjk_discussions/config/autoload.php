<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'HJK',
	'HJK\\Discussions',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
    //'DC_HJK_Applications'                           => 'system/modules/hjk_bookings/classes/DC_HJK_Applications.php',

	// Models
	//'HJK\\Bookings\\HjkBookingsApplicationModel'    => 'system/modules/hjk_bookings/models/HjkBookingsApplicationModel.php',

    
    
    // BE-Modules
    //'HJK\\Bookings\\BEBookings'  => 'system/modules/hjk_bookings/modules/BEBookings.php',

    
    // FE-Modules
    //'HJK\\Bookings\\FEWeekPlan' => 'system/modules/hjk_bookings/modules/FEWeekPlan.php',

    // other
    //'HJK\\Bookings\\DateHelpers' => 'system/modules/hjk_bookings/classes/DateHelpers.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array(
	// 'be_hjk_course_dates'         => 'system/modules/hjk_bookings/templates',
));
