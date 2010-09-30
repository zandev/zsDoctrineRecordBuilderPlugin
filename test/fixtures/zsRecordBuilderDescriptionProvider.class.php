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
          'User'          => 'stephane',
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
  
  
  public static function getValidDescriptionsWithOneToOneRelation()
  {
    return array(
      array(
        'name'          => 'stephane', 
        'model'         => 'Person', 
        'attributes'    => array(
          'firstname'     => 'stephane',
          'lastname'      => 'richard',
        ),
        'relations' => array(
          'Phonenumber'        => 'stephane-phone',
          'FirstFriend'        => 'nicolas',
          'SecondFriend'       => 'alex',
        ),
      ),
      array(
        'name'          => 'bob', 
        'model'         => 'Person', 
        'attributes'    => array(
          'firstname'     => 'bob',
          'lastname'      => 'éponge',
        ),
        'relations' => array(
          'Phonenumber'        => 'bob-phone',
          'FirstFriend'        => 'nicolas',
          'SecondFriend'       => 'alex',
        ),
      ),
      array(
        'name'          => 'nicolas', 
        'model'         => 'Friend', 
        'attributes'    => array(
          'firstname'     => 'nicolas',
          'lastname'      => 'karsozy',
          'is_cool'        => false,
        ),
      ),
      array(
        'name'          => 'alex', 
        'model'         => 'Friend', 
        'attributes'    => array(
          'firstname'     => 'alex',
          'lastname'      => 'cciabotti',
          'is_cool'        => true,
        ),
      ),
      array(
        'name'          => 'stephane-mail', 
        'model'         => 'Email', 
        'attributes'    => array(
          'address'       => 'stephane@zanshine.com',
        ),
        'relations'     => array(
          'Person'          => 'stephane',
        ),
      ),
      array(
        'name'          => 'bob-mail', 
        'model'         => 'Email', 
        'attributes'    => array(
          'address'       => 'bob@live.com',
        ),
        'relations'     => array(
          'Person'          => 'bob',
        ),
      ),
      array(
        'name'          => 'stephane-phone', 
        'model'         => 'Phonenumber', 
        'attributes'    => array(
          'phonenumber'   => '00 33 385 234 567',
          'primary_num'   => false,
        ),
        'relations'     => array(
          'Person'          => 'stephane',
        ),
      ),
      array(
        'name'          => 'bob-phone', 
        'model'         => 'Phonenumber', 
        'attributes'    => array(
          'phonenumber'   => '00 33 385 234 567',
          'primary_num'   => false,
        ),
        'relations'     => array(
          'Person'          => 'bob',
        ),
      ),
    );
  }
  
  public static function getValidDescriptionsForManyRelationWithOneBuilder()
  {
    return array(
      array(
        'name' => 'stephane',
        'model' => 'User',
        'attributes'    => array(
          'firstname'     => 'stephane',
        ),
        'relations' => array(
          'Groups'        => 'admin',
          'Phonenumbers'  => 'stephane-phone',
          'Friends'        => 'alex',
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
      array(
        'model'         => 'Phonenumber', 
        'name'          => 'stephane-phone', 
        'attributes'    => array(
          'phonenumber'   => '00 33 385 234 567',
          'primary_num'   => false,
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
        'name'          => 'alex', 
        'model'         => 'Friend', 
        'attributes'    => array(
          'firstname'     => 'alex',
          'lastname'      => 'cciabotti',
          'is_cool'        => true,
        ),
      ),
    );
  }
}










































