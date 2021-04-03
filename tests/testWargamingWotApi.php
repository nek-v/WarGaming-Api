<?php

use Hichxm\WarGaming\WargamingWotApi;
use PHPUnit\Framework\TestCase;

class testWargamingWotApi extends TestCase
{
    /**
     * @test
     */
    public function checkNamespaceWork()
    {
        $wot = new WargamingWotApi('9a423849e1efc6015e45934f4e9b3f57', 'eu');

        $this->assertTrue(true);
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function checkSearchPlayerWorkWithDefaultOptions()
    {
        $wot = new WargamingWotApi('9a423849e1efc6015e45934f4e9b3f57', 'eu');

        $players = $wot->searchPlayers('volca780');

        $this->assertEquals('volca780', $players['players'][0]['nickname']);
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function checkSearchPlayerWorkWithCustomOptions()
    {
        $wot = new WargamingWotApi('9a423849e1efc6015e45934f4e9b3f57', 'ru');

        $players = $wot->searchPlayers('vol', [
            'limit' => 5,
            'region' => 'eu',
            'method' => 'startswith',
        ]);

        $this->assertEquals(5, $players['count']);
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function checkInfoPlayerWorkWithDefaultOptions()
    {
        $wot = new WargamingWotApi('9a423849e1efc6015e45934f4e9b3f57', 'eu');

        $players = $wot->infoPlayersById(['500080014', '514444123']);

        $this->assertEquals('volca780', $players['players']['514444123']['nickname']);
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function checkPlayersVehiculesWithDefaultOption()
    {
        //Init Wargaming.net api key and region
        $wot = new WargamingWotApi('9a423849e1efc6015e45934f4e9b3f57', 'eu');

        $players = $wot->playersTank(['500450795', '503197062', '500435236']);

        $this->assertEquals(3, $players['count']);
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function checkPlayersVehiculesWithCustomOption()
    {
        //Init Wargaming.net api key and region
        $wot = new WargamingWotApi('9a423849e1efc6015e45934f4e9b3f57', 'eu');

        $players = $wot->playersTank(['500450795', '503197062', '500435236'], [
            'tanks' => ['2849', '10785'],
        ]);

        $this->assertEquals(3, $players['count']);
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function checkAchivementPlayerWorkWithDefaultOptions()
    {
        $wot = new WargamingWotApi('9a423849e1efc6015e45934f4e9b3f57', 'eu');

        $players = $wot->playerAchievement(['500080014', '514444123']);

        $this->assertEquals(2, $players['count']);
    }
}
