<?php
namespace Mikimoto\GeoRedirect\Model;

/**
 * Model
 *
 * @author    Tanveer Mohammad <tanveer.mohammad@pennywisesolutions.com>
 * @package   Mikimoto\GeoRedirect
 * @since     1.0 First time this was introduced.
 * @copyright 1948-2019 Ogilvy
 */

/**
 * Class Geoip
 */
class Geoip extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    /**
     * @var CACHE_TAG
     */
    const CACHE_TAG = 'geo_redirect';

    /**
     * @var $_cacheTag
     */
    protected $_cacheTag = 'geo_redirect';

    /**
     * @var $_eventPrefix
     */
    protected $_eventPrefix = 'geo_redirect';

    /**
     * Define model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Mikimoto\GeoRedirect\Model\ResourceModel\Geoip');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
