<?php
/**
 * Created by Adam Jakab.
 * Date: 22/06/16
 * Time: 14.34
 */

namespace Drupal\bsbo;


class Bsbo
{
  public static $initialized = FALSE;

  /**
   * Initializes the active theme.
   */
  final public static function initialize()
  {
    if (!self::$initialized)
    {
      // Active theme.
      $active_theme = \Drupal::theme()->getActiveTheme()->getName();
      //echo "active theme: " . $active_theme;

      self::compileLess();

      self::$initialized = TRUE;

    }
  }

  /**
   * @todo: implement caching
   * @see: https://github.com/oyejorge/less.php
   *
   * @throws \Exception
   */
  protected static function compileLess()
  {
    $themePath = drupal_get_path("theme", "bsbo");
    $vendorPath = self::getVendorPath();
    $bootstrapPath = $vendorPath . '/twbs/bootstrap';

    $in = $themePath . "/less/style.less";
    $out = $themePath . "/css/style.css";

    //echo "<br />THEME PATH: " . $themePath;
    //echo "<br />VENDOR PATH: " . $vendorPath;
    //echo "<br />BS PATH: " . $bootstrapPath;
    //echo "<br />";

    require_once $vendorPath . "/oyejorge/less.php/lib/Less/Autoloader.php";
    \Less_Autoloader::register();

    try
    {
      $parser = new \Less_Parser();
      $parser->SetOption("compress", TRUE);

      /**
       * The @import references in less/bootstrap.less file to the bootstrap/less directory
       * are like this: "../vendor/twbs/bootstrap/less/variables";
       * this is correct for development environment where the vendor folder is under themes/bsbo
       * but then this theme is installed with composer the dependencies (like bootstrap) will end up
       * in the /vendor folder
       */
      $parser->SetImportDirs(
        [
          $themePath . '/less',
          '/themes',
        ]
      );

      $parser->parseFile($in);
      $css = $parser->getCss();
      file_put_contents($out, $css);


      //echo "<br />LESS IMPORTED: " . json_encode($parser->AllParsedFiles(), JSON_PRETTY_PRINT);

    } catch(\Exception $e)
    {
      throw new \Exception("LESS COMPILER EXCEPTION: " . $e->getMessage());
    }
  }

  protected static function getBootstrapPath()
  {

  }

  /**
   * @return string
   * @throws \Exception
   */
  protected static function getVendorPath()
  {
    $themePath = drupal_get_path("theme", "bsbo");
    if (is_dir($themePath . '/vendor'))
    {
      return ($themePath . '/vendor');
    }
    else if (is_dir(DRUPAL_ROOT . '/vendor'))
    {
      return DRUPAL_ROOT . '/vendor';
    }
    else
    {
      throw new \Exception("No vendor Path!");
    }
  }

}