<?php

namespace Drupal\quick_contact_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;


/**
 * Provides a custom block
 *
 * @Block(
 *   id = "quick_contact_block",
 *   admin_label = @Translation("Quick contact block"),
 *   category = @Translation("Quick contact"),
 * )
 */
class QuickContact extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\quick_contact_block\Form\QuickContactForm');
    return $form;
  }
}
