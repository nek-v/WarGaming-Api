<?php

use Hichxm\WarGaming\WargamingApi;
use PHPUnit\Framework\TestCase;

class testWargamingApi extends TestCase
{
    /**
     * @test
     *
     * @throws Exception
     */
    public function checkSearchPlayersWithDefaultOption()
    {
        //Init Wargaming.net api key and region
        $war = new WargamingApi('9a423849e1efc6015e45934f4e9b3f57', 'eu');

        //Get all players where username start with: volca7
        $players = $war->searchPlayers('volca7')['players'];

        $this->assertEquals('volca780', $players[1]['nickname']);
        $this->assertEquals('wot', $players[1]['games'][0]);
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function checkSearchPlayersWithPersonelOption()
    {
        //Init Wargaming.net api key and region
        $war = new WargamingApi('9a423849e1efc6015e45934f4e9b3f57', 'eu');

        //Get all players where username start with: volca7
        $players = $war->searchPlayers('volca780', [
            'method' => 'exact',
        ])['players'];

        $this->assertEquals('volca780', $players[0]['nickname']);
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function checkSearchPlayerInfoWithDefaultOption()
    {
        //Init Wargaming.net api key and region
        $war = new WargamingApi('9a423849e1efc6015e45934f4e9b3f57', 'eu');

        //Get all players with id: 500080014, 514444123, 514444121
        $players = $war->infoPlayersById(['500080014', '514444123', '514444121']);

        $this->assertEquals('vol', $players['players']['500080014']['nickname']);
        $this->assertEquals('volca780', $players['players']['514444123']['nickname']);
        $this->assertEquals('__Swat_BegBang__', $players['players']['514444121']['nickname']);

        $this->assertEquals(3, $players['count']);
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function checkSearchClansWithDefaultOption()
    {
        //Init Wargaming.net api key and region
        $war = new WargamingApi('9a423849e1efc6015e45934f4e9b3f57', 'eu');

        $clans = $war->searchClans('aze');

        $this->assertEquals(100, $clans['count']);
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function checkSearchClansWithCustomOption()
    {
        //Init Wargaming.net api key and region
        $war = new WargamingApi('9a423849e1efc6015e45934f4e9b3f57', 'eu');

        $clans = $war->searchClans('aze', [
            'limit' => 10,
            'pagination' => 1,
            'region' => 'ru',
        ]);

        $this->assertEquals(10, $clans['count']);
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function checkSearchClansIdWithDefaultOption()
    {
        //Init Wargaming.net api key and region
        $war = new WargamingApi('9a423849e1efc6015e45934f4e9b3f57', 'eu');

        $clans = $war->infoClansById(['500041879', '500034196']);

        $this->assertEquals(2, $clans['count']);
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function checkClansPlayersWithDefaultOption()
    {
        //Init Wargaming.net api key and region
        $war = new WargamingApi('9a423849e1efc6015e45934f4e9b3f57', 'eu');

        $players = $war->playerClans(['500450795', '503197062', '500435236']);

        $this->assertEquals(3, $players['count']);
    }
}
