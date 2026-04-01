<?php
/*
 * Plugin Name: digihood branding
 * Plugin URI: https://digihood.cz
 * Description: Branding, automatické sledování aktualizací a reportování klientům.
 * Version: 5.0.0
 * Requires at least: 6.0
 * Requires PHP: 8.0
 * Author: digihood
 * Author URI: https://digihood.cz
 * License: GPL2
 */

namespace digibrand;

if (!defined('ABSPATH')) {
    exit;
}

// Framework constants (required by plugin-framework)
define('D1G1_BRANDING', 'digibrand');
define('D1G1_SITEMAP', D1G1_BRANDING); // Required by plugin-framework Globals
define('D1G1_PLUGSLUG_' . D1G1_BRANDING, 'd1g1_plugins');
define('D1G1_PLUGNAME_' . D1G1_BRANDING, 'digihood branding');
define('D1G1_PATHS_' . D1G1_BRANDING, plugin_dir_path(__FILE__));
define('D1G1_PATHTOFWASSET_' . D1G1_BRANDING, plugin_dir_path(__FILE__) . 'plugin-framework/FrameworkAssets/');
define('D1G1_URL_' . D1G1_BRANDING, plugin_dir_url(__FILE__));

if (!defined('D1G1_SITE_BOX_LANG_SHOW')) {
    define('D1G1_SITE_BOX_LANG_SHOW', ['cs', 'sk-SK']);
}

define('D1G1_GITHUBURL_BRAND', 'https://github.com/digihood/wedesin-branding');
define('D1G1_GITHUBREP_BRAND', 'wedesin-branding');

// GitHub token for plugin updates (read-only access to repo)
if (!defined('GithubToken')) {
    define('GithubToken', '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');
}

// Framework stubs (must be loaded before framework, in global namespace)
include_once __DIR__ . '/src/framework-stubs.php';

// Plugin-framework includes (globals.php + pluginSystem loaded via framework's own includes.php)
include_once __DIR__ . '/plugin-framework/includes.php';

// PSR-4 style autoloader for src/ directory
spl_autoload_register(function (string $class): void {
    $prefix = 'Digihood\\Branding\\';
    $baseDir = __DIR__ . '/src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Add type="module" to gradient scripts (ESM imports)
add_filter('script_loader_tag', function (string $tag, string $handle): string {
    if (in_array($handle, ['digihood-login-gradient', 'digihood-admin-gradient'], true)) {
        $tag = str_replace(' src=', ' type="module" src=', $tag);
    }
    return $tag;
}, 10, 2);

// Boot the plugin
\Digihood\Branding\Plugin::getInstance();
