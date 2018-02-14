<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 6.12.17.
 * Time: 11.14
 */

namespace Drupal\blog_archive\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a custom block
 *
 * @Block(
 *   id = "blog_archive",
 *   admin_label = @Translation("Blog Archive block"),
 *   category = @Translation("Custom block"),
 * )
 */
class BlogArchiveBlock extends BlockBase
{
    public function buildContent()
    {

        $query = \Drupal::database()->select( 'node_field_data', 'n' );
        $query->innerJoin('node__field_date','nfd', 'nfd.entity_id = n.nid');

        $query->addField('nfd','field_date_value', 'date');
        $query->addField('n','nid');

        $query->range(5, 10);
        $query->orderBy( 'date', 'DESC' );

        $results = $query->execute()->fetchAll();

        $output = [];

        foreach ( $results as $result ) {

            $timestamp = strtotime($result->date);
            $date = date('F Y', $timestamp);

            $output[$date]['date']= $date;
            if(empty($output[$date]['url'])){
                $output[$date]['url'] = '?ids=';
            }
            $output[$date]['url'] .= $result->nid.',';
        }
        $output = array_values($output);

        return $output;
    }

    public function build()
    {

        return array(
            '#theme' => 'blog_archive',
            '#content' => $this->buildContent(),
            '#cache' => [
                'max-age' => 0,
            ],
        );
    }
}