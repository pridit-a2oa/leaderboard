<?php

return [

    'default' => [

        /*
        |--------------------------------------------------------------------------
        | Image Size
        |--------------------------------------------------------------------------
        |
        | The default size (in pixels) used when no explicit size is provided.
        | Gravatar images are square, so a single pixel value is sufficient.
        |
        */

        'size' => 64,

        /*
        |--------------------------------------------------------------------------
        | Fallback Image
        |--------------------------------------------------------------------------
        |
        | The default image to use when no Gravatar is found. This may be a
        | predefined keyword or a full URL. See Gravatar documentation for
        | available options.
        |
        */

        'fallback' => '',

        /*
        |--------------------------------------------------------------------------
        | Use Secure URLs
        |--------------------------------------------------------------------------
        |
        | Determines whether Gravatar URLs should use HTTPS.
        |
        */

        'secure' => true,

        /*
        |--------------------------------------------------------------------------
        | Maximum Rating
        |--------------------------------------------------------------------------
        |
        | Controls the highest allowed image rating. Gravatar allows users to rate
        | their images to indicate appropriate audience suitability.
        | Options: g, pg, r, x.
        |
        */

        'maximumRating' => 'g',

        /*
        |--------------------------------------------------------------------------
        | Force Default Image
        |--------------------------------------------------------------------------
        |
        | Forces Gravatar to always return the fallback image, even if the user
        | has an existing Gravatar.
        |
        */

        'forceDefault' => false,

        /*
        |--------------------------------------------------------------------------
        | Force File Extension
        |--------------------------------------------------------------------------
        |
        | Appends a file extension to the Gravatar URL if required. This value is
        | optional and may be null.
        |
        */

        'forceExtension' => 'webp',

    ],

];
