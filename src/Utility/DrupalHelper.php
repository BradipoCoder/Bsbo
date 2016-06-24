<?php
/**
 * Created by Adam Jakab.
 * Date: 23/06/16
 * Time: 11.42
 */

namespace Drupal\bsbo\Utility;

/**
 * Drupal global functions proxy class
 *
 * Class DrupalHelper
 *
 * @package Drupal\bsbo\Utility
 */
class DrupalHelper {
  /**
   * @return string
   * @throws \Exception
   */
  public static function getVendorPath() {
    $themePath = self::getThemePath("bsbo");
    if (is_dir($themePath . '/vendor')) {
      return ($themePath . '/vendor');
    }
    else if (is_dir(DRUPAL_ROOT . '/vendor')) {
      return DRUPAL_ROOT . '/vendor';
    }
    else {
      throw new \Exception("No vendor Path!");
    }
  }

  /**
   * @param string $name
   *
   * @return string
   */
  public static function getThemePath($name) {
    return self::drupalGetPath('theme', $name);
  }

  /**
   * @param string $type
   * @param string $name
   *
   * @return string
   */
  protected static function drupalGetPath($type, $name) {
    return drupal_get_path($type, $name);
  }
}