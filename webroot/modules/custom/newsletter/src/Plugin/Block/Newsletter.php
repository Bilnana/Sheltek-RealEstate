<?php
/**
 * Created by PhpStorm.
 * User: soul
 * Date: 24.11.17.
 * Time: 12.27
 */

namespace Drupal\newsletter\Plugin\Block;


use Drupal\Core\Block\BlockBase;


/**
 * Provides a custom block
 *
 * @Block(
 *   id = "newsletter",
 *   admin_label = @Translation("Newsletter block"),
 *   category = @Translation("Custom"),
 * )
 */
class Newsletter extends BlockBase{

  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\newsletter\Form\NewsletterForm');
    return $form;
  }

}