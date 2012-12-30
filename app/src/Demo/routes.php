<?php
/**
 * Part of Fonto Framework
 *
 * Sets routing for the application.
 */

/**
 * Routing system setup
 */

/**
 * Registers a default route
 */
$router->addRoute(
    '/',
    array(
        'mapsTo' => 'home#index',
    )
);

/**
 * Registers controllers
 */
$router->addRoute(
    '<:controller>',
    array(
        'mapsTo' => array(
            'home',
            'content' => array(
                'restful' => true,
            ),
            'guestbook' => array(
                'restful' => true,
            ),
            'blog',
            'page',
            'user' => array(
                'restful' => true,
            ),
            'theme' => array(
                'restful' => false,
            ),
            'doc'
        ),
    )
);