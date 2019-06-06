<?php

namespace JeroenBoesten\ShopsUnitedLaravel\Modules;

use Illuminate\Support\Arr;
use JeroenBoesten\ShopsUnitedLaravel\ShopsUnitedLaravel;

class Shipments extends ShopsUnitedLaravel
{
    /**
     * Returns a Array with shipment type objects.
     * @return mixed
     */
    public function types()
    {
        $data = $this
            ->addQuery([
                'GebruikerId' => config('shops-united-laravel.account-id'),
                'Datum' => date('Y-m-d H:i:s'),
                'HmacSha256' => hash_hmac('sha256', config('shops-united-laravel.account-id').date('Y-m-d H:i:s'), config('shops-united-laravel.api-key')),
            ])
            ->setGetUrl('type.php')
            ->call();

        return json_decode(json_encode($data));
    }

    /**
     * Get the 20 nearest locations for the user to use the 'Pakje Gemak' service.
     * @param $zipCode
     * @param $houseNumber
     * @param string $carrier default 'PostNL' or 'DHL'
     * @return mixed
     */
    public function locations($zipCode, $houseNumber, $carrier = 'PostNL')
    {
        $data = $this
            ->addQuery([
                'GebruikerId' => config('shops-united-laravel.account-id'),
                'Datum' => date('Y-m-d H:i:s'),
                'Carrier' => $carrier,
                'Postcode' => $zipCode,
                'Nummer' => $houseNumber,
                'HmacSha256' => hash_hmac('sha256', config('shops-united-laravel.account-id').date('Y-m-d H:i:s').$zipCode.$houseNumber, config('shops-united-laravel.api-key')),
            ])
            ->setGetUrl('uitreiklocatie.php')
            ->call();

        return json_decode(json_encode($data));
    }

    /**
     * Create a new shipment to see the additional optional params visit https://login.shops-united.nl/api/docs.php#zending.
     *
     * @param string $carrier
     * @param string $type
     * @param string $reference
     * @param string $addresseeName
     * @param string $addresseeStreet
     * @param string $addresseeHouseNumber
     * @param string $addresseeZipCode
     * @param string $addresseeCity
     * @param int $packagesAmount
     * @param int $weight
     * @param array $optionalParams
     * @return mixed
     */
    public function create(string $carrier, string $type, string $reference, string $addresseeName, string $addresseeStreet, string $addresseeHouseNumber,
                           string $addresseeZipCode, string $addresseeCity, int $packagesAmount, int $weight, array $optionalParams = [])
    {
        $data = $this
            ->setParams(array_merge([
                'GebruikerId' => config('shops-united-laravel.account-id'),
                'Datum' => date('Y-m-d H:i:s'),
                'Carrier' => $carrier,
                'Type' => $type,
                'Referentie' => $reference,
                'Naam' => $addresseeName,
                'Straat' => $addresseeStreet,
                'Nummer' => $addresseeHouseNumber,
                'Postcode' => $addresseeZipCode,
                'Plaats' => $addresseeCity,
                'AantalPakketten' => $packagesAmount,
                'Gewicht' => $weight,
                'HmacSha256' => hash_hmac('sha256', config('shops-united-laravel.account-id').date('Y-m-d H:i:s').Arr::get($optionalParams, 'PostcodeAfzender', '').$addresseeZipCode, config('shops-united-laravel.api-key')),
            ], $optionalParams))
            ->setPostUrl('zending.php')
            ->call();

        return json_decode(json_encode($data));
    }

    public function list(string $orderBy = 'desc', int $shipmentId = null, string $minDateTime = null, string $maxDateTime = null, string $status = null, int $limit = 50)
    {
        $data = $this
            ->addQuery([
                'GebruikerId' => config('shops-united-laravel.account-id'),
                'Datum' => date('Y-m-d H:i:s'),
                'HmacSha256' => hash_hmac('sha256', config('shops-united-laravel.account-id').date('Y-m-d H:i:s'), config('shops-united-laravel.api-key')),

                'ZendingId' => $shipmentId,
                'MinDatetime' => $minDateTime,
                'MaxDatetime' => $maxDateTime,
                'Status' => $status,
                'Ordering' => $orderBy,
                'Limit' => $limit,
            ])
            ->setGetUrl('zendingen.php')
            ->call();

        return json_decode(json_encode($data));
    }

    public function labelUrl(int $shipmentId, bool $printPdf = false)
    {
        $data = $this
            ->addQuery([
                'GebruikerId' => config('shops-united-laravel.account-id'),
                'ZendingId' => $shipmentId,
                'PrintPdf' => $printPdf,
                'HmacSha256' => hash_hmac('sha256', config('shops-united-laravel.account-id').$shipmentId, config('shops-united-laravel.api-key')),
            ])
            ->setGetUrl('label.php');

        return $data->callableUrl.$data->query;
    }

    public function downloadLabelPdf(int $shipmentId, string $downloadPath = 'storage_dir', string $prefix = 'label_')
    {
        $labelUrl = $this->labelUrl($shipmentId, true);

        $jar = new \GuzzleHttp\Cookie\CookieJar();
        $client = new \GuzzleHttp\Client();
        $response = $client->request(
            'POST',
            $labelUrl,
            ['cookies' => $jar]
        );

        if ($downloadPath === 'storage_dir') {
            $downloadPath = storage_path();
        }

        $filePath = "{$downloadPath}/{$prefix}{$shipmentId}.pdf";

        file_put_contents ($filePath, $response->getBody()->getContents());

        return $filePath;
    }
}
