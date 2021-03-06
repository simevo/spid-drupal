<?php
/**  
 * @file  
 * Contains Drupal\spid_login\Form\MessagesForm.  
 */  
namespace Drupal\spid_login\Form;  
use Drupal\Core\Form\ConfigFormBase;  
use Drupal\Core\Form\FormStateInterface; 
use Drupal\spid_login\Services\SpidService;


class SpidOptionsForm extends ConfigFormBase {

  /**  
   * {@inheritdoc}  
   */  
  public function getFormId() {  
    return 'spid_login_form';  
  }  

  protected function getEditableConfigNames() {  
    return [  
      'spid_login.adminsettings',  
    ];  
  }  

  public function buildForm(array $form, FormStateInterface $form_state) {  
    $config = $this->config('spid_login.adminsettings'); 

    $metadata_link_options = [
      'attributes' => [
        'target' => '_blank'
      ]
    ];
    $metadata_link = \Drupal\Core\Link::createFromRoute($this->t('Service Provider Metadata'), 'spid_metadata')->toRenderable();

    $form['service_provider'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Service Provider Options'),
    ]; 

    $form['service_provider']['#markup'] = render($metadata_link);

    $form['service_provider']['spid_entity_id'] = [  
      '#type' => 'textfield',  
      '#title' => $this->t('Nome del Service Provider'),  
      '#description' => $this->t('Nome del Service Provider'),  
      '#default_value' => $config->get('spid_entity_id'),  
    ];  

    $form['service_provider']['spid_provincia'] = [  
      '#type' => 'textfield',  
      '#title' => $this->t('Provincia (nome per esteso)'),  
      '#description' => $this->t('Provincia del Service Provider'),  
      '#default_value' => $config->get('spid_provincia'),  
    ];  

    $form['service_provider']['spid_citta'] = [  
      '#type' => 'textfield',  
      '#title' => $this->t('Citt&aacute;'),  
      '#description' => $this->t('Citt&aacute;'),  
      '#default_value' => $config->get('spid_citta'),  
    ];  

    $form['service_provider']['spid_email_referente'] = [  
      '#type' => 'textfield',  
      '#title' => $this->t('Email referente'),  
      '#description' => $this->t("Indirizzo email dell'ente o del referente tecnico"),  
      '#default_value' => $config->get('spid_email_referente'),  
    ];  

    $form['service_provider']['spid_metadata_attributes'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Attributi'),
      '#description' => $this->t('Attributi richiesti IDP.'),
      '#default_value' => $config->get('spid_metadata_attributes'),
      '#options' => SpidService::getAllAttributes(),
    ];

    return parent::buildForm($form, $form_state);  
  }  

  public function submitForm(array &$form, FormStateInterface $form_state) {  
    parent::submitForm($form, $form_state);  

    $metadataAttributes = $form_state->getValue('spid_metadata_attributes');

    $this->config('spid_login.adminsettings')  
      ->set('spid_entity_id', $form_state->getValue('spid_entity_id'))  
      ->set('spid_provincia', $form_state->getValue('spid_provincia'))  
      ->set('spid_citta', $form_state->getValue('spid_citta'))  
      ->set('spid_email_referente', $form_state->getValue('spid_email_referente'))  
      ->set('spid_metadata_attributes', $metadataAttributes)
      ->save();  
  }  

  

}