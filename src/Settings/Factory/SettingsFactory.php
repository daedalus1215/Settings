<?php
namespace Settings\Factory;


use Zend\ServiceManager\FactoryInterface;

use Zend\ServiceManager\ServiceLocatorInterface;

use Iag\Zend\Db\Adapter\AdapterInterface;

use Settings\Service\Settings;

/**
 * Description of SettingsFactory
 *
 * @author ladams
 */
class SettingsFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter   = $serviceLocator->get('Iag\Zend\Db\Adapter');
        $user        = $serviceLocator->get('Iag\Rcm\User\Entity\User');
        $cache       = $serviceLocator->get('Cache\Service\WincacheService');

        return new Settings($dbAdapter, $user, $cache);
    }

}
