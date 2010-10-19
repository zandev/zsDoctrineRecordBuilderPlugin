<?php

/**
 * Copyright (C) 2010 Stéphane Robert Richard.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. Neither the name of the project nor the names of its contributors
 *    may be used to endorse or promote products derived from this software
 *    without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE PROJECT AND CONTRIBUTORS ``AS IS'' AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED.  IN NO EVENT SHALL THE PROJECT OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
 * OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
 * OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
 * SUCH DAMAGE.
 * 
 */

final class zsRecordBuilder
{

  /**
   * @var zsRecordBuilderDescription
   */
  private $closure;
  
  public function getClosure ()
  {
    return $this->closure;
  }
  
  /**
   * @var zsRecordBuilderContext
   */
  private $context;

  public function getContext ()
  {
    return $this->context;
  }
  
  /**
   * @var string
   */
  private $model;

  public function getModel ()
  {
    return $this->model;
  }
  
  /**
   * @var string
   */
  private $parent;
  
  public function __construct ($options, Closure $closure, zsRecordBuilderContext $context = null)
  {
    if(empty($options))
    {
      throw new InvalidArgumentException('you should provide a valid model');
    }
    if(is_string($options))
    {
      $options = array('model' => $options);
    }
    
    if($parent = @$options['extends']) 
    {
      $this->parent = $parent;
      $this->model = zsRecordBuilderContext::getInstance()->getBuilder($parent)->getModel();
    }
    else 
    {
      $this->model = $options['model'];
    }
    
    $this->closure = $closure;
    $this->context = $context ? $context : zsRecordBuilderContext::getInstance();
  }

  public function build(object $object = null)
  {
    $class = $this->model;
    $model = $object ? $object : new $class();
    
    if($this->parent)
    {
      $builder = zsRecordBuilder::getContext()->getBuilder($this->parent)->getClosure();
      $builder($model);
    }
    
    $builder = $this->closure;
    $builder($model);
    
    return $model;
  }
  
  public function create()
  {
    $record = $this->build();
    $record->save();
    return $record;
  }
  
  public function stub()
  {
    return $this->build(new stdClass());
  }
  
  public function attributes()
  {
    return $this->build()->toArray();
  }
  
  public function __set ($property, $value)
  {
    throw new BadMethodCallException("property $property is not declared");
  }
}
