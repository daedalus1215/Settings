<?php
namespace Settings\Entity;

interface SettingInterface
{
    public function getId();

    public function getDescription();

    public function getAuditName();

    public function getAuditTime();

    public function getIsUserControllable();

    public function getValue();

    public function getCategoricalLevels();

    public function setId($id);

    public function setDescription($description);

    public function setAuditName($auditName);

    public function setAuditTime($auditTime);

    public function setIsUserControllable($isUserControllable);

    public function setValue($value);

    public function setCategoricalLevels($categoricalLevels);
}