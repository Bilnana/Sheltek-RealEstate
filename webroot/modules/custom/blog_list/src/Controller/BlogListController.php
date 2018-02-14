<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 30.11.17.
 * Time: 15.36
 */

namespace Drupal\blog_list\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\file\Entity\File;

class BlogListController extends ControllerBase
{
    public function buildContent ($limit = 12) {

        $query = \Drupal::database()->select( 'node_field_data', 'n' );
        $query->condition( 'n.type', 'blog', '=' );

        $query->innerJoin('node__field_blog_image','nfb', 'nfb.entity_id = n.nid');
        $query->innerJoin('node__field_date','nfd', 'nfd.entity_id = n.nid');
        $query->innerJoin('node__body', 'nb', 'nb.entity_id = n.nid');



        $query->addField('n', 'nid');
        $query->addField( 'n', 'title' );
        $query->addField( 'nb', 'body_value' );
        $query->addField( 'nfd', 'field_date_value');
        $query->addField( 'nfb', 'field_blog_image_target_id','image_id' );

        $query->orderBy( 'nid', 'DESC' );

//        $query = $query->extend( 'Drupal\Core\Database\Query\PagerSelectExtender' )->limit( 3 );
        $query = $query->extend( 'Drupal\Core\Database\Query\PagerSelectExtender' )->limit( $limit );

        $data = [];

        $results = $query->execute()->fetchAll();

        foreach ( $results as $result ) {
            $file = File::load($result->image_id);
            $url = \Drupal\image\Entity\ImageStyle::load('blog_list_detail_368_x_235')->buildUrl($file->getFileUri());
            $alias = \Drupal::service('path.alias_manager')->getAliasByPath('/node/'.$result->nid);

            $data[] = [
                'nid' => $alias,
                'title' => $result->title,
                'date' => date('F j, Y / g a', strtotime($result->field_date_value)),
                'body' => substr(strip_tags(str_replace(array("\r", "\n"), '', $result->body_value)), 0, 120),
                'image' => $url,
            ];
        }

        return $data;
    }


    public function content ()
    {
//        return array(
//            '#theme' => 'blog_list',
//            '#content' => $this->buildContent(),
//            '#cache' => [
//                'max-age' => 0,
//            ],
//        );
        $render = [];
        $render[] = [
            '#theme' => 'blog_list',
            '#content' => $this->buildContent(),
            '#cache' => [
                'max-age' => 0,
            ],
        ];

        $render[] = ['#type' => 'pager'];
        return $render;

    }
}
