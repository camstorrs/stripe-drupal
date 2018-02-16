Repo https://github.com/camstorrs/stripe-drupal

Documentation on installing the dreupal Virtual Machine (VM) is located at https://github.com/camstorrs/stripe-drupal 

After the VM is created run composer from the drupal web dir to install dependencies

The github “project” documents are available at https://github.com/camstorrs/stripe-drupal/projects/1 


Five open issues have been created on github at https://github.com/camstorrs/stripe-drupal/issues 

The Stripe Donation module I created is located in the modules/custom/donate directory.


Stripe API keys are located in the config settings for the donate module and will need to be updated in the two files that make request to the stripe API. An admin configuration form for the Donate module does not exist. My personal keys are in the config/install/yml and code files. I can provide my stripe login credentials if desired.

The two files that contain the Stripe API public and secret keys are in the module at /module/custom/donate/src/Form/DonateForm.php 

Update the property declaration "protected $stripe_shared_test_key = 'sk_test_kfm6fTNBSJ6LSyokVz3mCkbY';” with your secret test key.
The file DonateFormBlock.php located in /module/custom/donate/src/Plugin/Block/ contains the property protected $stripe_
test_pub_key = 'pk_test_Z2ti6Fu6qjAesBYDVeOmX8tD';” that will also need to be updated with your public stripe key.
