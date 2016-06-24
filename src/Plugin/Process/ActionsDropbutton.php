<?php
/**
 * Created by Adam Jakab.
 * Date: 24/06/16
 * Time: 12.05
 */

namespace Drupal\bsbo\Plugin\Process;

use Drupal\bootstrap\Annotation\BootstrapProcess;
use Drupal\bootstrap\Plugin\Process\ProcessBase;
use Drupal\bootstrap\Plugin\Process\ProcessInterface;
use Drupal\bootstrap\Utility\Element;
use Drupal\Core\Form\FormStateInterface;

/**
 * This is a full overwrite because of bug - in node save 
 *
 * @BootstrapProcess("actions__dropbutton",
 *   replace = "Drupal\Core\Render\Element\Actions::preRenderActionsDropbutton",
 * )
 *
 * @see Drupal\bootstrap\Plugin\Process\ActionsDropbutton
 *
 */
class ActionsDropbutton extends ProcessBase implements ProcessInterface {

  public static function processElement(Element $element,
                                        FormStateInterface $form_state,
                                        array &$complete_form) {
    $dropbuttons = Element::create();
    foreach ($element->children(TRUE) as $key => $child) {
      if ($dropbutton = $child->getProperty('dropbutton')) {
        // If there is no dropbutton for this button group yet, create one.
        if (!isset($dropbuttons->$dropbutton)) {
          $dropbuttons->$dropbutton = ['#type' => 'dropbutton'];
        }

        $dropbuttons[$dropbutton]['#links'][$key] = $child->getArray();

        // Remove original child from the element so it's not rendered twice.
        //unset($element->$key);
        // fix for no-node-save bug: https://www.drupal.org/node/2657124
        $child->setProperty('printed', TRUE);
      }
    }
    $element->exchangeArray($dropbuttons->getArray() + $element->getArray());
  }
}