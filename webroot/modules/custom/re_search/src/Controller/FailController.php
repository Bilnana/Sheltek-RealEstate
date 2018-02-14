<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 20.12.17.
 * Time: 14.55
 */

namespace Drupal\re_search\Controller;

use Drupal\Core\Controller\ControllerBase;

class FailController extends ControllerBase
{
    public function build()
    {
        return array(
            '#theme' => 're_search',
            '#content' => $this->blockLoad('featured_block'),
        );
    }


    public function blockLoad($block_id){
        $block = \Drupal\block\Entity\Block::load($block_id);
        $block_content = \Drupal::entityTypeManager()
            ->getViewBuilder('block')
            ->view($block);

        return $block_content;
    }
}