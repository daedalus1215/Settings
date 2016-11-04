<?php
namespace Settings\Factory;



use Zend\ServiceManager\FactoryInterface;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SettingsFactory
 *
 * @author ladams
 */
class SettingsFactory implements FactoryInterface
{
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        return new \Settings\Service\Settings();
    }
}
