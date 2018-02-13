<?php

namespace Drupal\donate\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\stripe_api\StripeApiService;

class DonateForm extends FormBase {

  protected $accepted_domains = ['thinkshout.com', 'gmail.com'];

  public function getFormId() {
    return 'donateform';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $rec_amounts = [
      ''      => '$0',
      '20.00' => '$20', 
      '30.00' => '$30', 
      '40.00' => '$40', 
      '50.00' => '$50',
      '100.00' => '$100',
    ];

    $form['donation_amount'] = array(
      '#type' => 'select',
      '#title' => $this->t('Select a dollar amount to donate?.'),
      '#required' => false,
      '#options' => $rec_amounts
    );

    $form['donation_amount_manual'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Or enter a dontation amount in USD'),
      '#required' => false,
    );

    $form['full_name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Full Name'),
      '#required' => true,
    );

    $form['email_address'] = array(
      '#type' => 'email',
      '#title' => $this->t('What is your email address?'),
      '#required' => true,
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit!'),
    );

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {

    if (!empty($form_state->getValue('donation_amount')) && 
        !empty($form_state->getValue('donation_amount_manual'))) {

      $form_state->setError($form['donation_amount'], 'Please enter a single donation amount.');

    }  elseif (!$this->isCurrency($form_state->getValue('donation_amount')) && 
               !$this->isCurrency($form_state->getValue('donation_amount_manual'))) {

      $form_state->setError($form['donation_amount'], 'Please enter a valid currency in USD.');
    }

    if (!filter_var($form_state->getValue('email_address'), FILTER_VALIDATE_EMAIL)) {
      $form_state->setError($form['email_address'], 'Email address is invalid.');
    }

    if (!$this->validEmailAddress($form_state->getValue('email_address'))) {
      $form_state->setError($form['email_address'], 'Sorry, Please enter a valid email address.');
    }
  }

  protected function isCurrency($data) {
    return preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $data);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    if (!empty($form_state->getValue('donation_amount'))) {
      $this->donation_amount = $form_state->getValue('donation_amount');
    } else {
      $this->donation_amount = $form_state->getValue('donation_amount_manual');
    }
    drupal_set_message($this->t('Thank you for your donation! $' . $this->donation_amount));
  }

  protected function validEmailAddress($email_address) {
    $domain = explode('@', $email_address)[1];
    return in_array($domain, $this->accepted_domains);
  }

  protected function validateDonationField() {
    return;
  }
}