<?php

namespace Hichxm\WarGaming;

use Exception;
use GuzzleHttp\Client;

class WargamingWotApi
{
    private $key;
    private $region;

    private $links = [
        'accountSearch' => 'api.worldoftanks.{region}/wot/account/list/?application_id={key}&search={search}&limit={limit}&type={method}',
        'accountId' => 'api.worldoftanks.{region}/wot/account/info/?application_id={key}&account_id={accounts}',
        'accountTank' => 'api.worldoftanks.{region}/wot/account/tanks/?application_id={key}&account_id={accounts}&tank_id={tanks}',
        'accountAchivement' => 'api.worldoftanks.{region}/wot/account/achievements/?application_id={key}&account_id={accounts}',
    ];

    /**
     * WargamingWotApi constructor.
     */
    public function __construct(string $key, string $region)
    {
        $this->setKey($key);
        $this->setRegion($region);
    }

    /**
     * @param string     $search
     * @param array|null $options
     *
     * @return array
     *
     * @throws Exception
     */
    public function searchPlayers($search, $options = null)
    {
        if (0 == strlen($search)) {
            //Search not specified
            throw new Exception('SEARCH_NOT_SPECIFIED', '402');
        } elseif (strlen($search) < 3) {
            //Search no enough
            throw new Exception('NOT_ENOUGH_SEARCH_LENGTH', '407');
        } elseif (strlen($search) >= 100) {
            //Search as exceeded
            throw new Exception('SEARCH_LIST_LIMIT_EXCEEDED', '407');
        }

        $returned = $this->request('accountSearch', [
            'search' => $search,
            'limit' => !empty($options['limit']) ? $options['limit'] : 100,
            'method' => !empty($options['method']) ? $options['method'] : 'startswith',
            'region' => !empty($options['region']) ? $options['region'] : $this->region,
        ]);

        return [
            'count' => $returned['meta']['count'],
            'players' => $returned['data'],
        ];
    }

    /**
     * @param array $accounts_id
     *
     * @return array
     *
     * @throws Exception
     */
    public function infoPlayersById($accounts_id)
    {
        $accounts = null;
        foreach ($accounts_id as $account_id) {
            $accounts .= $account_id.',';
        }

        $returned = $this->request('accountId', [
            'accounts' => $accounts,
            'region' => !empty($options['region']) ? $options['region'] : $this->region,
        ]);

        return [
            'count' => $returned['meta']['count'],
            'players' => $returned['data'],
        ];
    }

    /**
     * @param array      $accounts_id
     * @param array|null $options
     *
     * @return array
     *
     * @throws Exception
     */
    public function playersTank($accounts_id, $options = null)
    {
        $accounts = null;
        foreach ($accounts_id as $account_id) {
            $accounts .= $account_id.',';
        }

        $tanks = null;
        if (!empty($options['tanks'])) {
            foreach ($options['tanks'] as $tank) {
                $tanks .= $tank.',';
            }
        }

        $returned = $this->request('accountTank', [
            'accounts' => $accounts,
            'tanks' => !empty($tanks) ? $tanks : '',
            'region' => !empty($options['region']) ? $options['region'] : $this->region,
        ]);

        return [
            'count' => $returned['meta']['count'],
            'players' => $returned['data'],
        ];
    }

    /**
     * @param array $accounts_id
     *
     * @return array
     *
     * @throws Exception
     */
    public function playerAchievement($accounts_id)
    {
        $accounts = null;
        foreach ($accounts_id as $account_id) {
            $accounts .= $account_id.',';
        }

        $returned = $this->request('accountAchivement', [
            'accounts' => $accounts,
            'region' => !empty($options['region']) ? $options['region'] : $this->region,
        ]);

        return [
            'count' => $returned['meta']['count'],
            'players' => $returned['data'],
        ];
    }

    /**
     * @param string $ref
     * @param array  $options
     *
     * @return mixed
     *
     * @throws Exception
     */
    private function request($ref, $options)
    {
        $link = $this->links[$ref];

        switch ($ref) {
            case 'accountSearch':
                //Replace data of the link
                $link = str_replace('{search}', $options['search'], $link);
                $link = str_replace('{limit}', $options['limit'], $link);
                $link = str_replace('{method}', $options['method'], $link);
                $link = str_replace('{region}', $options['region'], $link);
                break;

            case 'accountId':
                //Replace data of the link
                $link = str_replace('{accounts}', $options['accounts'], $link);
                $link = str_replace('{region}', $options['region'], $link);
                break;

            case 'accountTank':
                //Replace data of the link
                $link = str_replace('{accounts}', $options['accounts'], $link);
                $link = str_replace('{tanks}', $options['tanks'], $link);
                $link = str_replace('{region}', $options['region'], $link);
                break;

            case 'accountAchivement':
                //Replace data of the link
                $link = str_replace('{accounts}', $options['accounts'], $link);
                $link = str_replace('{region}', $options['region'], $link);
                break;
        }

        //Replace data of the link
        $link = str_replace('{region}', $this->region, $link);
        $link = str_replace('{key}', $this->key, $link);

        $client = new Client();
        $res = $client->request('GET', $link);
        $res = json_decode($res->getBody(), true);

        if ('error' === $res['status']) {
            throw new Exception('INVALID_APPLICATION_ID', 407);
        }

        return $res;
    }

    /**
     * @param string $region
     */
    private function setRegion($region): void
    {
        $this->region = $region;
    }

    /**
     * @param string $key
     */
    private function setKey($key): void
    {
        $this->key = $key;
    }
}
