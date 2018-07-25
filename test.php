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
            'consumerId' => '',
            'privateKey' => '',
            'wmConsumerChannelType' => ''
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