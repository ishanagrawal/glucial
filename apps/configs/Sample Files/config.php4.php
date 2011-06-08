<?php
/**
* Core Configuration File
*
* This file will contain the core file inclusions of the program, as wel as declarations
* for module variables.
*
* @access public
* @author Steve Belanger <webmaster@ebinformatique.com>
* @since  Saturday November 23 2007
*/

#region General Script Behavior
// Sets the magic quotes behavior to end up with consistant quotes inside SQL Queries
if (get_magic_quotes_runtime() === 1)
{
    set_magic_quotes_runtime(0);
}
// Sets error reporting to report everything
error_reporting(E_PARSE | E_ERROR);
//error_reporting(E_ALL);
// Set execution time to no limit, useful in case of big file uploads
set_time_limit(0);
// ignore user aborts so that the execution will continue even if the browser window gets shut
ignore_user_abort(false);
// sets the global root directory variable
$GLOBALS['root_directory'] = dirname(__FILE__);

//echo "Global root:".$GLOBALS['root_directory']."<br>";
#endregion
#region Include Component Modules
// email class, used to send advanced emails with php
if (file_exists($GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'email_class.php4.php'))
{
    require_once $GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'email_class.php4.php';
}

// the global functions file
if (file_exists($GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'global_functions.php4.php'))
{
    require_once $GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'global_functions.php4.php';
}

if (file_exists($GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'authorize_net.php4.php'))
{
    require_once $GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'authorize_net.php4.php';
}
// start the user session
session_start();
#endregion
#region Database Connection
// check wether the file containing the database information exists or not.
if (file_exists($GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'db_info.php4.php'))
{
	// include the database declaration constants
    require_once $GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'db_info.php4.php';
	// attempt to connect to the database
    $tmp_res_link = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
	// sets the database connection resource as a constant
	/**
	 * @const DB_LINK The database connection resource ID
	 */
    define('DB_LINK', $tmp_res_link);
	// get rid of the variable
    unset($tmp_res_link);
    
	// check wether the database connection was correct
    if (is_resource(DB_LINK))
    {
		// attempt to select the database as active database for the session
        if (mysql_select_db(DATABASE_NAME, DB_LINK))
        {
			// sets database as being connected
            $GLOBALS['database_connected'] = true;
			// retreive tables present inside the database
			Global_Functions::get_list_database_tables(DATABASE_NAME);
        }
        else
        {
			// sets database to be not connected.
//echo 'DB not connected';
            $GLOBALS['database_connected'] = false;
        }
    }
}
else
{
	// sets database as not connected as the info for connecting to the database was never provided
	$GLOBALS['database_connected'] = false;
}
#endregion
#region Define general constants
// checks wether the constants declaraction file exists or not
if (file_exists($GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'constants.php4.php'))
{
	// include the constants file
    require_once $GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'constants.php4.php';
    #region build the document root value
    if (defined('PUBLIC_DIRECTORY'))
    {
        if (!file_exists($GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . '.no_private_root.lck'))
        {
			$tmp_str_root = dirname(__FILE__) . DIRECTORY_SEPARATOR . PUBLIC_DIRECTORY;
        }
        else
        {
			$tmp_str_root = dirname(__FILE__);
        }

    }
    else
    {
		$tmp_str_root = dirname(__FILE__);
    }
//echo "Setting document root as: ".$tmp_str_root."<br>";
	#endregion
	
	/**
	 * @const DOCUMENT_ROOT The Script document root
	 */
	define('DOCUMENT_ROOT', $tmp_str_root);
	unset($tmp_str_root);
}
#endregion
#region General File Inclusions
// calls the email checker module if it's present.
if (file_exists($GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'email_checker.php4.php'))
{
    require_once $GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'email_checker.php4.php';
}

if (file_exists($GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'ftp_info.php4.php'))
{
	// calls the FTP information constant file
	require_once $GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'ftp_info.php4.php';
}

// TODO: see about removing the call to DOM XML
if (file_exists($GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'domxml.php4.php') AND
        function_exists('domxml_open_file'))
{
    require_once $GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'domxml.php4.php';
}

if (file_exists($GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'domxml.php5.php'))
{
	require_once $GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'domxml.php5.php';
}

if (file_exists($GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'global_object_container.php4.php'))
{
    require_once $GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'global_object_container.php4.php';
}

// TODO: See about removing the call to the edit suite. FCK is taking care of that functionality.
if (file_exists($GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . PUBLIC_DIRECTORY . DIRECTORY_SEPARATOR . 'edit_suite.php4.php'))
{
    require_once $GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . PUBLIC_DIRECTORY . DIRECTORY_SEPARATOR . 'edit_suite.php4.php';
}
#endregion
#region Include Smarty Template System
if (file_exists($GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'smarty' . DIRECTORY_SEPARATOR . 'Smarty.class.php'))
{
 
require_once $GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'smarty' . DIRECTORY_SEPARATOR . 'Smarty.class.php';
	$tmp_str_directory = DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'smarty' . DIRECTORY_SEPARATOR;
//echo "Smarty exists!".$tmp_str_directory;   
    $GLOBALS['Smarty'] = new Smarty();
    $GLOBALS['Smarty']->template_dir = $tmp_str_directory . 'templates';
    $GLOBALS['Smarty']->config_dir = $tmp_str_directory . 'smarty_config';
    $GLOBALS['Smarty']->compile_dir = $tmp_str_directory . 'templates_c';
    $GLOBALS['Smarty']->cache_dir = $tmp_str_directory . 'smarty_cache';
//    $GLOBALS['Smarty']->error_reporting = E_ALL;
    
    if (!is_dir($tmp_str_directory . 'templates_c'))
    {
        
$tmp_res_ftp = ftp_connect(FTP_SERVER);
        ftp_login($tmp_res_ftp, FTP_USER, FTP_PASS);
        
        if ($tmp_res_ftp)
        {
            if (defined('PUBLIC_DIRECTORY'))
            {
                if (PUBLIC_DIRECTORY !== '')
                {
                    ftp_chdir($tmp_res_ftp, PUBLIC_DIRECTORY);
                }
            }
            
            if (!is_dir(DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'media'))
            {
                ftp_mkdir($tmp_res_ftp, 'media');
            }
            ftp_chdir($tmp_res_ftp, 'media');
			$tmp_str_directory = DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'media';
            
            if (!is_dir($tmp_str_directory . DIRECTORY_SEPARATOR . 'smarty'))
            {
                ftp_mkdir($tmp_res_ftp, 'smarty');
            }
            ftp_chdir($tmp_res_ftp, 'smarty');
			$tmp_str_directory .= DIRECTORY_SEPARATOR . 'smarty';
            
            if (!is_dir($tmp_str_directory . DIRECTORY_SEPARATOR . 'templates'))
            {
                ftp_mkdir($tmp_res_ftp, 'templates');
            }
            ftp_site($tmp_res_ftp, 'CHMOD 0777 templates');
            ftp_mkdir($tmp_res_ftp, 'templates_c');
            ftp_site($tmp_res_ftp, 'CHMOD 0777 templates_c');
            ftp_mkdir($tmp_res_ftp, 'smarty_cache');
            ftp_site($tmp_res_ftp, 'CHMOD 0777 smarty_cache');
            ftp_mkdir($tmp_res_ftp, 'smarty_config');
            ftp_site($tmp_res_ftp, 'CHMOD 0777 smarty_config');
        }
        ftp_close($tmp_res_ftp);
    }
    $GLOBALS['Smarty']->assign('REQUEST_URI', $_SERVER['REQUEST_URI']);
    $GLOBALS['Smarty']->assign('SESSION', $_SESSION);
    
    if (!empty($_GET))
    {
        $GLOBALS['Smarty']->assign('GET', $_GET);
    }
    
    if (!empty($_POST))
    {
        $GLOBALS['Smarty']->assign('POST', $_POST);
    }
    
    if (!empty($_COOKIE))
    {
        $GLOBALS['Smarty']->assign('COOKIE', $_COOKIE);
    }
}
#endregion
#region Define Template file to be shown
$tmp_str_load_template = $_SERVER['PHP_SELF'];
//echo "template is ".$tmp_str_load_template;

$tmp_str_load_template = str_replace('.php', '.tpl', $tmp_str_load_template);
$tmp_str_load_template = substr($tmp_str_load_template, 1, strlen($tmp_str_load_template)); 
#endregion
#region Define Modules
$GLOBALS['available_modules'] = array();
$GLOBALS['available_modules']['security'] = array();
$GLOBALS['available_modules']['security'][] = DIRECTORY_SEPARATOR . 'security' . DIRECTORY_SEPARATOR . 'website_security.php4.php';
$GLOBALS['available_modules']['user_records'] = array();
$GLOBALS['available_modules']['user_records'][] = DIRECTORY_SEPARATOR . 'website_users' . DIRECTORY_SEPARATOR . 'website_users.php4.php';
$GLOBALS['available_modules']['system_variables'] = array();
$GLOBALS['available_modules']['system_variables'][] = DIRECTORY_SEPARATOR . 'system_variables' . DIRECTORY_SEPARATOR . 'system_variables.php4.php';
$GLOBALS['available_modules']['system_variables'][] = DIRECTORY_SEPARATOR . 'system_modules' . DIRECTORY_SEPARATOR . 'system_modules.php4.php';
$GLOBALS['available_modules']['image_attachments'] = array();
$GLOBALS['available_modules']['image_attachments'][] = DIRECTORY_SEPARATOR . 'image_attachments' . DIRECTORY_SEPARATOR . 'image_attachments.php4.php';
$GLOBALS['available_modules']['photographer_package'] = array();
$GLOBALS['available_modules']['photographer_package'][] = DIRECTORY_SEPARATOR . 'site_galleries' . DIRECTORY_SEPARATOR . 'site_galleries.php4.php';
$GLOBALS['available_modules']['photographer_package'][] = DIRECTORY_SEPARATOR . 'site_gallery_images' . DIRECTORY_SEPARATOR . 'site_gallery_images.php4.php';
//$GLOBALS['available_modules']['banned_emails'] = array();
//$GLOBALS['available_modules']['banned_emails'][] = '/banned_emails/banned_emails.php4.php';
//$GLOBALS['available_modules']['forum'] = array();
//$GLOBALS['available_modules']['forum'][] = '/forum/forum_forums.php4.php';
//$GLOBALS['available_modules']['topmenu'] = array();
//$GLOBALS['available_modules']['topmenu'][] = '/topmenu/topmenu.php4.php';
//$GLOBALS['available_modules']['product_categories'] = array();
//$GLOBALS['available_modules']['product_categories'][] = '/categories/categories.php4.php';
//$GLOBALS['available_modules']['products'] = array();
//$GLOBALS['available_modules']['products'][] = '/products/products.php4.php';
//$GLOBALS['available_modules']['anajet_accessories'] = array();
//$GLOBALS['available_modules']['anajet_accessories'][] = '/accessories/accessories.php4.php';
//$GLOBALS['available_modules']['anajet_tradeshows'] = array();
//$GLOBALS['available_modules']['anajet_tradeshows'][] = '/tradeshows/tradeshows.php4.php';
//$GLOBALS['available_modules']['anajet_dealer_requests'] = array();
//$GLOBALS['available_modules']['anajet_dealer_requests'][] = '/dealer_requests/dealer_requests.php4.php';
//$GLOBALS['available_modules']['profiles'] = array();
//$GLOBALS['available_modules']['profiles'][] = '/profiles/profiles.php4.php';
//$GLOBALS['available_modules']['traffic_analysis'] = array();
//$GLOBALS['available_modules']['traffic_analysis'][] = '/traffic_analysis/page_hits.php4.php';
//$GLOBALS['available_modules']['traffic_analysis'][] = '/traffic_analysis/referrers.php4.php';
//$GLOBALS['available_modules']['page_details'] = array();
//$GLOBALS['available_modules']['page_details'][] = '/page_details/page_details.php4.php';
//#endregion
#region Include Modules Used
$GLOBALS['modules_used'] = array();
$GLOBALS['modules_used'][] = 'security';
$GLOBALS['modules_used'][] = 'user_records';
$GLOBALS['modules_used'][] = 'system_variables';


if (file_exists($GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'modules_used.php4.php'))
{
    require_once $GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'modules_used.php4.php';
}

if (!defined('PUBLIC_DIRECTORY'))
{
    $GLOBALS['root_directory'] .= DIRECTORY_SEPARATOR;
}
elseif (substr_count($GLOBALS['root_directory'], PUBLIC_DIRECTORY) !== 0)
{
    $GLOBALS['root_directory'] .= DIRECTORY_SEPARATOR;
}
else
{
    $GLOBALS['root_directory'] .= DIRECTORY_SEPARATOR . PUBLIC_DIRECTORY . DIRECTORY_SEPARATOR;
}
//
//if (file_exists($GLOBALS['root_directory'] . 'fckeditor' . DIRECTORY_SEPARATOR . 'fckeditor.php'))
//{
//    require_once $GLOBALS['root_directory'] . 'fckeditor' . DIRECTORY_SEPARATOR . 'fckeditor.php';
//}

if (file_exists($GLOBALS['root_directory'] . 'ckeditor' . DIRECTORY_SEPARATOR . 'ckeditor.php'))
{
    require_once $GLOBALS['root_directory'] . 'ckeditor' . DIRECTORY_SEPARATOR . 'ckeditor.php';
}

// TODO: add code to dynamically create directories used by image uploader to limit initial setup of websites using the page editing feature.

foreach ($GLOBALS['modules_used'] as $tmp_int_key=>$tmp_str_module)
{
    foreach ($GLOBALS['available_modules'][$tmp_str_module] as $tmp_int_id=>$tmp_str_file)
    {
        if (file_exists($GLOBALS['root_directory'] . CONTROL_PANEL_DIRECTORY . $tmp_str_file))
        {
            require_once $GLOBALS['root_directory'] . CONTROL_PANEL_DIRECTORY . $tmp_str_file;
        }
    }
}
#endregion

if (class_exists('System_Variables'))
{
	$GLOBALS['System_Variables']->collect_variables();
}

if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'smarty_variables.php'))
{
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'smarty_variables.php';
}

if (file_exists($GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'variables.php4.php'))
{
	require_once $GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'variables.php4.php';
}

#region Include Modules Used
$GLOBALS['control_panel_directory'] = $GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'control_panel' . DIRECTORY_SEPARATOR;

//if (file_exists($GLOBALS['control_panel_directory'] . 'installer_class.php'))
//{
//    require_once $GLOBALS['control_panel_directory'] . 'installer_class.php';
//}
if (file_exists($GLOBALS['control_panel_directory'] . 'facility_application_class.php'))
{
    require_once $GLOBALS['control_panel_directory'] . 'facility_application_class.php';
}
if (file_exists($GLOBALS['control_panel_directory'] . 'installer_location_class.php'))
{
    require_once $GLOBALS['control_panel_directory'] . 'installer_location_class.php';
}

if (file_exists($GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'control_panel' . DIRECTORY_SEPARATOR . 'salesforce_class.php'))
{
	require_once $GLOBALS['root_directory'] . DIRECTORY_SEPARATOR . 'control_panel' . DIRECTORY_SEPARATOR . 'salesforce_class.php';
}

if (file_exists($GLOBALS['root_directory'] . 'library' . DIRECTORY_SEPARATOR . 'salesforce' . DIRECTORY_SEPARATOR
		. 'soapclient' . DIRECTORY_SEPARATOR . 'SforcePartnerClient.php'))
{
    require_once $GLOBALS['root_directory'] . 'library' . DIRECTORY_SEPARATOR . 'salesforce' . DIRECTORY_SEPARATOR
		. 'soapclient' . DIRECTORY_SEPARATOR . 'SforcePartnerClient.php';
}

if (file_exists($GLOBALS['root_directory'] . 'zipcode' . DIRECTORY_SEPARATOR . 'zipcode.class.php'))
{
    require_once $GLOBALS['root_directory'] . 'zipcode' . DIRECTORY_SEPARATOR . 'zipcode.class.php';
}

if (file_exists($GLOBALS['control_panel_directory'] . 'customer_class.php'))
{
    require_once $GLOBALS['control_panel_directory'] . 'customer_class.php';
}
if (file_exists($GLOBALS['control_panel_directory'] . 'customer_container_class.php'))
{
    require_once $GLOBALS['control_panel_directory'] . 'customer_container_class.php';
}
if (file_exists($GLOBALS['control_panel_directory'] . 'installer_class.php'))
{
    require_once $GLOBALS['control_panel_directory'] . 'installer_class.php';
}
if (file_exists($GLOBALS['control_panel_directory'] . 'facility_container_class.php'))
{
    require_once $GLOBALS['control_panel_directory'] . 'facility_container_class.php';
}
if (file_exists($GLOBALS['control_panel_directory'] . 'facility_class.php'))
{
    require_once $GLOBALS['control_panel_directory'] . 'facility_class.php';
}
if (file_exists($GLOBALS['control_panel_directory'] . 'facility_container_class.php'))
{
    require_once $GLOBALS['control_panel_directory'] . 'facility_container_class.php';
}
if (file_exists($GLOBALS['control_panel_directory'] . 'installer_container_class.php'))
{
    require_once $GLOBALS['control_panel_directory'] . 'installer_container_class.php';
}
if (file_exists($GLOBALS['control_panel_directory'] . 'srec_class.php'))
{
    require_once $GLOBALS['control_panel_directory'] . 'srec_class.php';
}
if (file_exists($GLOBALS['control_panel_directory'] . 'easyrec.php4.php'))
{
    require_once $GLOBALS['control_panel_directory'] . 'easyrec.php4.php';
}
if (file_exists($GLOBALS['control_panel_directory'] . 'Auction' . DIRECTORY_SEPARATOR . 'auction_class.php'))
{
    require_once $GLOBALS['control_panel_directory'] . 'Auction' . DIRECTORY_SEPARATOR . 'auction_class.php';
}


if (file_exists($GLOBALS['control_panel_directory'] . 'Auction' . DIRECTORY_SEPARATOR . 'auction_class.php')) {

   require_once $GLOBALS['control_panel_directory'] . 'Auction' . DIRECTORY_SEPARATOR . 'auction_class.php';
    
}

if (file_exists($GLOBALS['control_panel_directory'] . 'Auction' . DIRECTORY_SEPARATOR . 'auction_orderbook_class.php')) {

   require_once $GLOBALS['control_panel_directory'] . 'Auction' . DIRECTORY_SEPARATOR . 'auction_orderbook_class.php';
    
}

if (file_exists($GLOBALS['control_panel_directory'] . 'Auction' . DIRECTORY_SEPARATOR . 'auction_easyrec_class.php')) {

   require_once $GLOBALS['control_panel_directory'] . 'Auction' . DIRECTORY_SEPARATOR . 'auction_easyrec_class.php';
    
}

if (file_exists($GLOBALS['control_panel_directory'] . 'Auction' . DIRECTORY_SEPARATOR . 'auction_load_email_class.php')) {

   require_once $GLOBALS['control_panel_directory'] . 'Auction' . DIRECTORY_SEPARATOR . 'auction_load_email_class.php';
     
}

if (file_exists($GLOBALS['control_panel_directory'] . 'Auction' . DIRECTORY_SEPARATOR . 'energy_year_class.php')) {

   require_once $GLOBALS['control_panel_directory'] . 'Auction' . DIRECTORY_SEPARATOR . 'energy_year_class.php';
     
}

if (file_exists($GLOBALS['control_panel_directory'] . 'Auction' . DIRECTORY_SEPARATOR . 'order_class.php')) {

   require_once $GLOBALS['control_panel_directory'] . 'Auction' . DIRECTORY_SEPARATOR . 'order_class.php';
     
}

if ($_SESSION['user_informations']['username'] != '') {
    
    $installer_id = Installer::validate_installer();

}

if (!$installer_id && ($_SERVER['REQUEST_URI'] == '/installer_account.php' ||
    $_SERVER['REQUEST_URI'] == '/installer_transaction_summary.php'
    || $_SERVER['REQUEST_URI'] == '/installer_facility_search.php')) {
    
    Global_Functions::redirect_user('/members/index.php');
           
}

$GLOBALS['Smarty']->assign('ENCODED_REQUEST_URI', urlencode($_SERVER['REQUEST_URI']));
//#endregion

#region Installer Configuration


//if (file_exists($GLOBALS['control_panel_directory'] . 'salesforce_class.php'))
//{
//    require_once $GLOBALS['control_panel_directory'] . 'salesforce_class.php';
//}

//if (class_exists('Smarty'))
//{
//	if (!isset($_SESSION['user_informations']))
//	{
//		$GLOBALS['Smarty']->assign('register_link', REGISTRATION_LINK);
//	}
//}
//
//#endregion
//
//
//
////////$tmp_arr_modules['forum'][] = '/forum/forum_threads.php4.php';
////////$tmp_arr_modules['forum'][] = '/forum/forum_posts.php4.php';
////////$tmp_arr_modules['forum'][] = '/forum/forum_profiles.php4.php';
////////$tmp_arr_modules['forum'][] = '/forum/smilies.php4.php';
////////$tmp_arr_modules['forum'][] = '/forum/bad_words.php4.php';
////////$tmp_arr_modules['forum'][] = '/forum/forum_attachments.php4.php';
////////$tmp_arr_modules['side_navigation'] = array();
////////$tmp_arr_modules['side_navigation'][] = '/side_navigation/navigation.php4.php';
////////$tmp_arr_modules['faq'] = array();
////////$tmp_arr_modules['faq'][] = '/faq/faq.php4.php';
////////#endregion
//////////$tmp_arr_modules[] = '/plasmacredit_accounts/plasmacredit_accounts.php4.php';
//////////$tmp_arr_modules[] = '/properties/realtor_properties.php4.php';
//////////$tmp_arr_modules[] = '/states/states.php4.php';
//////////$tmp_arr_modules[] = '/cities/cities.php4.php';
//////////$tmp_arr_modules[] = '/pages/pages.php4.php';
//////////$tmp_arr_modules[] = '/yellow_pages/yellow_pages.php4.php';
//////////$tmp_arr_modules[] = '/page_groups/page_groups.php4.php';
//////////$tmp_arr_modules[] = '/shipping_details/shipping_details.php4.php';
//////////$tmp_arr_modules[] = '/billing_details/billing_details.php4.php';
//////////$tmp_arr_modules[] = '/transaction_log/transaction_log.php4.php';
//////////$tmp_arr_modules[] = '/billing_accounts/billing_accounts.php4.php';
//////////$tmp_arr_modules[] = '/online_tests/online_tests.php4.php';
//////////$tmp_arr_modules[] = '/store_profiles/store_profiles.php4.php';
//////////$tmp_arr_modules[] = '/sporting_bids/sporting_bids.php4.php';
//////////$tmp_arr_modules[] = '/mailing_list/mailing_list.php4.php';
//////////$tmp_arr_modules[] = '/credit_card_records/credit_card_records.php4.php';
//////////$tmp_arr_modules[] = '/special_offer/special_offer.php4.php';
//////////$tmp_arr_modules[] = '/horses/horses.php4.php';
//////////$tmp_arr_modules[] = '/signups/signups.php4.php';
//////////$tmp_arr_modules[] = '/mpt_support_questions/questions.php4.php';
//////////$tmp_arr_modules[] = '/site_designers/designers.php4.php';
//////////$tmp_arr_modules[] = '/site_mailer/mailer.php4.php';
//////////$tmp_arr_modules[] = '/season_special/seasons.php4.php';
//////////$tmp_arr_modules[] = '/seasons/seasons.php4.php';
//////////$tmp_arr_modules[] = '/site_records/site_records.php4.php';
//////////$tmp_arr_modules[] = '/site_orders/site_orders.php4.php';
//////////$tmp_arr_modules[] = '/account_managers/account_managers.php4.php';
//////////$tmp_arr_modules[] = '/loan_originators/loan_originators.php4.php';
//////////$tmp_arr_modules[] = '/loan_plans/loan_plans.php4.php';
//////////$tmp_arr_modules[] = '/blogs/blogs.php4.php';
//////////$tmp_arr_modules[] = '/charity_listings/charity_listings.php4.php';
//////////$tmp_arr_modules[] = '/charity_counter/charity_counter.php4.php';
//////////$tmp_arr_modules[] = '/page_details/page_details.php4.php';
//////////#endregion
//if (file_exists($GLOBALS['root_directory'] . '/variables.php4.php'))
//{
//	require_once $GLOBALS['root_directory'] . '/variables.php4.php';
//}
////////
?>