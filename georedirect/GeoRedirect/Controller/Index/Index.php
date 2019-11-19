<?php
namespace Mikimoto\GeoRedirect\Controller\Index;
/**
 *
 * @author    Tanveer Mohammad <tanveer.mohammad@pennywisesolutions.com>
 * @package   Mikimoto\GeoRedirect
 * @since     1.0 First time this was introduced.
 * @copyright 1948-2019 Ogilvy
 *
 * @description This is a webservice for popup to fetch country code and forward redirection urls
 *
 * For the popup to work an ajax call is made from view/frontend/web/js/popup.js
 * then this service make a request to docodoco api to retreive country code and matches with database to
 * get the destination url. this service sends reponse if it finds a matching record
 */
 /**
 * @constants
 */
//define("url_part_1", "https://api.docodoco.jp/v5/search?key1=VcPuTPaqASGmksrG4wn11pfZckRMIco8KJzcodFqKf9M4lp");
//define("url_part_2", "X37dlN5DeMW6yAf97&key2=29f8f416d40b201bd4ca0a0e29ba7315827ebebe&format=json&ipadr=");
//define("popup_continue_message1", "Shopping from ");
define("popup_continue_message2", "  ?");
//define("country_redirect_url_default", "https://mcstaging.mikimoto.com/jp_jp");
//define("country_not_available", " Sorry We are Not available in your country ");
/**
 * Class Index
 */
class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var $_pageFactory
     */
    protected $_pageFactory;
    /**
     * @var $_geoipFactory
     */
    protected $_geoipFactory;
    /**
     * @var $remoteAddress
     */
    private $remoteAddress;
    /**
     * @var $zendClient
     */
    protected $zendClient;
    /**
     * @var $objectmanager
     */
    protected $objectmanager;
    /**
     * @var $helperData
     */
    protected $helperData;
    /**
     * @param \Magento\Framework\App\Action\Context                $context
     * @param \Magento\Framework\View\Result\PageFactory           $pageFactory
     * @param \Mikimoto\GeoRedirect\Model\GeoipFactory             $geoipFactory
     * @param \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress
     * @param \Zend\Http\Client                                    $zendClient
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Mikimoto\GeoRedirect\Model\GeoipFactory $geoipFactory,
        \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress,
        \Zend\Http\Client $zendClient,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Mikimoto\GeoRedirect\Helper\Data $helperData
    ) {
        $this->_pageFactory = $pageFactory;
        $this->_geoipFactory = $geoipFactory;
            $this->remoteAddress = $remoteAddress;
            $this->zendClient = $zendClient;
            $this->storeManager = $storeManager;
            $this->helperData = $helperData;
           return parent::__construct($context);
    }
    /**
     * @inheritdoc
     */
    public function execute()
    {
        /**
 * getting the ip from ajax request
         * if there ip is null RemoteAddress is taken or else the ip passed in url
         */
        $popup_enabled = $this->helperData->getGeneralConfig('enable');
        $country_redirect_url_default = $this->helperData->getGeneralConfig('country_redirect_url_default');
        $country_redirect_name =  $this->helperData->getGeneralConfig('country_redirect_name');
        $country_not_available =  $this->helperData->getGeneralConfig('message_if_not_available');
        $message_if_available = $this->helperData->getGeneralConfig('message_if_available');
        $api_url = $this->helperData->getGeneralConfig('api_url');
        $api_key1 = $this->helperData->getGeneralConfig('API1');
        $api_key2 = $this->helperData->getGeneralConfig('API2');
        $api_format = $this->helperData->getGeneralConfig('api_format');
        $api_ipadr = $this->helperData->getGeneralConfig('api_ipadr');
        $build_url = $api_url."key1=".$api_key1."&key2=".$api_key2."&format=".$api_format."&ipadr=".$api_ipadr;
        $welcome_message = $this->helperData->getGeneralConfig('welcome_message');
        $continue_btn = $this->helperData->getGeneralConfig('continue_btn');
        $stay_button = $this->helperData->getGeneralConfig('stay_button');
        $domain_where_popup_works = $this->helperData->getGeneralConfig('domain_where_popup_works');
        $arrayfor_countryname = array("https://mcstaging.mikimoto.com/jp_jp"=>"Japan",
        "https://mcstaging.mikimoto.com/us_english"=>"United States",
        "https://mcstaging.mikimoto.com/france_french"=>"France",
        "https://mcstaging.mikimoto.com/uk_english"=>"United Kingdom",
        "https://mcstaging.mikimoto.com/thailand_thai"=>"Thailand",
        "https://mcstaging.mikimoto.com/taiwan_chinese_traditional"=>"Taiwan",
        "https://mcstaging.mikimoto.com/hongkong_chinese_traditional"=>"Hong Kong",
        "https://mcstaging.mikimoto.com/singapore_english"=>"Singapore",
        "https://mcstaging.mikimoto.com/uk_english"=>"United Kingdowm"
        );
        if (isset($_GET['ip']) && !empty($_GET['ip'])) {
            $ajaxip = $_GET['ip'];
            $ip = $ajaxip;
        } else {
            $ip = $this->remoteAddress->getRemoteAddress();
            $ajaxip = $ip;
        }
        try {
            $client = new \Zend_Http_Client();
            $apiurl = $build_url.$ip;
            /**
             * makes a api request call to get country code
             */
            $client->setUri($apiurl);
            $client->setConfig(['maxredirects' => 0, 'timeout' => 30]);
            $response = $client->request();
            $responseBody = $response->getBody();
            $json = json_decode($responseBody);
            $country_code = $json->CountryCode;
            $country_name = $json->CountryAName;
            $country_ip = $json->IP;
            $geoip = $this->_geoipFactory->create();
            $collection = $geoip->getCollection()->addFieldToFilter('country_code', $country_code);
            $collection_count = count($collection);
            $baseUrl = $this->storeManager->getStore()->getBaseUrl();
            /**
            * Check if query executed and returned data.
            */
           if ($collection_count >= 1) {
               foreach ($collection as $item) {
                    $destinationurl = $item->getData('country_destination_url');
                    if(array_key_exists ($destinationurl,$arrayfor_countryname))
                    {
                        $country_button_name = $arrayfor_countryname[$destinationurl];
                    }
                        else 
                        {
                            $country_button_name = $country_name;
                        }
                        
                        $popup_message = $message_if_available.$country_name.popup_continue_message2;
                    $popupResponse = ['popup_status'=> 'yes','country_redirect_url' =>$destinationurl,
                    'country_name'=>$country_name,'country_code'=>$country_code,'country_ip'=>$country_ip,
                        'popup_message'=>$popup_message,'ajax_ip'=>$ajaxip, 'check_country'=>"true",'baseurl'=>$baseUrl,'country_button_name'=>$country_button_name,
                        'welcome_message'=>$welcome_message,'domain_where_popup_works'=>$domain_where_popup_works,
                        'continue_button'=>$continue_btn,'stay_button'=>$stay_button,'popup_enabled'=>$popup_enabled,'country_redirect_name'=>$country_redirect_name
                    ];
                    $popupResponseJSON = json_encode($popupResponse);
                    return $this->getResponse()->setBody($popupResponseJSON);
                }
            }
            if ($collection_count === 0) {
                $popupResponse = ['popup_status'=> 'no','country_redirect_url' =>$country_redirect_url_default,
                              'country_name'=>"Japan",'country_code'=>"na",'country_ip'=>"na",
                    'popup_message'=>$message_if_available.$country_name.popup_continue_message2.$country_not_available,'ajax_ip'=>$ajaxip,'baseurl'=>$baseUrl,'country_button_name'=>"nocountry",
                    'check_country'=>"false","fail_countryname"=>$country_name,'welcome_message'=>$welcome_message,'domain_where_popup_works'=>$domain_where_popup_works,
                    'continue_button'=>$continue_btn,'stay_button'=>$stay_button,'popup_enabled'=>$popup_enabled,'country_redirect_name'=>$country_redirect_name
                              ];
                              $popupResponseJSON = json_encode($popupResponse);
                              return $this->getResponse()->setBody($popupResponseJSON);
            }
        } catch (\Zend\Http\Exception\RuntimeException $runtimeException) {
                return  $runtimeException->getMessage();
        }
                    return $this->_pageFactory->create();
    }
}