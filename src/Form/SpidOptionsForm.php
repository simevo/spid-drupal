<?php
/**  
 * @file  
 * Contains Drupal\spid_login\Form\MessagesForm.  
 */  
namespace Drupal\spid_login\Form;  
use Drupal\Core\Form\ConfigFormBase;  
use Drupal\Core\Form\FormStateInterface; 


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

    $form['spid_provincia'] = [  
      '#type' => 'textfield',  
      '#title' => $this->t('Provincia (nome per esteso)'),  
      '#description' => $this->t('Provincia del Service Provider'),  
      '#default_value' => $config->get('spid_provincia'),  
    ];  

    $form['spid_citta'] = [  
      '#type' => 'textfield',  
      '#title' => $this->t('Citt&aacute;'),  
      '#description' => $this->t('Citt&aacute;'),  
      '#default_value' => $config->get('spid_citta'),  
    ];  

    $form['spid_email_referente'] = [  
      '#type' => 'textfield',  
      '#title' => $this->t('Email referente'),  
      '#description' => $this->t("Indirizzo email dell'ente o del referente tecnico"),  
      '#default_value' => $config->get('spid_email_referente'),  
    ];  

    return parent::buildForm($form, $form_state);  
  }  

  public function submitForm(array &$form, FormStateInterface $form_state) {  
    parent::submitForm($form, $form_state);  

    $this->config('spid_login.adminsettings')  
      ->set('spid_provincia', $form_state->getValue('spid_provincia'))  
      ->set('spid_citta', $form_state->getValue('spid_citta'))  
      ->set('spid_email_referente', $form_state->getValue('spid_email_referente'))  
      ->save();  
  }  

  

}