<?php
/**
 * Created by PhpStorm.
 * User: arky
 * Date: 6/30/18
 * Time: 11:07 AM
 */

namespace App\Service;


use Symfony\Component\DomCrawler\Crawler;

class ExchangeRateParser
{

    private $crawler;

    const URL = 'http://cbu.uz/ru/arkhiv-kursov-valyut/xml/';

    public function __construct()
    {
        $this->crawler = new Crawler($this->getXML());

    }

    public function getXML()
    {
        return file_get_contents(self::URL);
    }

    public function getCurrency()
    {
        return $this->crawler->filter('');
    }

    public function getUSD()
    {
        return $this->crawler->filter('CBU_Curr > CcyNtry[ID="840"] > Rate')->text();
    }

    public function getEUR()
    {
        return $this->crawler->filter('CBU_Curr > CcyNtry[ID="978"] > Rate')->text();
    }

    public function getRUB()
    {
        return $this->crawler->filter('CBU_Curr > CcyNtry[ID="643"] > Rate')->text();
    }

    public function getGBP()
    {
        return $this->crawler->filter('CBU_Curr > CcyNtry[ID="826"] > Rate')->text();
    }

    public function getKZT()
    {
        return $this->crawler->filter('CBU_Curr > CcyNtry[ID="398"] > Rate')->text();
    }

    public function getCNY()
    {
        return $this->crawler->filter('CBU_Curr > CcyNtry[ID="156"] > Rate')->text();
    }

}