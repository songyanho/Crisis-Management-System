<?php

namespace Base;

use \Incident as ChildIncident;
use \IncidentQuery as ChildIncidentQuery;
use \IncidentReporter as ChildIncidentReporter;
use \IncidentReporterQuery as ChildIncidentReporterQuery;
use \IncidentResourceRecord as ChildIncidentResourceRecord;
use \IncidentResourceRecordQuery as ChildIncidentResourceRecordQuery;
use \Reporter as ChildReporter;
use \ReporterQuery as ChildReporterQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\IncidentReporterTableMap;
use Map\IncidentResourceRecordTableMap;
use Map\ReporterTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'reporter' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Reporter implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ReporterTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the tel field.
     *
     * @var        string
     */
    protected $tel;

    /**
     * The value for the created_at field.
     *
     * @var        \DateTime
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     *
     * @var        \DateTime
     */
    protected $updated_at;

    /**
     * @var        ObjectCollection|ChildIncidentReporter[] Collection to store aggregation of ChildIncidentReporter objects.
     */
    protected $collIncidentReporters;
    protected $collIncidentReportersPartial;

    /**
     * @var        ObjectCollection|ChildIncidentResourceRecord[] Collection to store aggregation of ChildIncidentResourceRecord objects.
     */
    protected $collIncidentResourceRecords;
    protected $collIncidentResourceRecordsPartial;

    /**
     * @var        ObjectCollection|ChildIncident[] Cross Collection to store aggregation of ChildIncident objects.
     */
    protected $collIncidents;

    /**
     * @var bool
     */
    protected $collIncidentsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildIncident[]
     */
    protected $incidentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildIncidentReporter[]
     */
    protected $incidentReportersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildIncidentResourceRecord[]
     */
    protected $incidentResourceRecordsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Reporter object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Reporter</code> instance.  If
     * <code>obj</code> is an instance of <code>Reporter</code>, delegates to
     * <code>equals(Reporter)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Reporter The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [tel] column value.
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTime ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->updated_at;
        } else {
            return $this->updated_at instanceof \DateTime ? $this->updated_at->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Reporter The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ReporterTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Reporter The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[ReporterTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [tel] column.
     *
     * @param string $v new value
     * @return $this|\Reporter The current object (for fluent API support)
     */
    public function setTel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tel !== $v) {
            $this->tel = $v;
            $this->modifiedColumns[ReporterTableMap::COL_TEL] = true;
        }

        return $this;
    } // setTel()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Reporter The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ReporterTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Reporter The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->updated_at->format("Y-m-d H:i:s")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ReporterTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ReporterTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ReporterTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ReporterTableMap::translateFieldName('Tel', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tel = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ReporterTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ReporterTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = ReporterTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Reporter'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ReporterTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildReporterQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collIncidentReporters = null;

            $this->collIncidentResourceRecords = null;

            $this->collIncidents = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Reporter::setDeleted()
     * @see Reporter::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ReporterTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildReporterQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ReporterTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(ReporterTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(ReporterTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(ReporterTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                ReporterTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->incidentsScheduledForDeletion !== null) {
                if (!$this->incidentsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->incidentsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \IncidentReporterQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->incidentsScheduledForDeletion = null;
                }

            }

            if ($this->collIncidents) {
                foreach ($this->collIncidents as $incident) {
                    if (!$incident->isDeleted() && ($incident->isNew() || $incident->isModified())) {
                        $incident->save($con);
                    }
                }
            }


            if ($this->incidentReportersScheduledForDeletion !== null) {
                if (!$this->incidentReportersScheduledForDeletion->isEmpty()) {
                    \IncidentReporterQuery::create()
                        ->filterByPrimaryKeys($this->incidentReportersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->incidentReportersScheduledForDeletion = null;
                }
            }

            if ($this->collIncidentReporters !== null) {
                foreach ($this->collIncidentReporters as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->incidentResourceRecordsScheduledForDeletion !== null) {
                if (!$this->incidentResourceRecordsScheduledForDeletion->isEmpty()) {
                    \IncidentResourceRecordQuery::create()
                        ->filterByPrimaryKeys($this->incidentResourceRecordsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->incidentResourceRecordsScheduledForDeletion = null;
                }
            }

            if ($this->collIncidentResourceRecords !== null) {
                foreach ($this->collIncidentResourceRecords as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[ReporterTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ReporterTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ReporterTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ReporterTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(ReporterTableMap::COL_TEL)) {
            $modifiedColumns[':p' . $index++]  = 'tel';
        }
        if ($this->isColumnModified(ReporterTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(ReporterTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }

        $sql = sprintf(
            'INSERT INTO reporter (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'tel':
                        $stmt->bindValue($identifier, $this->tel, PDO::PARAM_STR);
                        break;
                    case 'created_at':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'updated_at':
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ReporterTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getTel();
                break;
            case 3:
                return $this->getCreatedAt();
                break;
            case 4:
                return $this->getUpdatedAt();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Reporter'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Reporter'][$this->hashCode()] = true;
        $keys = ReporterTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getTel(),
            $keys[3] => $this->getCreatedAt(),
            $keys[4] => $this->getUpdatedAt(),
        );
        if ($result[$keys[3]] instanceof \DateTime) {
            $result[$keys[3]] = $result[$keys[3]]->format('c');
        }

        if ($result[$keys[4]] instanceof \DateTime) {
            $result[$keys[4]] = $result[$keys[4]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collIncidentReporters) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'incidentReporters';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'incident_reporters';
                        break;
                    default:
                        $key = 'IncidentReporters';
                }

                $result[$key] = $this->collIncidentReporters->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collIncidentResourceRecords) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'incidentResourceRecords';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'incident_resource_records';
                        break;
                    default:
                        $key = 'IncidentResourceRecords';
                }

                $result[$key] = $this->collIncidentResourceRecords->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Reporter
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ReporterTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Reporter
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setTel($value);
                break;
            case 3:
                $this->setCreatedAt($value);
                break;
            case 4:
                $this->setUpdatedAt($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = ReporterTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setTel($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCreatedAt($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setUpdatedAt($arr[$keys[4]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Reporter The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ReporterTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ReporterTableMap::COL_ID)) {
            $criteria->add(ReporterTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ReporterTableMap::COL_NAME)) {
            $criteria->add(ReporterTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(ReporterTableMap::COL_TEL)) {
            $criteria->add(ReporterTableMap::COL_TEL, $this->tel);
        }
        if ($this->isColumnModified(ReporterTableMap::COL_CREATED_AT)) {
            $criteria->add(ReporterTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(ReporterTableMap::COL_UPDATED_AT)) {
            $criteria->add(ReporterTableMap::COL_UPDATED_AT, $this->updated_at);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildReporterQuery::create();
        $criteria->add(ReporterTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Reporter (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setTel($this->getTel());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getIncidentReporters() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addIncidentReporter($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getIncidentResourceRecords() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addIncidentResourceRecord($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Reporter Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('IncidentReporter' == $relationName) {
            return $this->initIncidentReporters();
        }
        if ('IncidentResourceRecord' == $relationName) {
            return $this->initIncidentResourceRecords();
        }
    }

    /**
     * Clears out the collIncidentReporters collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addIncidentReporters()
     */
    public function clearIncidentReporters()
    {
        $this->collIncidentReporters = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collIncidentReporters collection loaded partially.
     */
    public function resetPartialIncidentReporters($v = true)
    {
        $this->collIncidentReportersPartial = $v;
    }

    /**
     * Initializes the collIncidentReporters collection.
     *
     * By default this just sets the collIncidentReporters collection to an empty array (like clearcollIncidentReporters());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initIncidentReporters($overrideExisting = true)
    {
        if (null !== $this->collIncidentReporters && !$overrideExisting) {
            return;
        }

        $collectionClassName = IncidentReporterTableMap::getTableMap()->getCollectionClassName();

        $this->collIncidentReporters = new $collectionClassName;
        $this->collIncidentReporters->setModel('\IncidentReporter');
    }

    /**
     * Gets an array of ChildIncidentReporter objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildReporter is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildIncidentReporter[] List of ChildIncidentReporter objects
     * @throws PropelException
     */
    public function getIncidentReporters(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collIncidentReportersPartial && !$this->isNew();
        if (null === $this->collIncidentReporters || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collIncidentReporters) {
                // return empty collection
                $this->initIncidentReporters();
            } else {
                $collIncidentReporters = ChildIncidentReporterQuery::create(null, $criteria)
                    ->filterByReporter($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collIncidentReportersPartial && count($collIncidentReporters)) {
                        $this->initIncidentReporters(false);

                        foreach ($collIncidentReporters as $obj) {
                            if (false == $this->collIncidentReporters->contains($obj)) {
                                $this->collIncidentReporters->append($obj);
                            }
                        }

                        $this->collIncidentReportersPartial = true;
                    }

                    return $collIncidentReporters;
                }

                if ($partial && $this->collIncidentReporters) {
                    foreach ($this->collIncidentReporters as $obj) {
                        if ($obj->isNew()) {
                            $collIncidentReporters[] = $obj;
                        }
                    }
                }

                $this->collIncidentReporters = $collIncidentReporters;
                $this->collIncidentReportersPartial = false;
            }
        }

        return $this->collIncidentReporters;
    }

    /**
     * Sets a collection of ChildIncidentReporter objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $incidentReporters A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildReporter The current object (for fluent API support)
     */
    public function setIncidentReporters(Collection $incidentReporters, ConnectionInterface $con = null)
    {
        /** @var ChildIncidentReporter[] $incidentReportersToDelete */
        $incidentReportersToDelete = $this->getIncidentReporters(new Criteria(), $con)->diff($incidentReporters);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->incidentReportersScheduledForDeletion = clone $incidentReportersToDelete;

        foreach ($incidentReportersToDelete as $incidentReporterRemoved) {
            $incidentReporterRemoved->setReporter(null);
        }

        $this->collIncidentReporters = null;
        foreach ($incidentReporters as $incidentReporter) {
            $this->addIncidentReporter($incidentReporter);
        }

        $this->collIncidentReporters = $incidentReporters;
        $this->collIncidentReportersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related IncidentReporter objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related IncidentReporter objects.
     * @throws PropelException
     */
    public function countIncidentReporters(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collIncidentReportersPartial && !$this->isNew();
        if (null === $this->collIncidentReporters || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collIncidentReporters) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getIncidentReporters());
            }

            $query = ChildIncidentReporterQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByReporter($this)
                ->count($con);
        }

        return count($this->collIncidentReporters);
    }

    /**
     * Method called to associate a ChildIncidentReporter object to this object
     * through the ChildIncidentReporter foreign key attribute.
     *
     * @param  ChildIncidentReporter $l ChildIncidentReporter
     * @return $this|\Reporter The current object (for fluent API support)
     */
    public function addIncidentReporter(ChildIncidentReporter $l)
    {
        if ($this->collIncidentReporters === null) {
            $this->initIncidentReporters();
            $this->collIncidentReportersPartial = true;
        }

        if (!$this->collIncidentReporters->contains($l)) {
            $this->doAddIncidentReporter($l);

            if ($this->incidentReportersScheduledForDeletion and $this->incidentReportersScheduledForDeletion->contains($l)) {
                $this->incidentReportersScheduledForDeletion->remove($this->incidentReportersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildIncidentReporter $incidentReporter The ChildIncidentReporter object to add.
     */
    protected function doAddIncidentReporter(ChildIncidentReporter $incidentReporter)
    {
        $this->collIncidentReporters[]= $incidentReporter;
        $incidentReporter->setReporter($this);
    }

    /**
     * @param  ChildIncidentReporter $incidentReporter The ChildIncidentReporter object to remove.
     * @return $this|ChildReporter The current object (for fluent API support)
     */
    public function removeIncidentReporter(ChildIncidentReporter $incidentReporter)
    {
        if ($this->getIncidentReporters()->contains($incidentReporter)) {
            $pos = $this->collIncidentReporters->search($incidentReporter);
            $this->collIncidentReporters->remove($pos);
            if (null === $this->incidentReportersScheduledForDeletion) {
                $this->incidentReportersScheduledForDeletion = clone $this->collIncidentReporters;
                $this->incidentReportersScheduledForDeletion->clear();
            }
            $this->incidentReportersScheduledForDeletion[]= clone $incidentReporter;
            $incidentReporter->setReporter(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Reporter is new, it will return
     * an empty collection; or if this Reporter has previously
     * been saved, it will retrieve related IncidentReporters from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Reporter.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildIncidentReporter[] List of ChildIncidentReporter objects
     */
    public function getIncidentReportersJoinIncident(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildIncidentReporterQuery::create(null, $criteria);
        $query->joinWith('Incident', $joinBehavior);

        return $this->getIncidentReporters($query, $con);
    }

    /**
     * Clears out the collIncidentResourceRecords collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addIncidentResourceRecords()
     */
    public function clearIncidentResourceRecords()
    {
        $this->collIncidentResourceRecords = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collIncidentResourceRecords collection loaded partially.
     */
    public function resetPartialIncidentResourceRecords($v = true)
    {
        $this->collIncidentResourceRecordsPartial = $v;
    }

    /**
     * Initializes the collIncidentResourceRecords collection.
     *
     * By default this just sets the collIncidentResourceRecords collection to an empty array (like clearcollIncidentResourceRecords());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initIncidentResourceRecords($overrideExisting = true)
    {
        if (null !== $this->collIncidentResourceRecords && !$overrideExisting) {
            return;
        }

        $collectionClassName = IncidentResourceRecordTableMap::getTableMap()->getCollectionClassName();

        $this->collIncidentResourceRecords = new $collectionClassName;
        $this->collIncidentResourceRecords->setModel('\IncidentResourceRecord');
    }

    /**
     * Gets an array of ChildIncidentResourceRecord objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildReporter is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildIncidentResourceRecord[] List of ChildIncidentResourceRecord objects
     * @throws PropelException
     */
    public function getIncidentResourceRecords(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collIncidentResourceRecordsPartial && !$this->isNew();
        if (null === $this->collIncidentResourceRecords || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collIncidentResourceRecords) {
                // return empty collection
                $this->initIncidentResourceRecords();
            } else {
                $collIncidentResourceRecords = ChildIncidentResourceRecordQuery::create(null, $criteria)
                    ->filterByReporter($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collIncidentResourceRecordsPartial && count($collIncidentResourceRecords)) {
                        $this->initIncidentResourceRecords(false);

                        foreach ($collIncidentResourceRecords as $obj) {
                            if (false == $this->collIncidentResourceRecords->contains($obj)) {
                                $this->collIncidentResourceRecords->append($obj);
                            }
                        }

                        $this->collIncidentResourceRecordsPartial = true;
                    }

                    return $collIncidentResourceRecords;
                }

                if ($partial && $this->collIncidentResourceRecords) {
                    foreach ($this->collIncidentResourceRecords as $obj) {
                        if ($obj->isNew()) {
                            $collIncidentResourceRecords[] = $obj;
                        }
                    }
                }

                $this->collIncidentResourceRecords = $collIncidentResourceRecords;
                $this->collIncidentResourceRecordsPartial = false;
            }
        }

        return $this->collIncidentResourceRecords;
    }

    /**
     * Sets a collection of ChildIncidentResourceRecord objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $incidentResourceRecords A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildReporter The current object (for fluent API support)
     */
    public function setIncidentResourceRecords(Collection $incidentResourceRecords, ConnectionInterface $con = null)
    {
        /** @var ChildIncidentResourceRecord[] $incidentResourceRecordsToDelete */
        $incidentResourceRecordsToDelete = $this->getIncidentResourceRecords(new Criteria(), $con)->diff($incidentResourceRecords);


        $this->incidentResourceRecordsScheduledForDeletion = $incidentResourceRecordsToDelete;

        foreach ($incidentResourceRecordsToDelete as $incidentResourceRecordRemoved) {
            $incidentResourceRecordRemoved->setReporter(null);
        }

        $this->collIncidentResourceRecords = null;
        foreach ($incidentResourceRecords as $incidentResourceRecord) {
            $this->addIncidentResourceRecord($incidentResourceRecord);
        }

        $this->collIncidentResourceRecords = $incidentResourceRecords;
        $this->collIncidentResourceRecordsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related IncidentResourceRecord objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related IncidentResourceRecord objects.
     * @throws PropelException
     */
    public function countIncidentResourceRecords(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collIncidentResourceRecordsPartial && !$this->isNew();
        if (null === $this->collIncidentResourceRecords || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collIncidentResourceRecords) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getIncidentResourceRecords());
            }

            $query = ChildIncidentResourceRecordQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByReporter($this)
                ->count($con);
        }

        return count($this->collIncidentResourceRecords);
    }

    /**
     * Method called to associate a ChildIncidentResourceRecord object to this object
     * through the ChildIncidentResourceRecord foreign key attribute.
     *
     * @param  ChildIncidentResourceRecord $l ChildIncidentResourceRecord
     * @return $this|\Reporter The current object (for fluent API support)
     */
    public function addIncidentResourceRecord(ChildIncidentResourceRecord $l)
    {
        if ($this->collIncidentResourceRecords === null) {
            $this->initIncidentResourceRecords();
            $this->collIncidentResourceRecordsPartial = true;
        }

        if (!$this->collIncidentResourceRecords->contains($l)) {
            $this->doAddIncidentResourceRecord($l);

            if ($this->incidentResourceRecordsScheduledForDeletion and $this->incidentResourceRecordsScheduledForDeletion->contains($l)) {
                $this->incidentResourceRecordsScheduledForDeletion->remove($this->incidentResourceRecordsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildIncidentResourceRecord $incidentResourceRecord The ChildIncidentResourceRecord object to add.
     */
    protected function doAddIncidentResourceRecord(ChildIncidentResourceRecord $incidentResourceRecord)
    {
        $this->collIncidentResourceRecords[]= $incidentResourceRecord;
        $incidentResourceRecord->setReporter($this);
    }

    /**
     * @param  ChildIncidentResourceRecord $incidentResourceRecord The ChildIncidentResourceRecord object to remove.
     * @return $this|ChildReporter The current object (for fluent API support)
     */
    public function removeIncidentResourceRecord(ChildIncidentResourceRecord $incidentResourceRecord)
    {
        if ($this->getIncidentResourceRecords()->contains($incidentResourceRecord)) {
            $pos = $this->collIncidentResourceRecords->search($incidentResourceRecord);
            $this->collIncidentResourceRecords->remove($pos);
            if (null === $this->incidentResourceRecordsScheduledForDeletion) {
                $this->incidentResourceRecordsScheduledForDeletion = clone $this->collIncidentResourceRecords;
                $this->incidentResourceRecordsScheduledForDeletion->clear();
            }
            $this->incidentResourceRecordsScheduledForDeletion[]= $incidentResourceRecord;
            $incidentResourceRecord->setReporter(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Reporter is new, it will return
     * an empty collection; or if this Reporter has previously
     * been saved, it will retrieve related IncidentResourceRecords from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Reporter.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildIncidentResourceRecord[] List of ChildIncidentResourceRecord objects
     */
    public function getIncidentResourceRecordsJoinIncident(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildIncidentResourceRecordQuery::create(null, $criteria);
        $query->joinWith('Incident', $joinBehavior);

        return $this->getIncidentResourceRecords($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Reporter is new, it will return
     * an empty collection; or if this Reporter has previously
     * been saved, it will retrieve related IncidentResourceRecords from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Reporter.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildIncidentResourceRecord[] List of ChildIncidentResourceRecord objects
     */
    public function getIncidentResourceRecordsJoinResource(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildIncidentResourceRecordQuery::create(null, $criteria);
        $query->joinWith('Resource', $joinBehavior);

        return $this->getIncidentResourceRecords($query, $con);
    }

    /**
     * Clears out the collIncidents collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addIncidents()
     */
    public function clearIncidents()
    {
        $this->collIncidents = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collIncidents crossRef collection.
     *
     * By default this just sets the collIncidents collection to an empty collection (like clearIncidents());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initIncidents()
    {
        $collectionClassName = IncidentReporterTableMap::getTableMap()->getCollectionClassName();

        $this->collIncidents = new $collectionClassName;
        $this->collIncidentsPartial = true;
        $this->collIncidents->setModel('\Incident');
    }

    /**
     * Checks if the collIncidents collection is loaded.
     *
     * @return bool
     */
    public function isIncidentsLoaded()
    {
        return null !== $this->collIncidents;
    }

    /**
     * Gets a collection of ChildIncident objects related by a many-to-many relationship
     * to the current object by way of the incident_reporter cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildReporter is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildIncident[] List of ChildIncident objects
     */
    public function getIncidents(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collIncidentsPartial && !$this->isNew();
        if (null === $this->collIncidents || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collIncidents) {
                    $this->initIncidents();
                }
            } else {

                $query = ChildIncidentQuery::create(null, $criteria)
                    ->filterByReporter($this);
                $collIncidents = $query->find($con);
                if (null !== $criteria) {
                    return $collIncidents;
                }

                if ($partial && $this->collIncidents) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collIncidents as $obj) {
                        if (!$collIncidents->contains($obj)) {
                            $collIncidents[] = $obj;
                        }
                    }
                }

                $this->collIncidents = $collIncidents;
                $this->collIncidentsPartial = false;
            }
        }

        return $this->collIncidents;
    }

    /**
     * Sets a collection of Incident objects related by a many-to-many relationship
     * to the current object by way of the incident_reporter cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $incidents A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildReporter The current object (for fluent API support)
     */
    public function setIncidents(Collection $incidents, ConnectionInterface $con = null)
    {
        $this->clearIncidents();
        $currentIncidents = $this->getIncidents();

        $incidentsScheduledForDeletion = $currentIncidents->diff($incidents);

        foreach ($incidentsScheduledForDeletion as $toDelete) {
            $this->removeIncident($toDelete);
        }

        foreach ($incidents as $incident) {
            if (!$currentIncidents->contains($incident)) {
                $this->doAddIncident($incident);
            }
        }

        $this->collIncidentsPartial = false;
        $this->collIncidents = $incidents;

        return $this;
    }

    /**
     * Gets the number of Incident objects related by a many-to-many relationship
     * to the current object by way of the incident_reporter cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Incident objects
     */
    public function countIncidents(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collIncidentsPartial && !$this->isNew();
        if (null === $this->collIncidents || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collIncidents) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getIncidents());
                }

                $query = ChildIncidentQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByReporter($this)
                    ->count($con);
            }
        } else {
            return count($this->collIncidents);
        }
    }

    /**
     * Associate a ChildIncident to this object
     * through the incident_reporter cross reference table.
     *
     * @param ChildIncident $incident
     * @return ChildReporter The current object (for fluent API support)
     */
    public function addIncident(ChildIncident $incident)
    {
        if ($this->collIncidents === null) {
            $this->initIncidents();
        }

        if (!$this->getIncidents()->contains($incident)) {
            // only add it if the **same** object is not already associated
            $this->collIncidents->push($incident);
            $this->doAddIncident($incident);
        }

        return $this;
    }

    /**
     *
     * @param ChildIncident $incident
     */
    protected function doAddIncident(ChildIncident $incident)
    {
        $incidentReporter = new ChildIncidentReporter();

        $incidentReporter->setIncident($incident);

        $incidentReporter->setReporter($this);

        $this->addIncidentReporter($incidentReporter);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$incident->isReportersLoaded()) {
            $incident->initReporters();
            $incident->getReporters()->push($this);
        } elseif (!$incident->getReporters()->contains($this)) {
            $incident->getReporters()->push($this);
        }

    }

    /**
     * Remove incident of this object
     * through the incident_reporter cross reference table.
     *
     * @param ChildIncident $incident
     * @return ChildReporter The current object (for fluent API support)
     */
    public function removeIncident(ChildIncident $incident)
    {
        if ($this->getIncidents()->contains($incident)) { $incidentReporter = new ChildIncidentReporter();

            $incidentReporter->setIncident($incident);
            if ($incident->isReportersLoaded()) {
                //remove the back reference if available
                $incident->getReporters()->removeObject($this);
            }

            $incidentReporter->setReporter($this);
            $this->removeIncidentReporter(clone $incidentReporter);
            $incidentReporter->clear();

            $this->collIncidents->remove($this->collIncidents->search($incident));

            if (null === $this->incidentsScheduledForDeletion) {
                $this->incidentsScheduledForDeletion = clone $this->collIncidents;
                $this->incidentsScheduledForDeletion->clear();
            }

            $this->incidentsScheduledForDeletion->push($incident);
        }


        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->tel = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collIncidentReporters) {
                foreach ($this->collIncidentReporters as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collIncidentResourceRecords) {
                foreach ($this->collIncidentResourceRecords as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collIncidents) {
                foreach ($this->collIncidents as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collIncidentReporters = null;
        $this->collIncidentResourceRecords = null;
        $this->collIncidents = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ReporterTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildReporter The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[ReporterTableMap::COL_UPDATED_AT] = true;

        return $this;
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
