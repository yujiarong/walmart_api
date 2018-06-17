<?php
require 'vendor/autoload.php';
use Walmart\Feed;
use Walmart\Price;

class WalmartRequest  
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'own:walmartRequest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'walmart request';
    public $config = [];
    public $proxy = null;
    public $verifySsl = false;
    public $env = Price::ENV_PROD;
    public $debugOutput = false;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->handle();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->config = [
            'max_retries' => 0,
            'http_client_options' => [
                'defaults' => [
                    'proxy' => $this->proxy,
                    'verify' => $this->verifySsl,
                ]
            ],
            'consumerId' => '9aa50a82-f895-49a0-9b80-e56539e3e896',
            'privateKey' => 'MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAMGTmCIdXj7K7DrzlITX8LMzc/EUfzjhJ6doqpjeTjKia4qkRG++lGbe7IZTUM1tqOl+x6fydTwETocRZUmxjtW13wP3p/XkHkNeDWgsUYwXnPYF5dYpobGYisoeMM6wCsCwwF0aoIf74sXmwtyBPI8MjElNryQVMJnpEB0YLeeLAgMBAAECgYBABj0PK398bUlsxhudRH7MBnyWhB0ABxhCeo/SN9TNUoMXO/WWsAYNcDXyx6O2DksLz27h0YOM8i+25L4Hfb6rxVR/59eGoJy9J1ngg7lTL+gZONhdtNJvElDvB6g6UDk7L1sjvdddLf8M8bOBmImXVYpj7KE/zHfWPVJ2/kL0QQJBAOB/kgFcpwmQ+ZaeoMwaX1CxNuD0DcGdCVZq30sStXYHxOqGX/HnfQIo/iamsc0FSQdEaLTpclwudE4NNw0XhcMCQQDcvUBm7INWSLhqtbB+AMQTdcWnBycoeiW413sLiEYBhD4L+Wu9NmKjmjA9MwozlndNrl+XuBVttdIFrHGJt9KZAkAIZx366RHjfMaqyZMxMIeCyK9KKjhdl9gioOtsru2V1mKbeJ4cutJmA0zH+5NKHjmGiRv2MYqzQpXd2gbGeavrAkEAwHQUWWguHiVq/EaKqWEbkufkuvrGjkjo6J6effCDMMFOo3wEDkUDfSZqloEQjOfL/qNgXtQ1gqC6iw3NM8hcSQJBANgwnYfMu0hkO2PGsasKHnafkPD8YMkARsOlNDssYiBpbhVszO8ACOqe8lFBxEPmgfOuWSb1xcb9opizLREzPgM=',
            'wmConsumerChannelType' => '0f3e4dd4-0514-4346-b39d-af0e00ea066d'
        ];
        echo '312312';
        // $this->updatePrice();
        // $this->testBulk();
        // $this->testListItems();
        $this->getFeed();
    }


    // public function Invent(){
    //     $client = new Inventory([
    //         $config = array_merge_recursive($this->config, $extraConfig);
    //     ]);
    //     $inventory = $client->update([
    //         'inventory' => [
    //             'sku' => 'NO11140_7022363',
    //             'quantity' => [
    //                 'unit' => 'EACH',
    //                 'amount' => 5,
    //             ],
    //             'fulfillmentLagTime' => 3,
    //         ],
    //     ]);
    // }


    public function getFeed(){
        $client = new Feed($this->config);

        $feeds = $client->get([
            'feedId' => 'EA67B6F34DAC4644AA53662A6D04F05A@AQkBAQA', // optional
        ]);        
        print_r($feeds);
    }

    public function updatePrice(){
        $client = new Price($this->config);

        $price = $client->update([
            'sku' => 'US01+AMK005724_GR_L:BEDYDS', // required
            'currency' => 'USD', // required
            'price' => '9.01', // required
        ]);
        var_dump($price);
    }



    public function testListItems()
    {
        $client = $this->getItemClient();
        try {
            $items = $client->list(['limit'=>2]);
            print_r($items);
            // $this->assertEquals(200, $items['statusCode']);
            // $this->debug($items);
        } catch (CommandClientException $e) {
            $error = $e->getResponse()->getHeader('X-Error');
            print_r($error);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            print_r($error);
        }
    }


    public function testBulk()
    {
        $client = $this->getClient();
        try {
            $update = $client->bulk([
                'PriceFeed' => [
                    'PriceHeader' => [
                        'version' => '1.5',
                    ],
                    'Price' => [
                        [
                            'itemIdentifier' => [
                                'sku' => 'US01+AMK005724_GR_L:BEDYDS'
                            ],
                            'pricingList' => [
                                'pricing' => [
                                    'currentPrice' => [
                                        'value' => [
                                            'currency' => 'USD',
                                            'amount' => '9.01',
                                        ],
                                    ],
                                ]
                            ],
                        ],
                    ],
                ],
            ]);
            var_dump($update);
            $this->debug($update);
        } catch (CommandClientException $e) {
            $error = $e->getResponse()->getHeader('X-Error');
            print_r($error);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            print_r($error);
        }
    }
    private function getClient($extraConfig = [])
    {
        $config = array_merge_recursive($this->config, $extraConfig);
        return new Price($config, $this->env);
    }

    private function getItemClient($extraConfig = [])
    {
        $config = array_merge_recursive($this->config, $extraConfig);
        return new Item($config, Item::ENV_PROD);
    }

    private function debug($output)
    {
        if ($this->debugOutput) {
            fwrite(STDERR, print_r($output, true));
        }
    }

}


$a  = new  WalmartRequest();

?>