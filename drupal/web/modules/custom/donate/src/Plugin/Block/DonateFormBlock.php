<?php

namespace Drupal\donate\Plugin\Block;


use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\Request;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "donate_block",
 *   admin_label = @Translation("Donate Block"),
 *   category = @Translation("Custom"),
 * )
 */
class DonateFormBlock extends BlockBase
{
    private $stripe_js_string;

    public function build()
    {
        return array(
            //'#markup' => $this->t($this->stripe_js_string),
            '#markup' => $this->t('
<form action="/donate/form" method="POST">
<script
src="https://checkout.stripe.com/checkout.js" class="stripe-button"
data-key="pk_test_Z2ti6Fu6qjAesBYDVeOmX8tD"
data-name="Donation Demo Site"
data-description="Donation Widge"
data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
data-locale="auto">
</script>
</form>')

        );
    }

}




