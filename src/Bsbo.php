<?php
/**
 * Created by Adam Jakab.
 * Date: 22/06/16
 * Time: 14.34
 */

namespace Drupal\bsbo;

use Drupal\bsbo\Less\RealTimeCachedCompiler;

/**
 * Class Bsbo
 *
 * @package Drupal\bsbo
 */
class Bsbo
{
  public static $initialized = FALSE;

  /**
   * Initializes the active theme.
   */
  final public static function initialize() {
    echo "BSBO INIT";

    /*
    if (!self::$initialized)
    {
      $compiler = new RealTimeCachedCompiler(['compress' => true]);
      $compiler->compile(true);

      self::$initialized = TRUE;
    }
    */
  }

}