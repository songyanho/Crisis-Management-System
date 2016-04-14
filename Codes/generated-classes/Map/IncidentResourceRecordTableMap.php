<?php

namespace Map;

use \IncidentResourceRecord;
use \IncidentResourceRecordQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'incident_resource_record' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class IncidentResourceRecordTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.IncidentResourceRecordTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'cms';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'incident_resource_record';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\IncidentResourceRecord';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'IncidentResourceRecord';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the id field
     */
    const COL_ID = 'incident_resource_record.id';

    /**
     * the column name for the incident_id field
     */
    const COL_INCIDENT_ID = 'incident_resource_record.incident_id';

    /**
     * the column name for the resource_id field
     */
    const COL_RESOURCE_ID = 'incident_resource_record.resource_id';

    /**
     * the column name for the reporter_id field
     */
    const COL_REPORTER_ID = 'incident_resource_record.reporter_id';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'incident_resource_record.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'incident_resource_record.updated_at';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'IncidentId', 'ResourceId', 'ReporterId', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'incidentId', 'resourceId', 'reporterId', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(IncidentResourceRecordTableMap::COL_ID, IncidentResourceRecordTableMap::COL_INCIDENT_ID, IncidentResourceRecordTableMap::COL_RESOURCE_ID, IncidentResourceRecordTableMap::COL_REPORTER_ID, IncidentResourceRecordTableMap::COL_CREATED_AT, IncidentResourceRecordTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'incident_id', 'resource_id', 'reporter_id', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'IncidentId' => 1, 'ResourceId' => 2, 'ReporterId' => 3, 'CreatedAt' => 4, 'UpdatedAt' => 5, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'incidentId' => 1, 'resourceId' => 2, 'reporterId' => 3, 'createdAt' => 4, 'updatedAt' => 5, ),
        self::TYPE_COLNAME       => array(IncidentResourceRecordTableMap::COL_ID => 0, IncidentResourceRecordTableMap::COL_INCIDENT_ID => 1, IncidentResourceRecordTableMap::COL_RESOURCE_ID => 2, IncidentResourceRecordTableMap::COL_REPORTER_ID => 3, IncidentResourceRecordTableMap::COL_CREATED_AT => 4, IncidentResourceRecordTableMap::COL_UPDATED_AT => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'incident_id' => 1, 'resource_id' => 2, 'reporter_id' => 3, 'created_at' => 4, 'updated_at' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('incident_resource_record');
        $this->setPhpName('IncidentResourceRecord');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\IncidentResourceRecord');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('incident_id', 'IncidentId', 'INTEGER', 'incident', 'id', false, null, null);
        $this->addForeignKey('resource_id', 'ResourceId', 'INTEGER', 'resource', 'id', false, null, null);
        $this->addForeignKey('reporter_id', 'ReporterId', 'INTEGER', 'reporter', 'id', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Incident', '\\Incident', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':incident_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Resource', '\\Resource', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':resource_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Reporter', '\\Reporter', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':reporter_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'false', ),
        );
    } // getBehaviors()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? IncidentResourceRecordTableMap::CLASS_DEFAULT : IncidentResourceRecordTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (IncidentResourceRecord object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = IncidentResourceRecordTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = IncidentResourceRecordTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + IncidentResourceRecordTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = IncidentResourceRecordTableMap::OM_CLASS;
            /** @var IncidentResourceRecord $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            IncidentResourceRecordTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = IncidentResourceRecordTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = IncidentResourceRecordTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var IncidentResourceRecord $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                IncidentResourceRecordTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(IncidentResourceRecordTableMap::COL_ID);
            $criteria->addSelectColumn(IncidentResourceRecordTableMap::COL_INCIDENT_ID);
            $criteria->addSelectColumn(IncidentResourceRecordTableMap::COL_RESOURCE_ID);
            $criteria->addSelectColumn(IncidentResourceRecordTableMap::COL_REPORTER_ID);
            $criteria->addSelectColumn(IncidentResourceRecordTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(IncidentResourceRecordTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.incident_id');
            $criteria->addSelectColumn($alias . '.resource_id');
            $criteria->addSelectColumn($alias . '.reporter_id');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(IncidentResourceRecordTableMap::DATABASE_NAME)->getTable(IncidentResourceRecordTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(IncidentResourceRecordTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(IncidentResourceRecordTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new IncidentResourceRecordTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a IncidentResourceRecord or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or IncidentResourceRecord object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(IncidentResourceRecordTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \IncidentResourceRecord) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(IncidentResourceRecordTableMap::DATABASE_NAME);
            $criteria->add(IncidentResourceRecordTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = IncidentResourceRecordQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            IncidentResourceRecordTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                IncidentResourceRecordTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the incident_resource_record table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return IncidentResourceRecordQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a IncidentResourceRecord or Criteria object.
     *
     * @param mixed               $criteria Criteria or IncidentResourceRecord object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(IncidentResourceRecordTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from IncidentResourceRecord object
        }

        if ($criteria->containsKey(IncidentResourceRecordTableMap::COL_ID) && $criteria->keyContainsValue(IncidentResourceRecordTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.IncidentResourceRecordTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = IncidentResourceRecordQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // IncidentResourceRecordTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
IncidentResourceRecordTableMap::buildTableMap();
