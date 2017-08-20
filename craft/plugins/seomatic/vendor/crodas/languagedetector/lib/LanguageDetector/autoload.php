<?php
/**
 *  Autoloader function generated by crodas/Autoloader
 *
 *  https://github.com/crodas/Autoloader
 *
 *  This is a generated file, do not modify it.
 */

spl_autoload_register(function ($class) {
    /*
        This array has a map of (class => file)
    */

    // classes {{{
    static $classes = array (
  'languagedetector\\abstractformat' => '/AbstractFormat.php',
  'languagedetector\\config' => '/Config.php',
  'languagedetector\\detect' => '/Detect.php',
  'languagedetector\\distance\\outofplace' => '/Distance/OutOfPlace.php',
  'languagedetector\\distanceinterface' => '/DistanceInterface.php',
  'languagedetector\\format\\abstractfileformat' => '/Format/AbstractFileFormat.php',
  'languagedetector\\format\\json' => '/Format/JSON.php',
  'languagedetector\\format\\php' => '/Format/PHP.php',
  'languagedetector\\format\\ses' => '/Format/SES.php',
  'languagedetector\\learn' => '/Learn.php',
  'languagedetector\\ngramparser' => '/NGramParser.php',
  'languagedetector\\sort\\pagerank' => '/Sort/PageRank.php',
  'languagedetector\\sort\\sortinterface' => '/Sort/SortInterface.php',
  'languagedetector\\sort\\sum' => '/Sort/Sum.php',
);
    // }}}

    // deps {{{
    static $deps    = array (
  'languagedetector\\distance\\outofplace' => 
  array (
    0 => 'languagedetector\\distanceinterface',
  ),
  'languagedetector\\format\\abstractfileformat' => 
  array (
    0 => 'languagedetector\\abstractformat',
  ),
  'languagedetector\\format\\json' => 
  array (
    0 => 'languagedetector\\abstractformat',
    1 => 'languagedetector\\format\\abstractfileformat',
  ),
  'languagedetector\\format\\php' => 
  array (
    0 => 'languagedetector\\abstractformat',
    1 => 'languagedetector\\format\\abstractfileformat',
  ),
  'languagedetector\\format\\ses' => 
  array (
    0 => 'languagedetector\\abstractformat',
    1 => 'languagedetector\\format\\abstractfileformat',
  ),
  'languagedetector\\sort\\pagerank' => 
  array (
    0 => 'languagedetector\\sort\\sortinterface',
  ),
  'languagedetector\\sort\\sum' => 
  array (
    0 => 'languagedetector\\sort\\sortinterface',
  ),
);
    // }}}

    $class = strtolower($class);
    if (isset($classes[$class])) {
        if (!empty($deps[$class])) {
            foreach ($deps[$class] as $zclass) {
                if (!class_exists($zclass, false) && !interface_exists($zclass, false)) {
                    require __DIR__  . $classes[$zclass];
                }
            }
        }

        if (!class_exists($class, false) && !interface_exists($class, false)) {

            require __DIR__  . $classes[$class];

        }
        return true;
    }

    /**
     * Autoloader that implements the PSR-0 spec for interoperability between
     * PHP software.
     *
     * kudos to @alganet for this autoloader script.
     * borrowed from https://github.com/Respect/Validation/blob/develop/tests/bootstrap.php
     */
    $fileParts = explode('\\', ltrim($class, '\\'));
    if (false !== strpos(end($fileParts), '_')) {
        array_splice($fileParts, -1, 1, explode('_', current($fileParts)));
    }
    $file = stream_resolve_include_path(implode(DIRECTORY_SEPARATOR, $fileParts) . '.php');
    if ($file) {
        return require $file;
    }
    return false;
});


