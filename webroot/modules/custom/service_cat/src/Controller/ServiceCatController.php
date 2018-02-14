<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 26.12.17.
 * Time: 10.53
 */

namespace Drupal\service_cat\Controller;

use Drupal\Core\Controller\ControllerBase;

class ServiceCatController extends ControllerBase
{
    public function buildContent(){
       $build = [
           '#markup' => t('Hello World!'),
       ];
       return $build;
    }

    public function content() {
        $render[] = [
            '#theme' => 'service_cat',
            '#content' => $this->buildContent(),
            '#cache' => [
                'max-age' => 0,
            ],
        ];
        return $render;
    }
}