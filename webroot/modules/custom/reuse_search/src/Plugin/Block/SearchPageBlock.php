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
 *   id = "search_page_block",
 *   admin_label = @Translation("Search page block"),
 *   category = @Translation("Custom"),
 * )
 */
class SearchPageBlock extends BlockBase
{
    public function build()
    {
        $form = \Drupal::formBuilder()->getForm('Drupal\reuse_search\Form\ReuseForm');
        $form['#theme'] = 'search_page_block';
        $form['#cache'] = ['max-age' => 0,];
        return $form;
    }
}