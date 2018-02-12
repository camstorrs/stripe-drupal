<?php
/**
 * @file
 * Contains \Drupal\donate\Controller\DonateController.
 */
namespace Drupal\donate\Controller;

class DonateController {
  public function content() {
    return array(
      '#type' => 'markup',
      '#markup' => t('Donate!'),
    );
  }
}