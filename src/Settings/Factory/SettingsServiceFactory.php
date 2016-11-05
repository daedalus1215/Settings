<?php
namespace Settings\Factory;


use Zend\ServiceManager\FactoryInterface;

use Zend\ServiceManager\ServiceLocatorInterface;

use Iag\Zend\Db\Adapter\AdapterInterface;


/**
 * Description of SettingsFactory
 *
 * @author ladams
 */
class SettingsServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter   = $serviceLocator->get('Zend\Db\Adapter');
        $cache       = $serviceLocator->get('Cache\Service\WincacheService');

        return new SettingsService($dbAdapter, $user, $cache);
    }

}
