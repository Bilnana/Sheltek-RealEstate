<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 29.11.17.
 * Time: 17.25
 */

namespace Drupal\latest_news\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\file\Entity\File;


/**
 * Provides a 'FeaturedBlock' block.
 *
 * @Block(
 *  id = "latest_news",
 *  admin_label = @Translation("Latest news Block"),
 * )
 */
class LatestNewsBlock extends BlockBase implements BlockPluginInterface {

    public function buildContent () {

        $query = \Drupal::database()->select( 'node_field_data', 'n' );
        $query->condition( 'n.type', 'blog', '=' );

        $query->innerJoin('node__field_blog_image','nfb', 'nfb.entity_id = n.nid');
        $query->innerJoin('node__body', 'nb', 'nb.entity_id = n.nid');



        $query->addField('n', 'nid');
        $query->addField( 'n', 'title' );
        $query->addField( 'nb', 'body_value' );
        $query->addField( 'nfb', 'field_blog_image_target_id','image_id' );

        $query->range(0, 3);

        $query->orderBy( 'nid', 'DESC' );

//        $query = $query->extend( 'Drupal\Core\Database\Query\PagerSelectExtender' )->limit( 3 );

        $data = [];

        $results = $query->execute()->fetchAll();

        foreach ( $results as $result ) {
            $file = File::load($result->image_id);
            $url = \Drupal\image\Entity\ImageStyle::load('leatest_news_footer')->buildUrl($file->getFileUri());
            $alias = \Drupal::service('path.alias_manager')->getAliasByPath('/node/'.$result->nid);
            $data[] = [
                'nid' => $alias,
                'title' => $result->title,
                'body' => substr(strip_tags(str_replace(array("\r", "\n"), '', $result->body_value)), 0, 80),
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
            '#theme'    => 'latest_news',
            '#content'  => $this->buildContent(),
            '#cache'    => [
                'max-age' => 0,
            ],
        );
    }

}