<?php
namespace Settings\Service;

// Constructor
use Cache\Service\CacheServiceInterface;

// DB
use Iag\Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql;
use Zend\Db\Adapter\Driver\AbstractConnection;
use Iag\Zend\Db\Sql\Sql as DbSql;
use Zend\Db\Adapter\Driver\ResultInterface;


/**
 * Service class we use to access administrative controlled settings.
 */
class SettingsService implements SettingsServiceInterface
{

    const SOME_SETTING = ['SETTING_ID' => 30, 'CATEGORY_LEVEL' => 10];


    /**
     *
     * @var AdapterInterface
     */
    protected $dbAdapter;
    /**
     *
     * @var Cache\Service\CacheServiceInterface
     */
    protected $cache;
    /**
     * The key for the last cache retrieved object.
     * @var string
     */
    protected $cacheKey;
    /**
     *
     * @var AbstractConnection
     */
    protected $connection;
    /**
     *
     * @var \Iag\Zend\Db\Adapter\Platform\PlatformInterface
     */
    protected $platform;
    /**
     *
     * @var \Iag\Zend\Db\Sql\Sql
     */
    protected $sqlObject;


    /**
     *
     * @param AdapterInterface $dbAdapter
     * @param User $user
     * @param CacheServiceInterface $cache
     */
    public function __construct(AdapterInterface $dbAdapter, $cache)
    {
        // The essential Database Adapter
        $this->dbAdapter = $dbAdapter;
        $this->cache     = $cache;

        // Platform from adapter
        $this->platform   = $dbAdapter->getPlatform();
        // Connection object from driver
        $this->connection = $dbAdapter->getDriver()->getConnection();
        // Make the SqlQuery Object.
        $this->sqlObject  = new DbSql($this->dbAdapter);
    }


    public function getSetting($setting)
    {
        $cachedValue = $this->isSettingCached($setting);

        if ($cachedValue === false) {
            return $this->getSpecificSetting($setting);
        } else {
            return $cachedValue;
        }
    }

    /**
     * Either return false or the value.
     * @param array $setting
     * @return false|var
     */
    protected function isSettingCached($setting)
    {
        $id            = $setting['MESSAGE_ID'];
        $categoryLevel = $setting['SEQUENCE'];

        $this->cacheKey = "settings-$id-$categoryLevel";

        $cacheValue = $this->cache->getCache($this->cacheKey);

        if ($cacheValue === false) {
            return false;
        } else {
            $setting = new \Settings\Entity\Setting($cacheValue);
            return $setting;
        }
    }


    /**
     *
     * @param type $messageSequence: Should have a constant entry in the Settings class.
     * @return \Settings\Entity\Setting: fully populated.
     * @throws \Exception : if there was an issue with finding the Setting. Perhaps check the constant entry for that Setting, make sure the Keys or values are not mistyped, or entry is not in db.
     */
    protected function getSpecificSetting($messageSequence)
    {

        $messageIdFormatParam = $this->platform->formatNamedParameter('MESSAGE_ID');
        $sequenceFormatParam = $this->platform->formatNamedParameter('SEQUENCE');

        $select = new Sql\Select();

        $select->columns(['*']);
        $select->from(['S' => 'PRIMARY.CM_MSG_ROUTER']);
        $select->where
                ->expression("{$this->platform->quoteIdentifier('MESSAGE_ID')} = $messageIdFormatParam",[])
                ->expression("{$this->platform->quoteIdentifier('SEQUENCE')} = $sequenceFormatParam", []);

        $this->connectToDB();

        $stmt = $this->sqlObject->prepareStatementForSqlObject($select);
        $stmt->prepare();

        try {
            $results = $stmt->execute(['MESSAGE_ID' => $messageSequence['MESSAGE_ID'],
                                       'SEQUENCE'   => $messageSequence['SEQUENCE']]);

            if ($results instanceof ResultInterface && $results->isQueryResult()) {
                $row = $results->current();
                if ($row === false) {
                    throw new \Exception('Issue with locating that Setting! - Settings->getSpecificSetting');
                } else {
                    $setting = new \Settings\Entity\Setting($row);
                    $this->cache->setCache($this->cacheKey, $row);
                }
            }
        } catch (Exception $ex) {
            throw new \Exception('Not a valid MESSAGE_ID and SEQUENCE: ' . $ex->getMessage());
        }  finally {
            $this->closeConnectionToDB();
        }

        return $setting;
    }



    protected function connectToDB()
    {
        $this->connection->connect();
    }

    protected function closeConnectionToDB()
    {
        $this->connection->disconnect();
    }
}
