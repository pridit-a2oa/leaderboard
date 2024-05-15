<?php

namespace App\SignatureValidator;

use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\Exceptions\InvalidConfig;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;

class KofiSignatureValidator implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        $signingSecret = $config->signingSecret;

        if (empty($signingSecret)) {
            throw InvalidConfig::signingSecretNotSet();
        }

        if (json_validate($request->data) === false) {
            return false;
        }

        $data = json_decode($request->data);

        if (!isset($data->verification_token)) {
            return false;
        }

        return hash_equals(
            $signingSecret,
            $data->verification_token
        );
    }
}
