<?php
namespace Settings\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\Mvc\Controller\ControllerManager;

/**
 * Description of SettingFactory
 *
 * @author ladams
 */
class SettingFactory implements FactoryInterface
{
    public function createService(ControllerManager $serviceManager)
    {
        return new \Settings\Entity\Setting();
    }

}
