<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 20.12.17.
 * Time: 15.42
 */

namespace Drupal\reuse_search\Plugin\Block;

use Drupal\Core\Block\BlockBase;


/**
 * Provides a custom block
 *
 * @Block(
 *   id = "reuse_search",
 *   admin_label = @Translation("Reuse block"),
 *   category = @Translation("Custom"),
 * )
 */
class ReuseBlock extends BlockBase
{
    public function build()
    {
        $form = \Drupal::formBuilder()->getForm('Drupal\reuse_search\Form\ReuseForm');
        $form['#theme'] = 'reuse_search';
        $form['#cache'] = ['max-age' => 0,];
        return $form;
    }
}