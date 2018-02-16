<?php

namespace Drupal\donate\Plugin\Block;

use Drupal\Core\Block\BlockPluginInterface;
use Symfony\Component\HttpFoundation\Request;


use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Donate' Block.
 *
 * @Block(
 *   id = "donate_block",
 *   admin_label = @Translation("Donate with Stripe"),
 *   category = @Translation("Custom"),
 * )
 */
class DonateFormBlock extends BlockBase
{
    // TODO Add keys to yaml config file and create admin config form/interface
    // TODO Move JS to file and use yml/twig/hook

    protected $stripe_test_pub_key = 'pk_test_Z2ti6Fu6qjAesBYDVeOmX8tD';

    //Move JS to file to load via yaml/twig/hook
    public function build()
    {
        return array(
            '#markup' => $this->t('
<form action="/donate/form" method="POST">
<script
src="https://checkout.stripe.com/checkout.js" class="stripe-button"
data-key=' . $this->stripe_test_pub_key .'  
data-name="Donation Demo Site"
data-description="Donation Widget"
data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
data-locale="auto">
</script>
</form>')

        );
    }

}




