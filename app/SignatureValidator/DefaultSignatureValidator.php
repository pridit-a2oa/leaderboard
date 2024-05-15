<?php

namespace App\SignatureValidator;

use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\Exceptions\InvalidConfig;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;

class DefaultSignatureValidator implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        return true;
    }
}
