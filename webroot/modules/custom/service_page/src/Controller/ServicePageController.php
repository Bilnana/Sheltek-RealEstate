<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 7.12.17.
 * Time: 09.32
 */

namespace Drupal\service_page\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\term_block\Plugin\Block\TermBlock;

class ServicePageController extends ControllerBase
{


    public function buildContent () {

        $query = \Drupal::database()->select( 'node_field_data', 'n' );
        $query->condition( 'n.type', 'property', '=' );

        $query->innerJoin('taxonomy_index', 'ti', 'ti.nid = n.nid');
        $query->innerJoin('taxonomy_term_field_data', 'tfd', 'tfd.tid = ti.tid' );

//        $query->condition('tfd.tid', 'For sale', '=');
        $x = $_GET['tid'];

        $query->condition('tfd.tid', $x, '=');


        $query->innerJoin('node__field_property_image', 'fp', 'n.nid = fp.entity_id');
        $query->condition('fp.delta', 0, '=');
        $query->innerJoin('file_managed', 'fm', 'fm.fid = fp.field_property_image_target_id');

        $query->innerJoin('node__field_location', 'fl', 'n.nid = fl.entity_id');
        $query->leftJoin('taxonomy_term_field_data', 'tfdi', 'fl.field_location_target_id = tfdi.tid');

        $query->innerJoin('node__field_bathroom','nfb', 'nfb.entity_id = n.nid');
        $query->innerJoin('node__field_bedroom','fb', 'fb.entity_id = n.nid');
        $query->innerJoin('node__field_price','nfp', 'nfp.entity_id = n.nid');
        $query->innerJoin('node__field_area','fa', 'fa.entity_id = n.nid');


        $query->addField('tfdi', 'name', 'address');
        $query->addField('nfb', 'field_bathroom_value', 'bath');
        $query->addField('fb', 'field_bedroom_value', 'bed');
        $query->addField('nfp', 'field_price_value', 'price');
        $query->addField('fa', 'field_area_value', 'area');
        $query->addField('fm', 'uri', 'image');
        $query->addField('n', 'nid');
        $query->addField('n', 'title');



        $query = $query->extend( 'Drupal\Core\Database\Query\PagerSelectExtender' )->limit( 6 );

        $data = [];

        $results = $query->execute()->fetchAll();

        foreach ( $results as $result ) {
            $image=$result->image;
            $url = \Drupal\image\Entity\ImageStyle::load('featured_property_330x268')->buildUrl($image);
            $path =$result->nid;
            $alias = \Drupal::service('path.alias_manager')->getAliasByPath('/node/'.$path);
            $data['sale'][] = [
                'nid' => $alias,
                'image' => $url,
                'title' => substr(strip_tags(str_replace(array("\r", "\n"), '', $result->title)), 0),
                'address' => $result->address,
                'bath' => $result->bath,
                'bed' => $result->bed,
                'price' => $result->price,
                'area' => $result->area,
            ];
        }

        return $data;
    }


    public function content() {
        $render = [];
        $render[] = [
            '#theme' => 'service_page',
            '#content' => $this->buildContent(),
            '#cache' => [
                'max-age' => 0,
            ],
        ];
        $render[] = ['#type' => 'pager'];
        return $render;
    }
}