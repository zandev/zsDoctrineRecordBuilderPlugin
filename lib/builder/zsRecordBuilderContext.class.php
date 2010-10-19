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

final class zsRecordBuilderContext
{
  
  private static $defaultInstance;
  
  /**
   * @return zsRecordBuilderContext
   */
  public static function getInstance()
  {
    return self::$defaultInstance ? self::$defaultInstance : new self();
  }
  
  public function __construct()
  {
    if(!self::$defaultInstance) {
    	self::$defaultInstance = $this;
    }
  }
  
  public function addBuilder($options, Closure $closure)
  {
    if(is_string($options))
    {
      $options = array('model' => $options, 'name' => $options);
    }
    if(!is_array($options))
    {
      throw new InvalidArgumentException('addClosureBuilder() expect first parameter to be either a string or a hash');
    }
    if(!@$options['name'])
    {
      throw new InvalidArgumentException('addClosureBuilder() options parameter expect at least a name');
    }
    if(!@$options['model'] && !@$options['extends'])
    {
      $options['model'] = $options['name'];
    }
    
    $name = $options['name'];
    unset($options['name']);
    
    $builder = new zsRecordBuilder($options, $closure);
    $this->builders[$name] = $builder;
    
    return $builder;
  }

  /**
   * 
   * @var array
   */
  private $builders = array();

  /**
   * @return array the $__builders
   */
  public function getBuilders ()
  {
    return $this->builders;
  }
  
  /**
   * 
   * @param string $name
   * @return zsRecordBuilder
   */
  public function getBuilder ($name)
  {
    if (empty($name)) {
      throw new InvalidArgumentException('Argument $name is empty');
    }
    
    if ($b = @$this->builders[$name]) {
      return $b;
    }
  }
  
  public function cleanBuilders()
  {
    $this->builders = array();
  }
  
  public static function cleanInstances()
  {
    self::$defaultInstance = null;
  }

  public function __set ($property, $value)
  {
    throw new BadMethodCallException("property $property is not declared");
  }
}
