<?php
namespace Drupal\spid_login\Services;
define( 'SPID_DRUPAL_PATH', dirname(__FILE__, 3) . '/' );

// NOTE: using hardcoded class from italia/spid-php-lib because of hotfix
require_once SPID_DRUPAL_PATH . 'spid-php-lib/src/Spid/Interfaces/IdpInterface.php';
require_once SPID_DRUPAL_PATH . 'spid-php-lib/src/Spid/Interfaces/RequestInterface.php';
require_once SPID_DRUPAL_PATH . 'spid-php-lib/src/Spid/Interfaces/ResponseInterface.php';
require_once SPID_DRUPAL_PATH . 'spid-php-lib/src/Spid/Interfaces/SAMLInterface.php';
require_once SPID_DRUPAL_PATH . 'spid-php-lib/src/Spid/Saml/Idp.php';
require_once SPID_DRUPAL_PATH . 'spid-php-lib/src/Spid/Saml/Settings.php';
require_once SPID_DRUPAL_PATH . 'spid-php-lib/src/Spid/Saml/SignatureUtils.php';
require_once SPID_DRUPAL_PATH . 'spid-php-lib/src/Spid/Saml/In/BaseResponse.php';
require_once SPID_DRUPAL_PATH . 'spid-php-lib/src/Spid/Saml/In/LogoutRequest.php';
require_once SPID_DRUPAL_PATH . 'spid-php-lib/src/Spid/Saml/In/LogoutResponse.php';
require_once SPID_DRUPAL_PATH . 'spid-php-lib/src/Spid/Saml/In/Response.php';
require_once SPID_DRUPAL_PATH . 'spid-php-lib/src/Spid/Saml/Out/Base.php';
require_once SPID_DRUPAL_PATH . 'spid-php-lib/src/Spid/Saml/Out/AuthnRequest.php';
require_once SPID_DRUPAL_PATH . 'spid-php-lib/src/Spid/Saml/Out/LogoutRequest.php';
require_once SPID_DRUPAL_PATH . 'spid-php-lib/src/Spid/Saml/Out/LogoutResponse.php';
require_once SPID_DRUPAL_PATH . 'spid-php-lib/src/Spid/Saml.php';
require_once SPID_DRUPAL_PATH . 'spid-php-lib/src/Spid/Session.php';
require_once SPID_DRUPAL_PATH . 'spid-php-lib/src/Sp.php';
// remove previous require_once when class spid-php-lib is fixed 

require_once SPID_DRUPAL_PATH . 'vendor/autoload.php';

class SpidService {

	 public function __construct(){

    	$home = SPID_DRUPAL_PATH;
    	$sp_attributeconsumingservice = ["name", "familyName", "fiscalNumber", "email"];
    	$settings = [
            'sp_entityid' => 'http://localhost:8080',
            'sp_key_file' => $home."sp.key",
            'sp_cert_file' => $home."sp.crt",
            'sp_assertionconsumerservice' => [
                 'http://localhost:8080/spid/login/1'
            ],
            'sp_singlelogoutservice' => [['http://localhost:8080/spid/logout', '']],
            'sp_org_name' => 'test',
            'sp_org_display_name' => 'Test',
            'idp_metadata_folder' => $home."idp_metadata/",
            'sp_attributeconsumingservice' => [$sp_attributeconsumingservice],
            ];
        $this->auth = new \Italia\Spid\Sp($settings);

	 }

     public function getAllAttributes() {
        return ['spid_Code','spid_name','spid_familyName','spid_placeOfBirth','spid_countyOfBirth','spid_dateOfBirth','spid_gender','spid_companyName','spid_registeredOffice','spid_fiscalNumber','spid_ivaCode','spid_idCard','spid_mobilePhone','spid_email','spid_address','spid_expirationDate','spid_digitalAddress'];
     }
	
}