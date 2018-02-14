<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 12.12.17.
 * Time: 10.50
 */

namespace Drupal\term_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;

/**
 * Provides a 'Block for term properties categories' block.
 *
 * @Block(
 *  id = "term_block",
 *  admin_label = @Translation("Term Blocks"),
 * )
 */
class TermBlock extends BlockBase {

    public function buildContent () {
        $query = \Drupal::database()->select('taxonomy_term_field_data', 't');
        $query->condition('t.vid', 'property_categories', '=');


        $query->addField('t', 'tid', 'tid');
        $query->addField('t', 'name', 'name');
        $query->addField('t', 'description__value', 'text');

        $query->innerJoin('taxonomy_term__field_image_term', 'fit', 't.tid = fit.entity_id');
        $query->innerJoin('file_managed', 'fm', 'fm.fid = fit.field_image_term_target_id');

        $query->addField('fm', 'uri', 'image');

        $data = [];

        $results = $query->execute()->fetchAll();

        foreach ($results as $result) {

//            $path = strtolower($result->name);
//            $suc = str_replace(' ', '-', $path);
//            $alias = Url::fromUri('internal:/service-details/'.$suc);


            $path = ($result->tid);

//            $output[$path]['path'] = $path;
//            if(empty($output[$path]['url'])){
//                $output[$path]['url'] = '?tid=';
//            }
//            $output[$path]['url'] .= $result->tid;
//
//            $output = array_values($output);

            $alias = Url::fromUri('internal:/service/single-service?tid='.$path);


            $image=$result->image;
            $url = \Drupal\image\Entity\ImageStyle::load('taxonomy_picture_263x205')->buildUrl($image);

            $data[] = [
                'tid' => $alias,
                'image' => $url,
                'desc' => substr(strip_tags(str_replace(array("\r", "\n"), '', $result->text)), 0, 120),
                'name' => $result->name,
            ];
        }

        return $data;

    }

    /**
     * {@inheritdoc}
     */
    public function build () {

    return array(
        '#theme'    => 'prop_term',
        '#content'  => $this->buildContent(),
        '#cache'    => [
            'max-age' => 0,
        ],
    );
    }
}