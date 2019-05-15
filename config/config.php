<?php

return [
    'account-id' => env('SHOP_UNITED_ACCOUNT_ID'),
    'api-key' => env('SHOP_UNITED_API_KEY'),
    'verify-ssl' => env('SHOPS_UNITED_VERIFY_SSL', App::environment('local') ? false : true), // Defaults verify ssl to false in local environments
];
