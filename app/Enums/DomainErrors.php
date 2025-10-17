<?php

namespace App\Enums;

enum DomainErrors: string
{
    case ENTITY_ALREADY_EXIST = "Entity already exist";
    case REGISTER_PROCESSING_OPERATION = "An error occurred while creating the record";
}
