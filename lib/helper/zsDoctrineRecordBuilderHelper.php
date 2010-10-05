<?php

function zs_builder($builder)
{
  zsRecordBuilderContext::getInstance()->addBuilder($builder);
}