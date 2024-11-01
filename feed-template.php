<?php
/**
 * Template Name: PartnerAds Feed
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Sets the charset.
@ob_clean();
header('Content-type: application/xml');

// Helpers classes.
require_once WOO_PAF_PATH . 'includes/class-wc-paf-simplexml.php';
require_once WOO_PAF_PATH . 'includes/class-wc-paf-xml.php';

$feed = new WC_PAF_XML;
echo $feed->render();

exit;