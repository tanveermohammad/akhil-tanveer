<?php
namespace Mikimoto\GeoRedirect\Model\ResourceModel\Geoip;

/**
 * Resource Model collection
 *
 * @author    Tanveer Mohammad <tanveer.mohammad@pennywisesolutions.com>
 * @package   Mikimoto\GeoRedirect
 * @since     1.0 First time this was introduced.
 * @copyright 1948-2019 Ogilvy
 */

/**
 * Class Collection
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var $_idFieldName
     */
    protected $_idFieldName = 'country_id';
    
    /**
     * @var $_eventPrefix
     */
    protected $_eventPrefix = 'geo_redirect_collection';
    
    /**
     * @var $_eventObject
     */
    protected $_eventObject = 'geoip_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Mikimoto\GeoRedirect\Model\Geoip', 'Mikimoto\GeoRedirect\Model\ResourceModel\Geoip');
    }
}
