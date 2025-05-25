<?php

namespace Dynamik\DbChart\Data\Enums;

enum Relation: string
{
    case HAS_MANY = 'has_many';
    case BELONGS_TO = 'belongs_to';
    case HAS_ONE = 'has_one';
    case BELONGS_TO_MANY = 'belongs_to_many';
    case MANY_TO_MANY = 'many_to_many';
}
