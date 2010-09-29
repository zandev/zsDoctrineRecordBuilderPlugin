<?php

class zsRecordBuilderDescriptionProvider
{
  public static function getValidDescriptionsWithAttributes()
  {
    return array(
      array(
        'model'   => 'User', 
        'name'    => 'stephane', 
        'attributes' => array(
          'username'  => 'zanshine',
          'firstname' => 'stephane',
          'lastname'  => 'richard',
        ),
        'relations' => array(
          'group'     => 'admin',
          'email'     => 'stephane@zanshine.com'
        ),
      ),
      array(
        'model'   => 'Email', 
        'name'    => 'stephane@zanshine.com', 
        'attributes' => array(
          'address'  => 'stephane@zanshine.com',
        ),
        'relations' => array(
          'user'     => 'stephane',
        ),
      ),
    );
  }
}