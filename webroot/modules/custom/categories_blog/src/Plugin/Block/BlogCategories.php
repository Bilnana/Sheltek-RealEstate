<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 5.12.17.
 * Time: 13.11
 */

namespace Drupal\categories_blog\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a custom block
 *
 * @Block(
 *   id = "categories_blog",
 *   admin_label = @Translation("Blog Categories"),
 *   category = @Translation("Custom block"),
 * )
 */
class BlogCategories extends BlockBase
{

    public function buildContent()
    {

        $query = \Drupal::database()->select('taxonomy_index', 't');
        $query->leftJoin('taxonomy_term_field_data', 'tf', 't.tid = tf.tid');
        $query->condition('tf.vid', 'blog_categories', '=');
        $query->addExpression('COUNT(t.nid)', 'cnt');
        $query->addExpression('tf.name', 'name');
        $query->addExpression('tf.name', 'na');

        $query->groupBy('name');


        $data = [];

        $results = $query->execute()->fetchAll();

        foreach ($results as $result) {


            $try = $result->name;
            $suc = str_replace(' ', '-', $try);
            $alias = \Drupal::service('path.alias_manager')->getAliasByPath('/taxonomy/term/'.$suc);

            $data[] = [
                'name' => strtolower($alias),
                'count' => $result->cnt,
                'na' => $result->na,
            ];
        }

        return $data;

    }

    public function build()
    {

        return array(
            '#theme' => 'categories_blog',
            '#content' => $this->buildContent(),
            '#cache' => [
                'max-age' => 0,
            ],
        );
    }
}
