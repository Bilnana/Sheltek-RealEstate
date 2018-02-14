<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 5.1.18.
 * Time: 16.57
 */

namespace  Drupal\route_change\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

class RouteSubscriber extends RouteSubscriberBase
{
    protected function alterRoutes(RouteCollection $collection)
    {
        if ($route = $collection->get('user.register')) {
            $route->setPath('/login');
        }
    }
}