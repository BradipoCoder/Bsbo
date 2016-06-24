<?php
/**
 * Created by Adam Jakab.
 * Date: 23/06/16
 * Time: 11.30
 */

namespace Drupal\bsbo\Less;

use Drupal\bsbo\Utility\DrupalHelper;

/**
 * Class RealTimeCachedCompiler
 *
 * @package Drupal\bsbo\Less
 */
class RealTimeCachedCompiler {
  /**
   * @var string
   */
  protected $cacheDir = DRUPAL_ROOT . '/sites/default/files/bsbo/less';

  /**
   * @var array
   */
  protected $compilerOptions = [];

  /**
   * RealTimeCachedCompiler constructor.
   *
   * @param array $options
   */
  public function __construct($options = []) {
    $this->setOptions($options);
  }

  /**
   * @param array $options
   */
  public function setOptions($options) {
    foreach ($options as $k => $v) {
      $this->setOption($k, $v);
    }
  }

  /**
   * @param string $key
   * @param mixed $value
   */
  public function setOption($key, $value) {
    if (array_key_exists($key, \Less_Parser::$default_options)) {
      $this->compilerOptions[$key] = $value;
    }
  }

  /**
   *
   * @param bool $force
   *
   * @throws \Exception
   */
  public function compile($force = FALSE) {
    if ($force) {
      $compiledCss = $this->getRecompileThemeLessFilesCss();
      $out = DrupalHelper::getThemePath("bsbo") . "/css/style.css";
      file_put_contents($out, $compiledCss);
    }
  }

  /**
   * @return string
   * @throws \Exception
   */
  protected function getRecompileThemeLessFilesCss() {
    try {
      $lessFile = DrupalHelper::getThemePath("bsbo") . "/less/style.less";
      $variables = [
        'custom_var_1' => '#ff00ff'
      ];
      $parser = new \Less_Parser();
      $parser->SetOptions($this->compilerOptions);
      $parser->ModifyVars($variables);
      $parser->parseFile($lessFile);
      return $parser->getCss();
    } catch(\Exception $e) {
      throw new \Exception(__CLASS__ . " EXCEPTION: " . $e->getMessage());
    }
  }

}