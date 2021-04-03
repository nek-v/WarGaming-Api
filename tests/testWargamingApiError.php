<?php

use Hichxm\WarGaming\WargamingApi;
use PHPUnit\Framework\TestCase;

class testWargamingApiError extends TestCase
{
    /**
     * @test
     *
     *
     * @throws Exception
     */
    public function checkSearchPlayersWithBadApiKeyButGoodDataOption()
    {
        //Init Wargaming.net api key and region
        $war = new WargamingApi('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', 'eu');

        try {
            $war->searchPlayers('volca7');
        } catch (Exception $e) {
            $this->assertEquals('INVALID_APPLICATION_ID', $e->getMessage());
        }
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function checkSearchPlayersWithGoodApiKeyButBadDataOption()
    {
        //Init Wargaming.net api key and region
        $war = new WargamingApi('e9807cace93606169c54fb8e9ec763b2', 'eu');

        //NOT_ENOUGH_SEARCH_LENGTH
        try {
            $war->searchPlayers('vo');
        } catch (Exception $e) {
            $this->assertEquals('NOT_ENOUGH_SEARCH_LENGTH', $e->getMessage());
        }

        //SEARCH_NOT_SPECIFIED
        try {
            $war->searchPlayers('');
        } catch (Exception $e) {
            $this->assertEquals('SEARCH_NOT_SPECIFIED', $e->getMessage());
        }

        //SEARCH_LIST_LIMIT_EXCEEDED
        try {
            $war->searchPlayers('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
        } catch (Exception $e) {
            $this->assertEquals('SEARCH_LIST_LIMIT_EXCEEDED', $e->getMessage());
        }
    }
}
