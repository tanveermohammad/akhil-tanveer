<?php
/**
 *
 * @author    Tanveer Mohammad <tanveer.mohammad@pennywisesolutions.com>
 * @package   Mikimoto\GeoRedirect
 * @since     1.0 First time this was introduced.
 * @copyright 1948-2019 Ogilvy
 *
 * @description This is block checks if popup is enabled
 *
 */
/**
 * check georedirect is enabled or disabled
 */
namespace Mikimoto\GeoRedirect\Block;
/**
 * Class PopupStatus
 */
class PopupStatus extends \Magento\Framework\View\Element\Template
{
    /**
     * @var $helperData
     */
    protected $helperData;
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Mikimoto\GeoRedirect\Helper\Data $helperData
     */
    /**
     * @return void
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Mikimoto\GeoRedirect\Helper\Data $helperData,

        array $data = []
        ) {
             $this->helperData = $helperData;
              parent::__construct($context);
            }
    /**
     * Get popup status from admin config
     *
     * @return string|int
     */
            public function getPopupStatus()
            {
                $popup_enabled = $this->helperData->getGeneralConfig('enable');
                return $popup_enabled;
            }
            public function getPopupDefaultdomain()
            {
                $country_redirect_url_default = $this->helperData->getGeneralConfig('country_redirect_url_default');
                return $country_redirect_url_default;
            }
            public function getDomainWherePopupworks()
            {
                $country_redirect_url_default = $this->helperData->getGeneralConfig('domain_where_popup_works');
                return $country_redirect_url_default;
            }
            
            
}

?>