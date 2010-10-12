<?php

function zs_add_builder($options, Closure $closure)
{
  zsRecordBuilderContext::getInstance()->addBuilder($options, $closure);
}

function zs_get_builder($builder)
{
  return zsRecordBuilderContext::getInstance()->getBuilder($builder);
}