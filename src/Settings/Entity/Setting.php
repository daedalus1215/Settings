<?php
namespace Settings\Entity;


/**
 * This is just an entity. It represents a row from the database, which that row represents an individual setting.
 *
 * @author ladams
 */
class Setting implements SettingInterface
{

    protected $id;
    protected $description;
    protected $auditName;
    protected $auditTime;
    protected $isUserControllable;
    protected $value;
    protected $categoricalLevels;


    public function getId()
    {
        return $this->id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getAuditName()
    {
        return $this->auditName;
    }

    public function getAuditTime()
    {
        return $this->auditTime;
    }

    public function getIsUserControllable()
    {
        return $this->isUserControllable;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getCategoricalLevels()
    {
        return $this->categoricalLevels;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setAuditName($auditName)
    {
        $this->auditName = $auditName;
        return $this;
    }

    public function setAuditTime($auditTime)
    {
        $this->auditTime = $auditTime;
        return $this;
    }

    public function setIsUserControllable($isUserControllable)
    {
        $this->isUserControllable = $isUserControllable;
        return $this;
    }

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function setCategoricalLevels($categoricalLevels)
    {
        $this->categoricalLevels = $categoricalLevels;
        return $this;
    }

    /**
     *
     * @param array $settingRow: row straight from the database.
     */
    public function __construct($theSettingsRow)
    {
        // Check if was previously saved.
        $key = 'MESSAGE_ROUTER_'.(int) $theSettingsRow['MESSAGE_ID'].'_'.(int) $theSettingsRow['SEQUENCE'];
        



        $settingsLastAuditorName  = $theSettingsRow['AUD_NM'];
        $settingsLastAuditedTime  = $theSettingsRow['AUD_TS'];
        $settingsCategoryLevel    = $theSettingsRow['SEQUENCE'];
        $settingsDescription      = $theSettingsRow['DESCRIPTION'];
        $settingsID               = $theSettingsRow['MESSAGE_ID'];
        $settingsValue            = $theSettingsRow['MESSAGES'];
        $settingsUserControllable = $this->isSettingUserControllable($theSettingsRow['USER_MAINT']);

        $this->setAuditName($settingsLastAuditorName);
        $this->setAuditTime($settingsLastAuditedTime);
        $this->setCategoricalLevels($settingsCategoryLevel);
        $this->setDescription($settingsDescription);
        $this->setId($settingsID);
        $this->setIsUserControllable($settingsUserControllable);
        $this->setValue($settingsValue);
    }


    /**
     * Checking for 'Y', because that column's value falls under 'Y' or 'N'.
     * @param string $userMaintenable: either 'Y' or 'N'.
     * @return boolean
     */
    protected function isSettingUserControllable($userMaintenable)
    {
        if ($userMaintenable === 'Y')  {
            $settingsUserControllable = true;
        } else {
            $settingsUserControllable = false;
        }

        return $settingsUserControllable;
    }
}
