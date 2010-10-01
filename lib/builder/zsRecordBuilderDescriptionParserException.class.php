<?php

class zsRecordBuilderDescriptionParserException extends InvalidArgumentException
{
  public function __construct ($message)
  {
    parent::__construct ($message);
  }
}