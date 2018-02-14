<?php

namespace Drupal\rbp\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\file\Entity\File;

/**
 * Provides a 'Recent blog post' block.
 *
 * @Block(
 *  id = "rbp",
 *  admin_label = @Translation("Recent blog post"),
 * )
 */
class RBPBlock extends BlockBase {

    public function buildContent () {

        $query = \Drupal::database()->select( 'node_field_data', 'n' );
        $query->condition( 'n.type', 'blog', '=' );

        $query->innerJoin('node__field_blog_image','nfb', 'nfb.entity_id = n.nid');
        $query->innerJoin('node__field_date','nfd', 'nfd.entity_id = n.nid');
        $query->innerJoin('node__body', 'nb', 'nb.entity_id = n.nid');



        $query->addField('n', 'nid');
        $query->addField( 'n', 'title' );
        $query->addField( 'nfd', 'field_date_value');
        $query->addField( 'nb', 'body_value' );
        $query->addField( 'nfb', 'field_blog_image_target_id','image_id' );

        $query->range(0, 3);

        $query->orderBy( 'nid', 'DESC' );

//        $query = $query->extend( 'Drupal\Core\Database\Query\PagerSelectExtender' )->limit( 3 );

        $data = [];

        $results = $query->execute()->fetchAll();

        foreach ( $results as $result ) {
            $file = File::load($result->image_id);
            $url = \Drupal\image\Entity\ImageStyle::load('recent_post_blog_sidebar_')->buildUrl($file->getFileUri());
            $alias = \Drupal::service('path.alias_manager')->getAliasByPath('/node/'.$result->nid);
            $data[] = [
                'nid' => $alias,
                'title' => $result->title,
                'date' => date('F j, Y / g a', strtotime($result->field_date_value)),
                'body' => substr(strip_tags(str_replace(array("\r", "\n"), '', $result->body_value)), 0, 40),
                'image' => $url,
            ];
        }

        return $data;
    }
    /**
     * {@inheritdoc}
     */
    public function build () {

        return array(
            '#theme'    => 'rbp',
            '#content'  => $this->buildContent(),
            '#cache'    => [
                'max-age' => 0,
            ],
        );
    }
}