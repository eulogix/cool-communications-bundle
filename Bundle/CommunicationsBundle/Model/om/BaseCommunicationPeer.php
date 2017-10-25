<?php

namespace Eulogix\Cool\Bundle\CommunicationsBundle\Model\om;

use \BasePeer;
use \Criteria;
use \Exception;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Eulogix\Cool\Bundle\CommunicationsBundle\Model\Communication;
use Eulogix\Cool\Bundle\CommunicationsBundle\Model\CommunicationPeer;
use Eulogix\Cool\Bundle\CommunicationsBundle\Model\map\CommunicationTableMap;
use Eulogix\Cool\Bundle\CoreBundle\Model\Core\AccountPeer;

abstract class BaseCommunicationPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'cool_db';

    /** the table name for this class */
    const TABLE_NAME = 'communication';

    /** the related Propel class for this table */
    const OM_CLASS = 'Eulogix\\Cool\\Bundle\\CommunicationsBundle\\Model\\Communication';

    /** the related TableMap class for this table */
    const TM_CLASS = 'Eulogix\\Cool\\Bundle\\CommunicationsBundle\\Model\\map\\CommunicationTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 16;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 16;

    /** the column name for the communication_id field */
    const COMMUNICATION_ID = 'communication.communication_id';

    /** the column name for the category field */
    const CATEGORY = 'communication.category';

    /** the column name for the type field */
    const TYPE = 'communication.type';

    /** the column name for the subject field */
    const SUBJECT = 'communication.subject';

    /** the column name for the body field */
    const BODY = 'communication.body';

    /** the column name for the sent_date field */
    const SENT_DATE = 'communication.sent_date';

    /** the column name for the received_date field */
    const RECEIVED_DATE = 'communication.received_date';

    /** the column name for the transmission_method field */
    const TRANSMISSION_METHOD = 'communication.transmission_method';

    /** the column name for the target field */
    const TARGET = 'communication.target';

    /** the column name for the inbound_flag field */
    const INBOUND_FLAG = 'communication.inbound_flag';

    /** the column name for the ext field */
    const EXT = 'communication.ext';

    /** the column name for the creation_date field */
    const CREATION_DATE = 'communication.creation_date';

    /** the column name for the update_date field */
    const UPDATE_DATE = 'communication.update_date';

    /** the column name for the creation_user_id field */
    const CREATION_USER_ID = 'communication.creation_user_id';

    /** the column name for the update_user_id field */
    const UPDATE_USER_ID = 'communication.update_user_id';

    /** the column name for the record_version field */
    const RECORD_VERSION = 'communication.record_version';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of Communication objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Communication[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. CommunicationPeer::$fieldNames[CommunicationPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('CommunicationId', 'Category', 'Type', 'Subject', 'Body', 'SentDate', 'ReceivedDate', 'TransmissionMethod', 'Target', 'InboundFlag', 'Ext', 'CreationDate', 'UpdateDate', 'CreationUserId', 'UpdateUserId', 'RecordVersion', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('communicationId', 'category', 'type', 'subject', 'body', 'sentDate', 'receivedDate', 'transmissionMethod', 'target', 'inboundFlag', 'ext', 'creationDate', 'updateDate', 'creationUserId', 'updateUserId', 'recordVersion', ),
        BasePeer::TYPE_COLNAME => array (CommunicationPeer::COMMUNICATION_ID, CommunicationPeer::CATEGORY, CommunicationPeer::TYPE, CommunicationPeer::SUBJECT, CommunicationPeer::BODY, CommunicationPeer::SENT_DATE, CommunicationPeer::RECEIVED_DATE, CommunicationPeer::TRANSMISSION_METHOD, CommunicationPeer::TARGET, CommunicationPeer::INBOUND_FLAG, CommunicationPeer::EXT, CommunicationPeer::CREATION_DATE, CommunicationPeer::UPDATE_DATE, CommunicationPeer::CREATION_USER_ID, CommunicationPeer::UPDATE_USER_ID, CommunicationPeer::RECORD_VERSION, ),
        BasePeer::TYPE_RAW_COLNAME => array ('COMMUNICATION_ID', 'CATEGORY', 'TYPE', 'SUBJECT', 'BODY', 'SENT_DATE', 'RECEIVED_DATE', 'TRANSMISSION_METHOD', 'TARGET', 'INBOUND_FLAG', 'EXT', 'CREATION_DATE', 'UPDATE_DATE', 'CREATION_USER_ID', 'UPDATE_USER_ID', 'RECORD_VERSION', ),
        BasePeer::TYPE_FIELDNAME => array ('communication_id', 'category', 'type', 'subject', 'body', 'sent_date', 'received_date', 'transmission_method', 'target', 'inbound_flag', 'ext', 'creation_date', 'update_date', 'creation_user_id', 'update_user_id', 'record_version', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. CommunicationPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('CommunicationId' => 0, 'Category' => 1, 'Type' => 2, 'Subject' => 3, 'Body' => 4, 'SentDate' => 5, 'ReceivedDate' => 6, 'TransmissionMethod' => 7, 'Target' => 8, 'InboundFlag' => 9, 'Ext' => 10, 'CreationDate' => 11, 'UpdateDate' => 12, 'CreationUserId' => 13, 'UpdateUserId' => 14, 'RecordVersion' => 15, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('communicationId' => 0, 'category' => 1, 'type' => 2, 'subject' => 3, 'body' => 4, 'sentDate' => 5, 'receivedDate' => 6, 'transmissionMethod' => 7, 'target' => 8, 'inboundFlag' => 9, 'ext' => 10, 'creationDate' => 11, 'updateDate' => 12, 'creationUserId' => 13, 'updateUserId' => 14, 'recordVersion' => 15, ),
        BasePeer::TYPE_COLNAME => array (CommunicationPeer::COMMUNICATION_ID => 0, CommunicationPeer::CATEGORY => 1, CommunicationPeer::TYPE => 2, CommunicationPeer::SUBJECT => 3, CommunicationPeer::BODY => 4, CommunicationPeer::SENT_DATE => 5, CommunicationPeer::RECEIVED_DATE => 6, CommunicationPeer::TRANSMISSION_METHOD => 7, CommunicationPeer::TARGET => 8, CommunicationPeer::INBOUND_FLAG => 9, CommunicationPeer::EXT => 10, CommunicationPeer::CREATION_DATE => 11, CommunicationPeer::UPDATE_DATE => 12, CommunicationPeer::CREATION_USER_ID => 13, CommunicationPeer::UPDATE_USER_ID => 14, CommunicationPeer::RECORD_VERSION => 15, ),
        BasePeer::TYPE_RAW_COLNAME => array ('COMMUNICATION_ID' => 0, 'CATEGORY' => 1, 'TYPE' => 2, 'SUBJECT' => 3, 'BODY' => 4, 'SENT_DATE' => 5, 'RECEIVED_DATE' => 6, 'TRANSMISSION_METHOD' => 7, 'TARGET' => 8, 'INBOUND_FLAG' => 9, 'EXT' => 10, 'CREATION_DATE' => 11, 'UPDATE_DATE' => 12, 'CREATION_USER_ID' => 13, 'UPDATE_USER_ID' => 14, 'RECORD_VERSION' => 15, ),
        BasePeer::TYPE_FIELDNAME => array ('communication_id' => 0, 'category' => 1, 'type' => 2, 'subject' => 3, 'body' => 4, 'sent_date' => 5, 'received_date' => 6, 'transmission_method' => 7, 'target' => 8, 'inbound_flag' => 9, 'ext' => 10, 'creation_date' => 11, 'update_date' => 12, 'creation_user_id' => 13, 'update_user_id' => 14, 'record_version' => 15, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
    );

    /**
     * Translates a fieldname to another type
     *
     * @param      string $name field name
     * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @param      string $toType   One of the class type constants
     * @return string          translated name of the field.
     * @throws PropelException - if the specified name could not be found in the fieldname mappings.
     */
    public static function translateFieldName($name, $fromType, $toType)
    {
        $toNames = CommunicationPeer::getFieldNames($toType);
        $key = isset(CommunicationPeer::$fieldKeys[$fromType][$name]) ? CommunicationPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(CommunicationPeer::$fieldKeys[$fromType], true));
        }

        return $toNames[$key];
    }

    /**
     * Returns an array of field names.
     *
     * @param      string $type The type of fieldnames to return:
     *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @return array           A list of field names
     * @throws PropelException - if the type is not valid.
     */
    public static function getFieldNames($type = BasePeer::TYPE_PHPNAME)
    {
        if (!array_key_exists($type, CommunicationPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return CommunicationPeer::$fieldNames[$type];
    }

    /**
     * Convenience method which changes table.column to alias.column.
     *
     * Using this method you can maintain SQL abstraction while using column aliases.
     * <code>
     *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
     *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
     * </code>
     * @param      string $alias The alias for the current table.
     * @param      string $column The column name for current table. (i.e. CommunicationPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(CommunicationPeer::TABLE_NAME.'.', $alias.'.', $column);
    }

    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param      Criteria $criteria object containing the columns to add.
     * @param      string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(CommunicationPeer::COMMUNICATION_ID);
            $criteria->addSelectColumn(CommunicationPeer::CATEGORY);
            $criteria->addSelectColumn(CommunicationPeer::TYPE);
            $criteria->addSelectColumn(CommunicationPeer::SUBJECT);
            $criteria->addSelectColumn(CommunicationPeer::BODY);
            $criteria->addSelectColumn(CommunicationPeer::SENT_DATE);
            $criteria->addSelectColumn(CommunicationPeer::RECEIVED_DATE);
            $criteria->addSelectColumn(CommunicationPeer::TRANSMISSION_METHOD);
            $criteria->addSelectColumn(CommunicationPeer::TARGET);
            $criteria->addSelectColumn(CommunicationPeer::INBOUND_FLAG);
            $criteria->addSelectColumn(CommunicationPeer::EXT);
            $criteria->addSelectColumn(CommunicationPeer::CREATION_DATE);
            $criteria->addSelectColumn(CommunicationPeer::UPDATE_DATE);
            $criteria->addSelectColumn(CommunicationPeer::CREATION_USER_ID);
            $criteria->addSelectColumn(CommunicationPeer::UPDATE_USER_ID);
            $criteria->addSelectColumn(CommunicationPeer::RECORD_VERSION);
        } else {
            $criteria->addSelectColumn($alias . '.communication_id');
            $criteria->addSelectColumn($alias . '.category');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.subject');
            $criteria->addSelectColumn($alias . '.body');
            $criteria->addSelectColumn($alias . '.sent_date');
            $criteria->addSelectColumn($alias . '.received_date');
            $criteria->addSelectColumn($alias . '.transmission_method');
            $criteria->addSelectColumn($alias . '.target');
            $criteria->addSelectColumn($alias . '.inbound_flag');
            $criteria->addSelectColumn($alias . '.ext');
            $criteria->addSelectColumn($alias . '.creation_date');
            $criteria->addSelectColumn($alias . '.update_date');
            $criteria->addSelectColumn($alias . '.creation_user_id');
            $criteria->addSelectColumn($alias . '.update_user_id');
            $criteria->addSelectColumn($alias . '.record_version');
        }
    }

    /**
     * Returns the number of rows matching criteria.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @return int Number of matching rows.
     */
    public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
    {
        // we may modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CommunicationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CommunicationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(CommunicationPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(CommunicationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        // BasePeer returns a PDOStatement
        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }
    /**
     * Selects one object from the DB.
     *
     * @param      Criteria $criteria object used to create the SELECT statement.
     * @param      PropelPDO $con
     * @return Communication
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = CommunicationPeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }
    /**
     * Selects several row from the DB.
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con
     * @return array           Array of selected Objects
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return CommunicationPeer::populateObjects(CommunicationPeer::doSelectStmt($criteria, $con));
    }
    /**
     * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
     *
     * Use this method directly if you want to work with an executed statement directly (for example
     * to perform your own object hydration).
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con The connection to use
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return PDOStatement The executed PDOStatement object.
     * @see        BasePeer::doSelect()
     */
    public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CommunicationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            CommunicationPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(CommunicationPeer::DATABASE_NAME);

        // BasePeer returns a PDOStatement
        return BasePeer::doSelect($criteria, $con);
    }
    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doSelect*()
     * methods in your stub classes -- you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by doSelect*()
     * and retrieveByPK*() calls.
     *
     * @param Communication $obj A Communication object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getCommunicationId();
            } // if key === null
            CommunicationPeer::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param      mixed $value A Communication object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Communication) {
                $key = (string) $value->getCommunicationId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Communication object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(CommunicationPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return Communication Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(CommunicationPeer::$instances[$key])) {
                return CommunicationPeer::$instances[$key];
            }
        }

        return null; // just to be explicit
    }

    /**
     * Clear the instance pool.
     *
     * @return void
     */
    public static function clearInstancePool($and_clear_all_references = false)
    {
      if ($and_clear_all_references) {
        foreach (CommunicationPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        CommunicationPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to communication
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return string A string version of PK or null if the components of primary key in result array are all null.
     */
    public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
    {
        // If the PK cannot be derived from the row, return null.
        if ($row[$startcol] === null) {
            return null;
        }

        return (string) $row[$startcol];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $startcol = 0)
    {

        return (int) $row[$startcol];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function populateObjects(PDOStatement $stmt)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = CommunicationPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = CommunicationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = CommunicationPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CommunicationPeer::addInstanceToPool($obj, $key);
            } // if key exists
        }
        $stmt->closeCursor();

        return $results;
    }
    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return array (Communication object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = CommunicationPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = CommunicationPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + CommunicationPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CommunicationPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            CommunicationPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }


    /**
     * Returns the number of rows matching criteria, joining the related AccountRelatedByCreationUserId table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAccountRelatedByCreationUserId(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CommunicationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CommunicationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(CommunicationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CommunicationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CommunicationPeer::CREATION_USER_ID, AccountPeer::ACCOUNT_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related AccountRelatedByUpdateUserId table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAccountRelatedByUpdateUserId(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CommunicationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CommunicationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(CommunicationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CommunicationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CommunicationPeer::UPDATE_USER_ID, AccountPeer::ACCOUNT_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of Communication objects pre-filled with their Account objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Communication objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAccountRelatedByCreationUserId(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CommunicationPeer::DATABASE_NAME);
        }

        CommunicationPeer::addSelectColumns($criteria);
        $startcol = CommunicationPeer::NUM_HYDRATE_COLUMNS;
        AccountPeer::addSelectColumns($criteria);

        $criteria->addJoin(CommunicationPeer::CREATION_USER_ID, AccountPeer::ACCOUNT_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CommunicationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CommunicationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = CommunicationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CommunicationPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = AccountPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = AccountPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AccountPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    AccountPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Communication) to $obj2 (Account)
                $obj2->addCommunicationRelatedByCreationUserId($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Communication objects pre-filled with their Account objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Communication objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAccountRelatedByUpdateUserId(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CommunicationPeer::DATABASE_NAME);
        }

        CommunicationPeer::addSelectColumns($criteria);
        $startcol = CommunicationPeer::NUM_HYDRATE_COLUMNS;
        AccountPeer::addSelectColumns($criteria);

        $criteria->addJoin(CommunicationPeer::UPDATE_USER_ID, AccountPeer::ACCOUNT_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CommunicationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CommunicationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = CommunicationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CommunicationPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = AccountPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = AccountPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AccountPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    AccountPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Communication) to $obj2 (Account)
                $obj2->addCommunicationRelatedByUpdateUserId($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining all related tables
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CommunicationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CommunicationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(CommunicationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CommunicationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CommunicationPeer::CREATION_USER_ID, AccountPeer::ACCOUNT_ID, $join_behavior);

        $criteria->addJoin(CommunicationPeer::UPDATE_USER_ID, AccountPeer::ACCOUNT_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }

    /**
     * Selects a collection of Communication objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Communication objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CommunicationPeer::DATABASE_NAME);
        }

        CommunicationPeer::addSelectColumns($criteria);
        $startcol2 = CommunicationPeer::NUM_HYDRATE_COLUMNS;

        AccountPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AccountPeer::NUM_HYDRATE_COLUMNS;

        AccountPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + AccountPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(CommunicationPeer::CREATION_USER_ID, AccountPeer::ACCOUNT_ID, $join_behavior);

        $criteria->addJoin(CommunicationPeer::UPDATE_USER_ID, AccountPeer::ACCOUNT_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CommunicationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CommunicationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = CommunicationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CommunicationPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined Account rows

            $key2 = AccountPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = AccountPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AccountPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AccountPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (Communication) to the collection in $obj2 (Account)
                $obj2->addCommunicationRelatedByCreationUserId($obj1);
            } // if joined row not null

            // Add objects for joined Account rows

            $key3 = AccountPeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = AccountPeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = AccountPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    AccountPeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (Communication) to the collection in $obj3 (Account)
                $obj3->addCommunicationRelatedByUpdateUserId($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining the related AccountRelatedByCreationUserId table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptAccountRelatedByCreationUserId(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CommunicationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CommunicationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(CommunicationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CommunicationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related AccountRelatedByUpdateUserId table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptAccountRelatedByUpdateUserId(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CommunicationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CommunicationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(CommunicationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CommunicationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of Communication objects pre-filled with all related objects except AccountRelatedByCreationUserId.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Communication objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptAccountRelatedByCreationUserId(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CommunicationPeer::DATABASE_NAME);
        }

        CommunicationPeer::addSelectColumns($criteria);
        $startcol2 = CommunicationPeer::NUM_HYDRATE_COLUMNS;


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CommunicationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CommunicationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = CommunicationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CommunicationPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Communication objects pre-filled with all related objects except AccountRelatedByUpdateUserId.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Communication objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptAccountRelatedByUpdateUserId(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CommunicationPeer::DATABASE_NAME);
        }

        CommunicationPeer::addSelectColumns($criteria);
        $startcol2 = CommunicationPeer::NUM_HYDRATE_COLUMNS;


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CommunicationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CommunicationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = CommunicationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CommunicationPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }

    /**
     * Returns the TableMap related to this peer.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getDatabaseMap(CommunicationPeer::DATABASE_NAME)->getTable(CommunicationPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseCommunicationPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseCommunicationPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \Eulogix\Cool\Bundle\CommunicationsBundle\Model\map\CommunicationTableMap());
      }
    }

    /**
     * The class that the Peer will make instances of.
     *
     *
     * @return string ClassName
     */
    public static function getOMClass($row = 0, $colnum = 0)
    {
        return CommunicationPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Communication or Criteria object.
     *
     * @param      mixed $values Criteria or Communication object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CommunicationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Communication object
        }

        if ($criteria->containsKey(CommunicationPeer::COMMUNICATION_ID) && $criteria->keyContainsValue(CommunicationPeer::COMMUNICATION_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CommunicationPeer::COMMUNICATION_ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(CommunicationPeer::DATABASE_NAME);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = BasePeer::doInsert($criteria, $con);
            $con->commit();
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

    /**
     * Performs an UPDATE on the database, given a Communication or Criteria object.
     *
     * @param      mixed $values Criteria or Communication object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CommunicationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(CommunicationPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(CommunicationPeer::COMMUNICATION_ID);
            $value = $criteria->remove(CommunicationPeer::COMMUNICATION_ID);
            if ($value) {
                $selectCriteria->add(CommunicationPeer::COMMUNICATION_ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(CommunicationPeer::TABLE_NAME);
            }

        } else { // $values is Communication object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(CommunicationPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the communication table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CommunicationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(CommunicationPeer::TABLE_NAME, $con, CommunicationPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CommunicationPeer::clearInstancePool();
            CommunicationPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a Communication or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or Communication object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param      PropelPDO $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *				if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, PropelPDO $con = null)
     {
        if ($con === null) {
            $con = Propel::getConnection(CommunicationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            CommunicationPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Communication) { // it's a model object
            // invalidate the cache for this single object
            CommunicationPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CommunicationPeer::DATABASE_NAME);
            $criteria->add(CommunicationPeer::COMMUNICATION_ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                CommunicationPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(CommunicationPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            CommunicationPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given Communication object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param Communication $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(CommunicationPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(CommunicationPeer::TABLE_NAME);

            if (! is_array($cols)) {
                $cols = array($cols);
            }

            foreach ($cols as $colName) {
                if ($tableMap->hasColumn($colName)) {
                    $get = 'get' . $tableMap->getColumn($colName)->getPhpName();
                    $columns[$colName] = $obj->$get();
                }
            }
        } else {

        }

        return BasePeer::doValidate(CommunicationPeer::DATABASE_NAME, CommunicationPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Communication
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = CommunicationPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(CommunicationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(CommunicationPeer::DATABASE_NAME);
        $criteria->add(CommunicationPeer::COMMUNICATION_ID, $pk);

        $v = CommunicationPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Communication[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CommunicationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(CommunicationPeer::DATABASE_NAME);
            $criteria->add(CommunicationPeer::COMMUNICATION_ID, $pks, Criteria::IN);
            $objs = CommunicationPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseCommunicationPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseCommunicationPeer::buildTableMap();

