<?php

class zsRecordBuilderDescriptionProvider
{
  public static function getValidDescriptionsWithAttributes()
  {
    return array(
      array(
        'model'         => 'User', 
        'name'          => 'stephane', 
        'attributes'    => array(
          'username'      => 'zanshine',
          'firstname'     => 'stephane',
          'lastname'      => 'richard',
        ),
      ),
      array(
        'model'         => 'Email', 
        'name'          => 'stephane-mail', 
        'attributes'    => array(
          'address'       => 'stephane@zanshine.com',
        ),
      ),
      array(
        'model'         => 'Phonenumber', 
        'name'          => 'stephane-phone', 
        'attributes'    => array(
          'phonenumber'   => '00 33 385 234 567',
          'primary_num'   => false,
        ),
      ),
      array(
        'model'         => 'Group', 
        'name'          => 'admin', 
        'attributes'    => array(
          'name'          => 'administrator',
        ),
      ),
    );
  }
  
  public static function getValidDescriptionsWithRelations()
  {
    return array(
      array(
        'model'         => 'User', 
        'name'          => 'stephane', 
        'attributes'    => array(
          'username'      => 'zanshine',
          'firstname'     => 'stephane',
          'lastname'      => 'richard',
        ),
        'relations' => array(
          'Groups'        => 'admin',
          'Emails'        => 'stephane-mail',
          'Phonenumbers'  => 'stephane-phone',
        ),
      ),
      array(
        'model'         => 'Email', 
        'name'          => 'stephane-mail', 
        'attributes'    => array(
          'address'       => 'stephane@zanshine.com',
        ),
        'relations'     => array(
          'user'          => 'stephane',
        ),
      ),
      array(
        'model'         => 'Phonenumber', 
        'name'          => 'stephane-phone', 
        'attributes'    => array(
          'phonenumber'   => '00 33 385 234 567',
          'primary_num'   => false,
        ),
        'relations'     => array(
          'User'          => 'stephane',
        ),
      ),
      array(
        'model'         => 'Group', 
        'name'          => 'admin', 
        'attributes'    => array(
          'name'          => 'administrator',
        ),
        'relations'     => array(
          'Users'         => 'stephane',
        ),
      ),
    );
  }
  
  
  public static function getValidDescriptionsWithOneRelation()
  {
    return array(
      array(
        'model'         => 'User', 
        'name'          => 'stephane', 
        'attributes'    => array(
          'username'      => 'zanshine',
          'firstname'     => 'stephane',
          'lastname'      => 'richard',
        ),
        'relations' => array(
          'Groups'        => 'admin',
        ),
      ),
      array(
        'model'         => 'Email', 
        'name'          => 'stephane-mail', 
        'attributes'    => array(
          'address'       => 'stephane@zanshine.com',
        ),
        'relations'     => array(
          'user'          => 'stephane',
        ),
      ),
      array(
        'model'         => 'Phonenumber', 
        'name'          => 'stephane-phone', 
        'attributes'    => array(
          'phonenumber'   => '00 33 385 234 567',
          'primary_num'   => false,
        ),
        'relations'     => array(
          'User'          => 'stephane',
        ),
      ),
      array(
        'model'         => 'Group', 
        'name'          => 'admin', 
        'attributes'    => array(
          'name'          => 'administrator',
        ),
        'relations'     => array(
          'Users'         => 'stephane',
        ),
      ),
    );
  }
}