<?php
/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Webman\Route;

// Load routes from enabled addons after the application's routes.
foreach (glob(app_path('addons') . '/*/addon.php') ?: [] as $manifestFile) {
    $addon = require $manifestFile;
    if (!is_array($addon) || empty($addon['enabled'])) {
        continue;
    }

    $routeFile = dirname($manifestFile) . '/routes.php';
    if (is_file($routeFile)) {
        require $routeFile;
    }
}
