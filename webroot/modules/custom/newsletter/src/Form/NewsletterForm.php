<?php
/**
 * Created by PhpStorm.
 * User: soul
 * Date: 23.11.17.
 * Time: 22.38
 */

namespace Drupal\newsletter\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class NewsletterForm extends FormBase{

  public function getFormId() {
    return 'newsletter_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
//    $node = \Drupal::routeMatch()->getParameter('node');
//    $nid = $node->nid->value;

    $form = [
      '#markup' => '<div class="wrap-title-newsleatter"><h3>Subscribe</h3><h2>Newsletter</h2></div>',
    ];

    $form['#prefix'] = '<div class="wrap-input-newsletter">';

    $form['email'] = array(
        '#prefix' => '<div class="wrap">',
      '#type' => 'email',
      '#placeholder' =>t('Enter your email here...'),
      '#required' => TRUE,
    );

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Send'),
      '#button_type' => 'primary',
        '#suffix'=> '</div>',
    );
//    $form['nid'] = array(
//      '#type' => 'hidden',
//      '#value' => $nid,
//    );

    $form['#suffix'] = '</div>';
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    // TODO: Implement submitForm() method.

  }



}