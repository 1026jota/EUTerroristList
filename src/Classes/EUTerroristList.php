<?php
namespace Jota\EUTerroristList\Classes;
use Goutte\Client;

class EUTerroristList
{
    /**
     * Name to search
     * @var string $name
     */
    private string $name;

    /**
     * Result to search
     * @var string $name
     */
    private array $result;

    public function initResult() : void
    {
        $this->result['is_registered'] = false;
        $this->result['total_results'] = 0;
        $this->result['result'] = [];
    }

    /**
     * Return a search result in json form
     * @return string
     */
    public function getResult() : string
    {
        return json_encode($this->result);
    }

    /**
     * This function search a name into USA terrorist list
     * @param $name : name to search
     * @return void
     */
    public function searchByName(string $name) : void
    {
        $this->initResult();
        $this->name = strtolower($name);
        
        $client = new Client();
        $crawler = $client->request('GET', config('euterrorist.url'));
        $list = $crawler->filter('[id="L_2021043ES.01000301"]')->first();
        $list->filter('table > tbody > tr > td > span')->each(function($row){
            $split = explode('nacido', strtolower($row->text()));
            $name = $this->makeName($split);
            if(strpos($name, $this->name) !== false){
                $info = [
                    'name' => $this->name,
                ];
                $this->result['total_results'] += 1;
                $this->result['is_registered'] = true;
                array_push($this->result['result'], $info);
            }
        });
    }

    /**
     * This function search all names into USA terrorist list
     * @return void
     */
    public function searchAll(): void
    {
        $this->initResult();

        $client = new Client();
        $crawler = $client->request('GET', config('euterrorist.url'));
        $list = $crawler->filter('[id="L_2021043ES.01000301"]')->first();

        $list->filter('table > tbody > tr > td > span')->each(function ($row) {
            $split = explode('nacido', strtolower($row->text()));
            $name = $this->makeName($split);
                $info = [
                    'name' => $name,
                ];
                $this->result['total_results'] += 1;
                array_push($this->result['result'], $info); 
        });
    }

    /**
     * This function make a name from html
     * @return string
     */
    private function makeName(array $split) : string
    {
        $split[0] = str_replace(',', '', $split[0]);
        $name = explode('(', $split[0]);
        return $name[0];
    }

}
