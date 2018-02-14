<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 11.12.17.
 * Time: 13.18
 */

namespace Drupal\blog_list\Plugin\Block;

use Drupal\blog_list\Controller\BlogListController;
use Drupal\Core\Block\BlockBase;


/**
 * Provides a 'FromBlogBlock' block
 *
 * @Block(
 *  id = "from_blog",
 *  admin_label = @Translation("Blog on frontpage"),
 * )
 */
class FromBlogBlock extends BlockBase
{

    public function build() {

        $c_var = new BlogListController();

        $render[] = [
            '#theme' => 'from_blog',
            '#content' => $c_var->buildContent(3),
            '#cache' => [
                'max-age' => 0,
            ],
        ];
        return $render;

    }


}