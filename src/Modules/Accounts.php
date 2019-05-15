<?php

namespace JeroenOnline\ShopsUnitedLaravel\Modules;

use JeroenOnline\ShopsUnitedLaravel\ShopsUnitedLaravel;

class Accounts extends ShopsUnitedLaravel
{
    /**
     * Check if the API key in the config is valid.
     * @return bool
     */
    public function validate() : bool
    {
        $data = $this
            ->setParams([
                'GebruikerId' => config('shops-united-laravel.account-id'),
                'Datum' => date('Y-m-d H:i:s'),
                'HmacSha256' => hash_hmac('sha256', config('shops-united-laravel.account-id').date('Y-m-d H:i:s'), config('shops-united-laravel.api-key')),
            ])
            ->setPostUrl('validate_apikey.php')
            ->call();

        return array_get($data, 'valid');
    }

    /**
     * Checks whether a account with the given email exists or not.
     * @param string $email
     * @return bool
     */
    public function exists($email = null) : bool
    {
        $data = $this
            ->addQuery([
                'GebruikerId' => config('shops-united-laravel.account-id'),
                'Email' => $email,
                'HmacSha256' => hash_hmac('sha256', config('shops-united-laravel.account-id').$email, config('shops-united-laravel.api-key')),
            ])
            ->setGetUrl('account_exists.php')
            ->call();

        return array_get($data, 'exists');
    }
}
