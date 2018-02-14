<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 27.12.17.
 * Time: 10.36
 */

namespace Drupal\properties_page\Plugin\Block;

use Drupal\Core\Block\BlockBase;
/**
 * Provides a 'FromPropertiesBlock' block
 *
 * @Block(
 *  id = "block_properties_front",
 *  admin_label = @Translation("Properties on frontpage"),
 * )
 */
class FromPropertiesBlock extends BlockBase
{

    public function build() {

        $c_var = new \Drupal\properties_page\Controller\PropertiesPageController();

        $render[] = [
            '#theme' => 'from_prop',
            '#content' => $c_var->buildContent(9),
            '#cache' => [
                'max-age' => 0,
            ],
        ];
        return $render;

    }

}