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
      // Initialize the active theme.
      $active_theme = \Drupal::theme()->getActiveTheme()->getName();

      echo "active theme: " . $active_theme;

      self::$initialized = TRUE;
    }
  }


}