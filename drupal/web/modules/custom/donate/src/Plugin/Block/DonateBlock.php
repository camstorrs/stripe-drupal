<?php

namespace Drupal\donate\Plugin\Block;

use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Donate' Block.
 *
 * @Block(
 *   id = "donate",
 *   admin_label = @Translation("donate block"),
 *   category = @Translation("donate"),
 * )
 */
class DonateBlock extends BlockBase implements BlockPluginInterface {

  /**
   * {@inheritdoc}
   */
    public function build() {
    $config = $this->getConfiguration();

    if (!empty($config['donate_block_name'])) {
      $name = $config['donate_block_name'];
    }
    else {
      $name = $this->t('to no one');
    }
    return array(
      '#markup' => $this->t('Hello @name!', array(
        '@name' => $name,
      )),
    );
  }
  // public function build() {
  //   return array(
  //     '#markup' => $this->t('Donation Block...'),
  //   );
  // }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['donate_block_name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Who'),
      '#description' => $this->t('Who do you want to Dontate to?'),
      '#default_value' => isset($config['donate_block_name']) ? $config['donate_block_name'] : '',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['donate_block_name'] = $form_state->getValue(array('donatefieldset', 'donate_block_name'));
  }  

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $default_config = \Drupal::config('donate.settings');
    return [
      'donate_block_name' => $default_config->get('donate.name'),
    ];
  }

}
