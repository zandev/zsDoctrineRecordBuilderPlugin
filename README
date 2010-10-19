# Version 0.1
zsDoctrineRecordBuilderPlugin is in an extremely experimental state. But the code is extremely simple and straightforward, and it's quite well test covered.
So, feel free to fork and contribute.

# About
zsDoctrineRecordBuilderPlugin is a symfony 1.4 plugin, for php > 5.3.x and Doctrine 1.2, which help you to build, create and stub records for testing purpose.
It's strongly influenced by [thoughtbot's' factory_girl](http://github.com/thoughtbot/factory_girl)


# Usage

In file test/bootstrap/unit.php

    require_once __DIR__ . '/../fixtures/factories.php';

In file test/fixtures/factories.php

    sfProjectConfiguration::getActive()->loadHelpers('zsDoctrineRecordBuilder');

## Defining factories

Here, we define a builder named 'User'. The model is guessed from the name:

    zs_add_builder('User', function($user) {
	  $user->firstname = 'Stéphane';
      $user->lastname  = 'Richard';
    });

We also can specify the model explicitly:

    zs_add_builder(array('name' => 'Stéphane', 'model' => 'User', function($user) {
	  $user->firstname = 'Stéphane';
      $user->lastname  = 'Richard';
    });

A builder can inherit from another:

    zs_add_builder(array('name' => 'Stéphane', 'extends' => 'User', function($user) {
	  $user->firstname = 'Stéphane';
      $user->lastname  = 'Richard';
    });

## Invoking factories

To build an object with a given factory:

    $record = zs_get_builder('Stéphane')->build();

If you want a persisted object:

    $record = zs_get_builder('Stéphane')->create();

To get an array representation of the record:

    $attributes = zs_get_builder('Stéphane')->attributes();

if you just need a stub, you can retrieve an stdClass instance stubbed out:

    $stub = zs_get_builder('Stéphane')->stub();

## Dealing with relations

Dealing with relations is extremely straightforward:

    zs_add_builder('Group', function($group) {
	  $group->name      = 'Admin';
    });

    zs_add_builder('User', function($user) {
	  $user->firstname = 'Stéphane';
      $user->lastname  = 'Richard';
      $user->groups[]  = zs_get_builder('Group')->build();
    });



















