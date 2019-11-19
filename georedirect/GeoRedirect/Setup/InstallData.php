<?php
namespace Mikimoto\GeoRedirect\Setup;

/**
 * Model
 *
 * @author    Tanveer Mohammad <tanveer.mohammad@pennywisesolutions.com>
 * @package   Mikimoto\GeoRedirect
 * @since     1.0 First time this was introduced.
 * @copyright 1948-2019 Ogilvy
 */
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\InstallDataInterface;
class InstallData implements InstallDataInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        
        /**
         * connecting database to install data in to the table "geo_Redirect"
         */
        $setup->startSetup();
        $setup->getConnection()->insert(
            $setup->getTable('geo_redirect'),['country_id'=>'1','country_code'=>'JP','country_destination_url'=>'https://mcstaging.mikimoto.com/jp_jp']);
        $setup->getConnection()->insert(
            $setup->getTable('geo_redirect'),['country_id'=>'2','country_code'=>'US','country_destination_url'=>'https://mcstaging.mikimoto.com/us_english']);
        $setup->getConnection()->insert(
            $setup->getTable('geo_redirect'),['country_id'=>'3','country_code'=>'FR','country_destination_url'=>'https://mcstaging.mikimoto.com/france_french']);
        $setup->getConnection()->insert(
            $setup->getTable('geo_redirect'),['country_id'=>'4','country_code'=>'UK','country_destination_url'=>'https://mcstaging.mikimoto.com/uk_english']);
        $setup->getConnection()->insert(
            $setup->getTable('geo_redirect'),['country_id'=>'5','country_code'=>'UK','country_destination_url'=>'https://mcstaging.mikimoto.com/thailand_thai']);
        $setup->getConnection()->insert(
            $setup->getTable('geo_redirect'),['country_id'=>'6','country_code'=>'TW','country_destination_url'=>'https://mcstaging.mikimoto.com/taiwan_chinese_traditional']);
        $setup->getConnection()->insert(
            $setup->getTable('geo_redirect'),['country_id'=>'7','country_code'=>'HK','country_destination_url'=>'https://mcstaging.mikimoto.com/hongkong_chinese_traditional']);
        $setup->getConnection()->insert(
            $setup->getTable('geo_redirect'),['country_id'=>'8','country_code'=>'IN','country_destination_url'=>'https://mcstaging.mikimoto.com/singapore_english']);
        $setup->getConnection()->insert(
            $setup->getTable('geo_redirect'),['country_id'=>'9','country_code'=>'GB','country_destination_url'=>'https://mcstaging.mikimoto.com/uk_english']);
        $setup->endSetup();
    }
}