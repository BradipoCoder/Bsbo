<?php
/**
 * Created by Adam Jakab.
 * Date: 24/06/16
 * Time: 15.42
 */

namespace Drupal\bsbo\Plugin\Alter;

use Drupal\bootstrap\Annotation\BootstrapAlter;
use Drupal\bootstrap\Plugin\Alter\AlterInterface;
use Drupal\bootstrap\Plugin\PluginBase;

/**
 * Implements hook_theme_suggestions_alter().
 *
 * @BootstrapAlter("theme_suggestions")
 */
class ThemeSuggestions extends PluginBase implements AlterInterface {
  /** @var array */
  protected $unallowedIdentifiers = [
    'table',
    'responsive-enabled',
    'table-bordered',
    'table-hover',
    'table-striped',
    'table-condensed',
  ];

  /**
   * {@inheritdoc}
   */
  public function alter(&$suggestions, &$variables = NULL, &$hook = NULL) {
    switch ($hook) {
      case 'table':
        if ($identifier = $this->getIdentifierFromAttributes($variables["attributes"])) {
          $identifier = "table__" . $identifier;
          if (!in_array($identifier, $suggestions)) {
            $suggestions[] = $identifier;
          }
        }
        break;
    }
  }

  /**
   * @param string $identifier
   *
   * @return string
   */
  protected function cleanUpSuggestionIdentifier($identifier) {
    $answer = $identifier ? trim($identifier) : "";
    $answer = str_replace(["-table"], "", $answer);
    return $answer;
  }

  /**
   * @param array $attributes
   *
   * @return bool|string
   */
  protected function getIdentifierFromAttributes($attributes) {
    $answer = FALSE;
    if (isset($attributes["id"])) {
      $answer = $attributes["id"];
    }
    else if (isset($attributes["class"]) && count($attributes["class"])) {
      //@todo: this is stupid(but works) - find a better way
      foreach ($attributes["class"] as $class) {
        if (!in_array($class, $this->unallowedIdentifiers)) {
          $answer = $class;
          break;
        }
      }
    }
    return $this->cleanUpSuggestionIdentifier($answer);
  }
}
