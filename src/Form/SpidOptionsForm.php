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

    $form['provincia'] = [  
      '#type' => 'textfield',  
      '#title' => $this->t('Provincia (nome per esteso)'),  
      '#description' => $this->t('Provincia del Service Provider'),  
      '#default_value' => $config->get('provincia'),  
    ];  

    $form['citta'] = [  
      '#type' => 'textfield',  
      '#title' => $this->t('Citt&aacute;'),  
      '#description' => $this->t('Citt&aacute;'),  
      '#default_value' => $config->get('citta'),  
    ];  

    $form['email_referente'] = [  
      '#type' => 'textfield',  
      '#title' => $this->t('Citt&aacute;'),  
      '#description' => $this->t("Indirizzo email dell'ente o del referente tecnico"),  
      '#default_value' => $config->get('email_referente'),  
    ];  

    return parent::buildForm($form, $form_state);  
  }  

  public function submitForm(array &$form, FormStateInterface $form_state) {  
    parent::submitForm($form, $form_state);  

    $this->config('spid_login.adminsettings')  
      ->set('provincia', $form_state->getValue('provincia'))  
      ->set('citta', $form_state->getValue('citta'))  
      ->set('email_referente', $form_state->getValue('email_referente'))  
      ->save();  
  }  

  

}