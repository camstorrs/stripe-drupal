<?php

use Drupal\stripe_api\StripeApiService;
use Stripe\Subscription;

class DonationStripe {
  public function __construct(StripeApiService $stripe_api) {
    $this->stripeApi = $stripe_api;
  }
  public function loadSubscriptionsMultiple($args = []) {
    $subscriptions = Subscription::all($args);
    if (!count($subscriptions->data)) {
      return FALSE;
    }

    return $subscriptions;
  }
}
