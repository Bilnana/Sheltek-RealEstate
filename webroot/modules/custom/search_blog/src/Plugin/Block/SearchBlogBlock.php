<?php

namespace Drupal\search_blog\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "search_blog",
 *   admin_label = @Translation("Search blog block"),
 *   category = @Translation("Custom"),
 * )
 */
class SearchBlogBlock extends BlockBase {

    public function build() {
        $form = \Drupal::formBuilder()->getForm('Drupal\search_blog\Form\SearchBlogForm');
//
//        $form[] = [
//            '#theme' => 'search_blog',
//            '#content' => $this->buildContent(),
//            '#cache' => [
//                'max-age' => 0,
//            ],
//        ];

        return $form;
    }


}
