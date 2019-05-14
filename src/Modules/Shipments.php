<?php

namespace JeroenOnline\ShopsUnitedLaravel\Modules;

use JeroenOnline\ShopsUnitedLaravel\ShopsUnitedLaravel;

class Shipments extends ShopsUnitedLaravel
{
    /**
     * Returns a Array with shipment type objects
     * @return mixed
     */
    public function types()
    {
        $data = $this
            ->addQuery([
                'GebruikerId' => config('shops-united-laravel.account-id'),
                'Datum' => date('Y-m-d H:i:s'),
                'HmacSha256' => hash_hmac('sha256', config('shops-united-laravel.account-id') . date('Y-m-d H:i:s'), config('shops-united-laravel.api-key')),
            ])
            ->setGetUrl('type.php')
            ->call();

        return json_decode(json_encode($data));
    }

    /**
     * Get the 20 nearest locations for the user to use the 'Pakje Gemak' service
     * @param $zipCode
     * @param $houseNumber
     * @param string $carrier default 'PostNL' or 'DHL'
     * @return mixed
     */
    public function locations($zipCode, $houseNumber, $carrier = "PostNL")
    {
        $data = $this
            ->addQuery([
                'GebruikerId' => config('shops-united-laravel.account-id'),
                'Datum' => date('Y-m-d H:i:s'),
                'Carrier' => $carrier,
                'Postcode' => $zipCode,
                'Nummer' => $houseNumber,
                'HmacSha256' => hash_hmac('sha256', config('shops-united-laravel.account-id') . date('Y-m-d H:i:s') . $zipCode . $houseNumber, config('shops-united-laravel.api-key')),
            ])
            ->setGetUrl('uitreiklocatie.php')
            ->call();

        return json_decode(json_encode($data));
    }
}
