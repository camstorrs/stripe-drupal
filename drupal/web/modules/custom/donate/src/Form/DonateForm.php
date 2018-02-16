<?php

namespace Drupal\donate\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class DonateForm extends FormBase
{

    protected $donation_amount;
    protected $charge_result;
    protected $stripe_shared_test_key = 'sk_test_kfm6fTNBSJ6LSyokVz3mCkbY';
    protected $stripe_test_key;
    protected $config;

    public function getFormId()
    {
        return 'donateform';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config('donatestripe.settings');

        if (!empty($config->get('test_secret_key'))) {
            $this->stripe_test_key = $config->get('test_secret_key');
        } else {
            $this->stripe_test_key = $this->stripe_shared_test_key; //personal stripe test account.
        }

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return $this->redirect('<front>');
        }

        $stripe_token = \Drupal::request()->request->get('stripeToken');
        $stripe_email = \Drupal::request()->request->get('stripeEmail');
        // Pass multiple key => value to other submit callbacks.

        // TODO Address why values are not persisted to validate or submit method. Use cookies as a workaround
        // $form_state->set('token', $stripe_token);
        // $form_state->set('email', $stripe_email);

        setcookie("stripe_token", $stripe_token);
        setcookie("stripe_email", $stripe_email);

        $rec_amounts = [
            '' => '$0',
            '20.00' => '$20',
            '30.00' => '$30',
            '40.00' => '$40',
            '50.00' => '$50',
            '100.00' => '$100',
        ];

        $form['donation_amount'] = array(
            '#type' => 'select',
            '#title' => $this->t('Select a dollar amount to donate?.'),
            '#required' => true,
            '#options' => $rec_amounts
        );

        $form['email'] = array(
            '#type' => 'textfield',
            '#attributes' => array('readonly' => 'readonly'),
            '#title' => $this->t('Email'),
            '#required' => false,
            '#value' => $stripe_email,
        );

        $form['full_name'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Full Name'),
            '#required' => true,
        );

        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Donate!'),
        );

        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        if (!$this->isCurrency($form_state->getValue('donation_amount'))) {

            $form_state->setError($form['donation_amount'], 'Please enter a valid currency in USD.');
        }
    }

    protected function isCurrency($data)
    {
        return preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $data);
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {

        $charge_data = [
            'amount' => str_replace(".", "", $form_state->getValue('donation_amount')),
            'currency' => 'usd',
            'source' => $_COOKIE['stripe_token'],
            'description' => $_COOKIE['stripe_email'],
        ];

        try {
            \Stripe\Stripe::setApiKey($this->stripe_test_key);
            $this->charge_result = \Stripe\Charge::create($charge_data);
        } catch (\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            $body = $e->getJsonBody();
            $err = $body['error'];
            //Log error and send notice
        }

        if (!empty($form_state->getValue('donation_amount'))) {
            $this->donation_amount = $form_state->getValue('donation_amount');
        } else {
            $this->donation_amount = $form_state->getValue('donation_amount_manual');
        }

        drupal_set_message($this->t('Thank you ' .
            $form_state->getValue('full_name') . ' for your donation of $' . $this->donation_amount . '!'));
    }


}