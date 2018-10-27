<?php
namespace Drupal\spid_login\Controller;
define( 'SPID_DRUPAL_PATH', dirname(__FILE__, 3) . '/' );

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\spid_login\Services\SpidService;

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

class SpidLoginController extends ControllerBase{

    protected $spid_auth;

    public function __construct(SpidService $spid_service) {

      $this->spid_auth = $spid_service;
    }

    public static function create(ContainerInterface $container) {

      return new static(
        $container->get('spid_login.spid')
      );  
    }

    public function login() {

    	$base =  (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    	// up a level
    	$base = substr($base, 0, -6);

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
        
        if(!$this->auth->isAuthenticated()){
            // name of the xml file inside idp_metadata_folder (without .xml extension)
            $idpName = 'teamdigitale4.simevo.com';
            // index of assertion consumer service as per the SP metadata
            $assertId = 0;
            // index of attribute consuming service as per the SP metadata
            $attrId = 0;
            // SPID level (1, 2 or 3)
            $spidLevel = 1;
            // return url, optional
            $returnTo = null;
            $this->auth->login($idpName, $assertId, $attrId, $spidLevel, $returnTo);
        }
        
        if($this->auth->isAuthenticated()){
            $attributes  = $this->auth->getAttributes();
            $flattened_attributes = implode("<br>",$attributes);
        } else {
            echo 'Utente non loggato';
            $flattened_attributes = '';
        }
        
        
        return array(
                '#title' => 'SPID Login',
                '#markup' => $flattened_attributes,
            );
    }

    public function logout() {

        return array(
                '#title' => 'SPID Login',
                '#markup' => 'Goodbye SPID',
            );

    }
}
