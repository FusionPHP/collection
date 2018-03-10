<?php
/**
 * Created by PhpStorm.
 * User: Jason Walker
 * Date: 3/10/2018
 * Time: 1:42 PM
 */

use Sami\Sami;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
                  ->files()
                  ->name('*.php')
                  ->in('./src');

return new Sami($iterator, array(
    'title'                  => 'Fusion.Collection API',
    'build_dir'              => __DIR__.'/docs',
    'cache_dir'              => __DIR__.'/cache',
    'default_opened_level'   => 2,
    'sort_class_methods'     => true,
    'sort_class_properties'  => true,
    'sort_class_constants'   => true,
    'sort_class_traits'      => true,
    'sort_class_interfaces'  => true,
));