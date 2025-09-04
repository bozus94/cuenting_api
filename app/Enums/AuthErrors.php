<?php

namespace App\Enums;

enum AuthErrors: string
{
    case AUTH_INVALID_CREDENTIALS = "Credentials provided are invalid";
    case AUTH_TOKEN_INVALID = "Authorization Token is invalid";
    case AUTH_TOKEN_EXPIRED = "Authorization Token is expired";
    case AUTH_EMAIL_TAKEN = "The email is already in use";
    case REGISTER_PROCESSING_OPERATION = "An error occurred while creating the registry";
    case AUTH_TOKEN_NOT_FOUND = "Authorization Token not found";
    case UNAUTHENTICATED = "Denied Access";
}
