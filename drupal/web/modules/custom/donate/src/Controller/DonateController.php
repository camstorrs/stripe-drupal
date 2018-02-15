<?php

namespace Drupal\donate\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;

class DonateController extends ControllerBase {

    /**
     * Controller to return a POST or a GET parameter.
     */
    public function request(Request $request) {

       // $token = $request->request->get('token');
        $stripe_form_data = $request->request->all();
        $stripe_form_data['token'];
        $stripe_form_data['email'];
        print_r($stripe_form_data); die('####');
        return ['#markup' => $stripe_form_data];
    }

}