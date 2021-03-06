<?php
/**
 * This file is a part of the phpMussel package, and can be downloaded for free
 * from {@link https://github.com/Maikuolan/phpMussel/ GitHub}.
 *
 * PHPMUSSEL COPYRIGHT 2013 AND BEYOND BY THE PHPMUSSEL TEAM.
 *
 * Authors:
 * @see PEOPLE.md
 *
 * License: GNU/GPLv2
 * @see LICENSE.txt
 *
 * This file: The loader (last modified: 2017.01.05).
 */

/**
 * phpMussel should only be loaded once per PHP instance. To ensure this, we
 * check for the existence of a "phpMussel" constant. If it doesn't exist, we
 * define it and continue loading. If it already exists, we warn the client and
 * kill the script.
 */
if (!defined('phpMussel')) {
    define('phpMussel', true);

    if (!version_compare(PHP_VERSION, '5.4.0', '>=')) {
        header('Content-Type: text/plain');
        die('[phpMussel] Not compatible with PHP versions below 5.4.0; Please update PHP in order to use phpMussel.');
    }

    /** Create an array for our working data. */
    $phpMussel = array();

    /** Determine the location of the "vault" directory. */
    $phpMussel['Vault'] = __DIR__ . '/vault/';

    /** Kill the script if we can't find the vault directory. */
    if (!is_dir($phpMussel['Vault'])) {
        header('Content-Type: text/plain');
        die(
            '[phpMussel] Vault directory not correctly set: Can\'t continue.' .
            ' Refer to documentation if this is a first-time run, and if pro' .
            'blems persist, seek assistance.'
        );
    }

    /** Define the location of the "cache" directory. */
    $phpMussel['cachePath'] = $phpMussel['Vault'] . 'cache/';

    /** Define the location of the "lang" directory. */
    $phpMussel['langPath'] = $phpMussel['Vault'] . 'lang/';

    /** Define the location of the "plugins" directory. */
    $phpMussel['pluginPath'] = $phpMussel['Vault'] . 'plugins/';

    /** Define the location of the "quarantine" directory. */
    $phpMussel['qfuPath'] = $phpMussel['Vault'] . 'quarantine/';

    /** Define the location of the "signatures" directory. */
    $phpMussel['sigPath'] = $phpMussel['Vault'] . 'signatures/';

    /** Checks whether we're calling phpMussel directly or through a hook. */
    $phpMussel['Direct'] = function () {
        return (str_replace("\\", '/', strtolower($_SERVER['SCRIPT_FILENAME'])) === str_replace("\\", '/', strtolower(__FILE__)));
    };

    /**
     * Check whether the functions file exists; If it doesn't, kill the script.
     */
    if (!file_exists($phpMussel['Vault'] . 'functions.php')) {
        header('Content-Type: text/plain');
        die('[phpMussel] Functions file missing! Please reinstall phpMussel.');
    }
    /** Load the functions file. */
    require $phpMussel['Vault'] . 'functions.php';

    /**
     * Check whether the configuration handler exists; If it doesn't, kill the
     * script.
     */
    if (!file_exists($phpMussel['Vault'] . 'config.php')) {
        header('Content-Type: text/plain');
        die('[phpMussel] Configuration handler missing! Please reinstall phpMussel.');
    }
    /** Load the configuration handler. */
    require $phpMussel['Vault'] . 'config.php';

    /**
     * Check whether the language handler exists; Kill the script if it
     * doesn't.
     */
    if (!file_exists($phpMussel['Vault'] . 'lang.php')) {
        header('Content-Type: text/plain');
        die('[phpMussel] Language handler missing! Please reinstall phpMussel.');
    }
    /** Load the language handler. */
    require $phpMussel['Vault'] . 'lang.php';

    /** Scrap variables used for processing plugins. */
    $x = $HookID = '';

    /** PHP binary version-specific switch variables. */
    $phpMussel['binary_versions'] = array(
        '7.0.0' => version_compare(PHP_VERSION, '7.0.0', '>='),
        '5.6.0' => version_compare(PHP_VERSION, '5.6.0', '>=')
    );

    /** Preserve INI defaults for when we exit cleanly. */
    $phpMussel['inidefaults'] = array(
        'backtrack_limit' => ini_get('pcre.backtrack_limit'),
        'recursion_limit' => ini_get('pcre.recursion_limit'),
        'default_charset' => ini_get('default_charset'),
        'user_agent' => ini_get('user_agent')
    );

    /** Preserve INI defaults for when we exit cleanly. */
    if (!$phpMussel['binary_versions']['5.6.0']) {
        $phpMussel['inidefaults']['internal_encoding'] = ini_get('mbstring.internal_encoding');
    }

    /**
     * Helps to prevent PCRE from backticking itself and the entire PHP process
     * into oblivion during certain scanning operations.
     */
    ini_set('pcre.backtrack_limit', '4K');

    /**
     * Helps to prevent PCRE from overloading the PHP process via excessive
     * capturing during certain scanning operations.
     */
    ini_set('pcre.recursion_limit', '4K');

    /** We should always use UTF-8. */
    ini_set('default_charset', 'utf-8');

    /** We should always use UTF-8. */
    if (!$phpMussel['binary_versions']['5.6.0']) {
        ini_set('mbstring.internal_encoding', 'UTF-8');
    }

    /** Set the phpMussel User Agent. */
    ini_set('user_agent', $phpMussel['ScriptUA']);

    /**
     * Create an array to use as a temporary memory cache for scanning
     * operations (note: this has nothing to do with the memCache extension of
     * PHP; the variable name is coincidental).
     */
    $phpMussel['memCache'] = array();

    /**
     * Used to determine whether we've reached the end of this file without
     * exiting cleanly (important for rendering scan results correctly).
     */
    $phpMussel['EOF'] = false;

    /** A safety feature for logging. */
    $phpMussel['safety'] = "\x3c\x3fphp die; \x3f\x3e";

    /**
     * If phpMussel is "disabled" (if the "disable lock" is engaged), nothing
     * within this block should execute (thus effectively disabling phpMussel).
     */
    if (!$phpMussel['disable_lock'] = file_exists($phpMussel['Vault'] . 'disable.lck')) {

        /** Plugins are detected and processed by phpMussel here. */
        $phpMussel['MusselPlugins'] = array('hooks' => array(), 'hookcounts' => array(), 'closures' => array());
        if ($phpMussel['Config']['general']['enable_plugins']) {
            if (!is_dir($phpMussel['Vault'] . 'plugins')) {
                header('Content-Type: text/plain');
                die('[phpMussel] ' . $phpMussel['Config']['lang']['plugins_directory_nonexistent']);
            }
            $phpMussel['MusselPlugins']['tempdata'] = array();
            if ($phpMussel['MusselPlugins']['tempdata']['d'] = opendir($phpMussel['Vault'] . 'plugins')) {
                while (false !== ($phpMussel['MusselPlugins']['tempdata']['f'] = readdir($phpMussel['MusselPlugins']['tempdata']['d']))) {
                    if (
                        $phpMussel['MusselPlugins']['tempdata']['f'] !== '.' &&
                        $phpMussel['MusselPlugins']['tempdata']['f'] !== '..' &&
                        is_dir($phpMussel['pluginPath'] . $phpMussel['MusselPlugins']['tempdata']['f']) &&
                        file_exists($phpMussel['pluginPath'] . $phpMussel['MusselPlugins']['tempdata']['f'] . '/plugin.php') &&
                        !is_link($phpMussel['pluginPath'] . $phpMussel['MusselPlugins']['tempdata']['f'] . '/plugin.php')
                    ) {
                        require_once $phpMussel['pluginPath'] . $phpMussel['MusselPlugins']['tempdata']['f'] . '/plugin.php';
                    }
                }
            }
            closedir($phpMussel['MusselPlugins']['tempdata']['d']);
            $phpMussel['MusselPlugins']['tempdata'] = array();
        }

        /* This code block only executed if we're NOT in CLI mode. */
        if (!$phpMussel['Mussel_sapi']) {

            /**
             * Check whether the upload handler exists and attempt to load it.
             */
            if (file_exists($phpMussel['Vault'] . 'upload.php')) {
                require $phpMussel['Vault'] . 'upload.php';
            }

            /**
             * Check whether the front-end handler exists and attempt to load
             * it. Skip this check if front-end access is disabled.
             */
            if (
                !$phpMussel['Config']['general']['disable_frontend'] &&
                file_exists($phpMussel['Vault'] . 'frontend.php') &&
                $phpMussel['Direct']()
            ) {
                require $phpMussel['Vault'] . 'frontend.php';
            }

        }

        /**
         * Check whether the CLI handler exists and attempt to load it.
         * This code block only executed if we're in CLI mode.
         */
        elseif (file_exists($phpMussel['Vault'] . 'cli.php')) {
            require $phpMussel['Vault'] . 'cli.php';
        }

    }

    /** Restore default User Agent. */
    ini_set('user_agent', $phpMussel['inidefaults']['user_agent']);

    if ($phpMussel['Config']['general']['cleanup']) {

        /** Restore default internal encoding. */
        if (!$phpMussel['binary_versions']['5.6.0']) {
            ini_set('mbstring.internal_encoding', $phpMussel['inidefaults']['internal_encoding']);
        }
        /** Restore default charset. */
        ini_set('default_charset', $phpMussel['inidefaults']['default_charset']);
        /** Restore default PCRE recursion limit. */
        ini_set('pcre.recursion_limit', $phpMussel['inidefaults']['recursion_limit']);
        /** Restore default PCRE backtrack limit. */
        ini_set('pcre.backtrack_limit', $phpMussel['inidefaults']['backtrack_limit']);

        /** Destroy unrequired plugin closures. */
        if (isset($phpMussel['MusselPlugins']['closures'])) {
            $phpMussel['MusselPlugins']['c'] = count($phpMussel['MusselPlugins']['closures']);
            for (
                $phpMussel['MusselPlugins']['i'] = 0;
                $phpMussel['MusselPlugins']['i'] < $phpMussel['MusselPlugins']['c'];
                $phpMussel['MusselPlugins']['i']++
            ) {
                $x = $phpMussel['MusselPlugins']['closures'][$phpMussel['MusselPlugins']['i']];
                if (isset($$x) && is_object($$x)) {
                    unset($$x);
                }
            }
        }

        /** Unset our working data so that we can exit cleanly. */
        unset($HookID, $x, $phpMussel);

    } else {

        /** Let the script know that we haven't exited cleanly. */
        $phpMussel['EOF'] = true;

    }

} else {
    header('Content-Type: text/plain');
    echo
        (!isset($phpMussel['Config']['lang']['instance_already_active'])) ?
        '[phpMussel] Instance already active! Please double-check your hooks.' :
        '[phpMussel] ' . $phpMussel['Config']['lang']['instance_already_active'];
    die;
}
