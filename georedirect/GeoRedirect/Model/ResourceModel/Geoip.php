<?php
namespace Mikimoto\GeoRedirect\Model\ResourceModel;

/**
 * Resource Model
 *
 * @author    Tanveer Mohammad <tanveer.mohammad@pennywisesolutions.com>
 * @package   Mikimoto\GeoRedirect
 * @since     1.0 First time this was introduced.
 * @copyright 1948-2019 Ogilvy
 */

/**
 * Class Geoip
 */
class Geoip extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }
    
    protected function _construct()
    {
        $this->_init('geo_redirect', 'country_id');
    }
}
