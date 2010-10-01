<?php

final class zsRecordBuilderDescriptionParser
{
  
  private static $instance;
  
  /**
   * @return zsRecordBuilderDescriptionParser
   */
  public static function getInstance()
  {
    return self::$instance ? self::$instance : self::$instance = new self();
  }
  
  private function __construct()
  {
  }
  
  public function parse($description)
  {
    return $this->parseModel((array) $description, (array) $description);
  }
  
  public function parseModel(array $data, array $description)
  {
    if(!isset($description['model']))
      $this->invalidateData($description, 'model');
      
    unset($data['model']);
    return $this->parseName($data, $description);
  }
  
  public function parseName(array $data, array $description)
  {
    if(!isset($description['name']))
      $this->invalidateData($description, 'name');
      
    unset($data['name']);
    return $this->parseAttributes($data, $description);
  }
  
  public function parseAttributes(array $data, array $description)
  {
    if(isset($description['attributes']))
    {
      foreach ($description['attributes'] as $value) 
      {
        if (! (is_string($value) || is_int($value) || is_float($value) || is_bool($value) || is_array($value) || is_callable($value))) 
        {
          $this->invalidateData($description, 'attributes', 
            'Should be either a string, a number, a boolean or an instance of Closure');
        }
      }
      unset($data['attributes']);
    }
    return $this->parseRelations($data, $description);
  }
  
  public function parseRelations(array $data, array $description)
  {
    if(isset($description['relations']))
    {
      foreach ($description['relations'] as $relation => $builders)
      {
      	if(is_array($builders))
      	{
      	  foreach($builders as $builder)
      	  {
      	    $this->validateBuilder($builder, $description);
      	  }
      	}
      	else
      	{
      	  $this->validateBuilder($builders, $description);
      	}
      }
      unset($data['relations']);
    }
    return $this->parseRest($data, $description);
  }
  
  private function validateBuilder($builder, $description)
  {
    if(!(is_string($builder) || is_callable($builder) || $builder instanceof zsRecordBuilder))
    {
      $this->invalidateData($description, 'relations', 
      'The provided builder should be either a string, an instance of zsRecordBuilder or an instance of Closure');
    }
  }
  
  public function parseRest(array $data, array $description)
  {
    if(!empty($data))
    {
      $dump = var_export($data, true);
      $message = "Unparsed data $dump";
      throw new zsRecordBuilderDescriptionParserException($message);
    }
    return $description;
  }
  
  private function invalidateData($description, $component, $explanation = '')
  {
    $dataDump = var_export($data, true);
    $descriptionDump = var_export($description, true);
    
    $message = <<<EOF
Unable to parse the given input for component '$component' with description:
$descriptionDump
$explanation
EOF
    ;
    throw new zsRecordBuilderDescriptionParserException($message);
  }
}