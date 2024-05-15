<?php

namespace App\SignatureValidator;

use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;
use App\Exceptions\InvalidWebhookException;
use Spatie\WebhookClient\Exceptions\InvalidConfig;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;

class KofiSignatureValidator implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        // $signingSecret = $config->signingSecret;

        // if (empty($signingSecret)) {
        //     throw InvalidConfig::signingSecretNotSet();
        // }

        // if (json_validate($request->data) === false) {
        //     throw InvalidWebhookException::invalidJson();
        // }

        // $data = json_decode($request->data);

        // $computedSignature = hash_hmac(
        //     'sha256',
        //     $request->getContent(),
        //     $signingSecret
        // );

        // var_dump($data->verification_token, $computedSignature);

        // die();

        // return hash_equals($data->verification_token, $computedSignature);

        return true;
    }
}
