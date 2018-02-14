<?php
/**
 * Created by PhpStorm.
 * User: soul
 * Date: 23.11.17.
 * Time: 11.23
 */

namespace Drupal\quick_contact_block\Form;

use  Drupal\Core\Form\FormBase;
use  Drupal\Core\Form\FormStateInterface;

class QuickContactForm extends FormBase{

  public function getFormId() {
    return 'quick_contact_block_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = [
      '#markup' => '<h6>Quick contact</h6><p>Lorem ipsum dolor sit amet, consectetur acinglit sed do eiusmod tempor</p>', //Temporary field, i am sure that somewhere better solution exist
    ];
    $form['email'] = array(
      '#type' => 'email',
      '#placeholder' => t('Type your E-mail address...'),
      '#required' => TRUE,
    );
    $form['textarea'] = array(
      '#type' => 'textarea',
      '#placeholder' => t('Write here...'),
      '#required' => TRUE,
    );
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Send'),
      '#button_type' => 'primary',
    );
    return $form;
  }


  public function submitForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message($this->t('Your application is being submitted!', array('@email' => $form_state->getValue('email'))));
  }

}