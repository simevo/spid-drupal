<?php
namespace Drupal\spid_login\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Drupal\spid_login\Services\SpidService;

class SpidLoginController extends ControllerBase{

    protected $spid_service;

    public function __construct(SpidService $spid_service) {

      $this->spid_service = $spid_service;
    
    }

    public static function create(ContainerInterface $container) {

      return new static(
        $container->get('spid_login.spid')
      );  
    }

    public function login() {
        
        if(!$this->spid_service->auth->isAuthenticated()){
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
            $this->spid_service->auth->login($idpName, $assertId, $attrId, $spidLevel, $returnTo);
        }
        
        if($this->spid_service->auth->isAuthenticated()){
            $attributes  = $this->spid_service->auth->getAttributes();
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

        $this->spid_service->auth->logout(0); //index of single logout service as per the SP metadata (sp_singlelogoutservice in settings array) -> in metadata.xml -> <md:SingleLogoutService Binding="urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST" Location="http://localhost:8080/spid/logout"/>

        return array(
                '#title' => 'SPID Logout',
                '#markup' => 'Goodbye SPID',
            );

    }

    public function metadata() {

        $response = new Response($this->spid_service->auth->getSPMetadata(), 200);
        $response->headers->set('Content-Type', 'text/xml');
        return $response;

    }
}
