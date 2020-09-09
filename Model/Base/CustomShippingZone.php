<?php

namespace CustomShippingZone\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use CustomShippingZone\Model\CustomShippingZone as ChildCustomShippingZone;
use CustomShippingZone\Model\CustomShippingZoneI18n as ChildCustomShippingZoneI18n;
use CustomShippingZone\Model\CustomShippingZoneI18nQuery as ChildCustomShippingZoneI18nQuery;
use CustomShippingZone\Model\CustomShippingZoneModules as ChildCustomShippingZoneModules;
use CustomShippingZone\Model\CustomShippingZoneModulesQuery as ChildCustomShippingZoneModulesQuery;
use CustomShippingZone\Model\CustomShippingZoneQuery as ChildCustomShippingZoneQuery;
use CustomShippingZone\Model\CustomShippingZoneZip as ChildCustomShippingZoneZip;
use CustomShippingZone\Model\CustomShippingZoneZipQuery as ChildCustomShippingZoneZipQuery;
use CustomShippingZone\Model\Map\CustomShippingZoneTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

abstract class CustomShippingZone implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\CustomShippingZone\\Model\\Map\\CustomShippingZoneTableMap';


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
     * @var        int
     */
    protected $id;

    /**
     * The value for the tax field.
     * @var        double
     */
    protected $tax;

    /**
     * The value for the created_at field.
     * @var        string
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     * @var        string
     */
    protected $updated_at;

    /**
     * @var        ObjectCollection|ChildCustomShippingZoneZip[] Collection to store aggregation of ChildCustomShippingZoneZip objects.
     */
    protected $collCustomShippingZoneZips;
    protected $collCustomShippingZoneZipsPartial;

    /**
     * @var        ObjectCollection|ChildCustomShippingZoneModules[] Collection to store aggregation of ChildCustomShippingZoneModules objects.
     */
    protected $collCustomShippingZoneModuless;
    protected $collCustomShippingZoneModulessPartial;

    /**
     * @var        ObjectCollection|ChildCustomShippingZoneI18n[] Collection to store aggregation of ChildCustomShippingZoneI18n objects.
     */
    protected $collCustomShippingZoneI18ns;
    protected $collCustomShippingZoneI18nsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    // i18n behavior

    /**
     * Current locale
     * @var        string
     */
    protected $currentLocale = 'en_US';

    /**
     * Current translation objects
     * @var        array[ChildCustomShippingZoneI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $customShippingZoneZipsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $customShippingZoneModulessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $customShippingZoneI18nsScheduledForDeletion = null;

    /**
     * Initializes internal state of CustomShippingZone\Model\Base\CustomShippingZone object.
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
        $this->new = (Boolean) $b;
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
        $this->deleted = (Boolean) $b;
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
     * Compares this with another <code>CustomShippingZone</code> instance.  If
     * <code>obj</code> is an instance of <code>CustomShippingZone</code>, delegates to
     * <code>equals(CustomShippingZone)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        $thisclazz = get_class($this);
        if (!is_object($obj) || !($obj instanceof $thisclazz)) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey()
            || null === $obj->getPrimaryKey())  {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        if (null !== $this->getPrimaryKey()) {
            return crc32(serialize($this->getPrimaryKey()));
        }

        return crc32(serialize(clone $this));
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
     * @return CustomShippingZone The current object, for fluid interface
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
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     *
     * @return CustomShippingZone The current object, for fluid interface
     */
    public function importFrom($parser, $data)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), TableMap::TYPE_PHPNAME);

        return $this;
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

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     *
     * @return   int
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [tax] column value.
     *
     * @return   double
     */
    public function getTax()
    {

        return $this->tax;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
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
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
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
     * @param      int $v new value
     * @return   \CustomShippingZone\Model\CustomShippingZone The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[CustomShippingZoneTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [tax] column.
     *
     * @param      double $v new value
     * @return   \CustomShippingZone\Model\CustomShippingZone The current object (for fluent API support)
     */
    public function setTax($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->tax !== $v) {
            $this->tax = $v;
            $this->modifiedColumns[CustomShippingZoneTableMap::TAX] = true;
        }


        return $this;
    } // setTax()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \CustomShippingZone\Model\CustomShippingZone The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[CustomShippingZoneTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \CustomShippingZone\Model\CustomShippingZone The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[CustomShippingZoneTableMap::UPDATED_AT] = true;
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
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CustomShippingZoneTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CustomShippingZoneTableMap::translateFieldName('Tax', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tax = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : CustomShippingZoneTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : CustomShippingZoneTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = CustomShippingZoneTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \CustomShippingZone\Model\CustomShippingZone object", 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(CustomShippingZoneTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCustomShippingZoneQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collCustomShippingZoneZips = null;

            $this->collCustomShippingZoneModuless = null;

            $this->collCustomShippingZoneI18ns = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see CustomShippingZone::setDeleted()
     * @see CustomShippingZone::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CustomShippingZoneTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildCustomShippingZoneQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
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
            $con = Propel::getServiceContainer()->getWriteConnection(CustomShippingZoneTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(CustomShippingZoneTableMap::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(CustomShippingZoneTableMap::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(CustomShippingZoneTableMap::UPDATED_AT)) {
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
                CustomShippingZoneTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
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
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->customShippingZoneZipsScheduledForDeletion !== null) {
                if (!$this->customShippingZoneZipsScheduledForDeletion->isEmpty()) {
                    \CustomShippingZone\Model\CustomShippingZoneZipQuery::create()
                        ->filterByPrimaryKeys($this->customShippingZoneZipsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->customShippingZoneZipsScheduledForDeletion = null;
                }
            }

                if ($this->collCustomShippingZoneZips !== null) {
            foreach ($this->collCustomShippingZoneZips as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->customShippingZoneModulessScheduledForDeletion !== null) {
                if (!$this->customShippingZoneModulessScheduledForDeletion->isEmpty()) {
                    \CustomShippingZone\Model\CustomShippingZoneModulesQuery::create()
                        ->filterByPrimaryKeys($this->customShippingZoneModulessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->customShippingZoneModulessScheduledForDeletion = null;
                }
            }

                if ($this->collCustomShippingZoneModuless !== null) {
            foreach ($this->collCustomShippingZoneModuless as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->customShippingZoneI18nsScheduledForDeletion !== null) {
                if (!$this->customShippingZoneI18nsScheduledForDeletion->isEmpty()) {
                    \CustomShippingZone\Model\CustomShippingZoneI18nQuery::create()
                        ->filterByPrimaryKeys($this->customShippingZoneI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->customShippingZoneI18nsScheduledForDeletion = null;
                }
            }

                if ($this->collCustomShippingZoneI18ns !== null) {
            foreach ($this->collCustomShippingZoneI18ns as $referrerFK) {
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

        $this->modifiedColumns[CustomShippingZoneTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CustomShippingZoneTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CustomShippingZoneTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(CustomShippingZoneTableMap::TAX)) {
            $modifiedColumns[':p' . $index++]  = 'TAX';
        }
        if ($this->isColumnModified(CustomShippingZoneTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(CustomShippingZoneTableMap::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }

        $sql = sprintf(
            'INSERT INTO custom_shipping_zone (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'TAX':
                        $stmt->bindValue($identifier, $this->tax, PDO::PARAM_STR);
                        break;
                    case 'CREATED_AT':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'UPDATED_AT':
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
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CustomShippingZoneTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getTax();
                break;
            case 2:
                return $this->getCreatedAt();
                break;
            case 3:
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
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
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
        if (isset($alreadyDumpedObjects['CustomShippingZone'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['CustomShippingZone'][$this->getPrimaryKey()] = true;
        $keys = CustomShippingZoneTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getTax(),
            $keys[2] => $this->getCreatedAt(),
            $keys[3] => $this->getUpdatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collCustomShippingZoneZips) {
                $result['CustomShippingZoneZips'] = $this->collCustomShippingZoneZips->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCustomShippingZoneModuless) {
                $result['CustomShippingZoneModuless'] = $this->collCustomShippingZoneModuless->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCustomShippingZoneI18ns) {
                $result['CustomShippingZoneI18ns'] = $this->collCustomShippingZoneI18ns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param      string $name
     * @param      mixed  $value field value
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return void
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CustomShippingZoneTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @param      mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setTax($value);
                break;
            case 2:
                $this->setCreatedAt($value);
                break;
            case 3:
                $this->setUpdatedAt($value);
                break;
        } // switch()
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
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = CustomShippingZoneTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setTax($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setCreatedAt($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setUpdatedAt($arr[$keys[3]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CustomShippingZoneTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CustomShippingZoneTableMap::ID)) $criteria->add(CustomShippingZoneTableMap::ID, $this->id);
        if ($this->isColumnModified(CustomShippingZoneTableMap::TAX)) $criteria->add(CustomShippingZoneTableMap::TAX, $this->tax);
        if ($this->isColumnModified(CustomShippingZoneTableMap::CREATED_AT)) $criteria->add(CustomShippingZoneTableMap::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(CustomShippingZoneTableMap::UPDATED_AT)) $criteria->add(CustomShippingZoneTableMap::UPDATED_AT, $this->updated_at);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(CustomShippingZoneTableMap::DATABASE_NAME);
        $criteria->add(CustomShippingZoneTableMap::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return   int
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
     * @param      object $copyObj An object of \CustomShippingZone\Model\CustomShippingZone (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTax($this->getTax());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCustomShippingZoneZips() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCustomShippingZoneZip($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCustomShippingZoneModuless() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCustomShippingZoneModules($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCustomShippingZoneI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCustomShippingZoneI18n($relObj->copy($deepCopy));
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
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return                 \CustomShippingZone\Model\CustomShippingZone Clone of current object.
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
        if ('CustomShippingZoneZip' == $relationName) {
            return $this->initCustomShippingZoneZips();
        }
        if ('CustomShippingZoneModules' == $relationName) {
            return $this->initCustomShippingZoneModuless();
        }
        if ('CustomShippingZoneI18n' == $relationName) {
            return $this->initCustomShippingZoneI18ns();
        }
    }

    /**
     * Clears out the collCustomShippingZoneZips collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCustomShippingZoneZips()
     */
    public function clearCustomShippingZoneZips()
    {
        $this->collCustomShippingZoneZips = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCustomShippingZoneZips collection loaded partially.
     */
    public function resetPartialCustomShippingZoneZips($v = true)
    {
        $this->collCustomShippingZoneZipsPartial = $v;
    }

    /**
     * Initializes the collCustomShippingZoneZips collection.
     *
     * By default this just sets the collCustomShippingZoneZips collection to an empty array (like clearcollCustomShippingZoneZips());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCustomShippingZoneZips($overrideExisting = true)
    {
        if (null !== $this->collCustomShippingZoneZips && !$overrideExisting) {
            return;
        }
        $this->collCustomShippingZoneZips = new ObjectCollection();
        $this->collCustomShippingZoneZips->setModel('\CustomShippingZone\Model\CustomShippingZoneZip');
    }

    /**
     * Gets an array of ChildCustomShippingZoneZip objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCustomShippingZone is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildCustomShippingZoneZip[] List of ChildCustomShippingZoneZip objects
     * @throws PropelException
     */
    public function getCustomShippingZoneZips($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCustomShippingZoneZipsPartial && !$this->isNew();
        if (null === $this->collCustomShippingZoneZips || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCustomShippingZoneZips) {
                // return empty collection
                $this->initCustomShippingZoneZips();
            } else {
                $collCustomShippingZoneZips = ChildCustomShippingZoneZipQuery::create(null, $criteria)
                    ->filterByCustomShippingZone($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCustomShippingZoneZipsPartial && count($collCustomShippingZoneZips)) {
                        $this->initCustomShippingZoneZips(false);

                        foreach ($collCustomShippingZoneZips as $obj) {
                            if (false == $this->collCustomShippingZoneZips->contains($obj)) {
                                $this->collCustomShippingZoneZips->append($obj);
                            }
                        }

                        $this->collCustomShippingZoneZipsPartial = true;
                    }

                    reset($collCustomShippingZoneZips);

                    return $collCustomShippingZoneZips;
                }

                if ($partial && $this->collCustomShippingZoneZips) {
                    foreach ($this->collCustomShippingZoneZips as $obj) {
                        if ($obj->isNew()) {
                            $collCustomShippingZoneZips[] = $obj;
                        }
                    }
                }

                $this->collCustomShippingZoneZips = $collCustomShippingZoneZips;
                $this->collCustomShippingZoneZipsPartial = false;
            }
        }

        return $this->collCustomShippingZoneZips;
    }

    /**
     * Sets a collection of CustomShippingZoneZip objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $customShippingZoneZips A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildCustomShippingZone The current object (for fluent API support)
     */
    public function setCustomShippingZoneZips(Collection $customShippingZoneZips, ConnectionInterface $con = null)
    {
        $customShippingZoneZipsToDelete = $this->getCustomShippingZoneZips(new Criteria(), $con)->diff($customShippingZoneZips);


        $this->customShippingZoneZipsScheduledForDeletion = $customShippingZoneZipsToDelete;

        foreach ($customShippingZoneZipsToDelete as $customShippingZoneZipRemoved) {
            $customShippingZoneZipRemoved->setCustomShippingZone(null);
        }

        $this->collCustomShippingZoneZips = null;
        foreach ($customShippingZoneZips as $customShippingZoneZip) {
            $this->addCustomShippingZoneZip($customShippingZoneZip);
        }

        $this->collCustomShippingZoneZips = $customShippingZoneZips;
        $this->collCustomShippingZoneZipsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CustomShippingZoneZip objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CustomShippingZoneZip objects.
     * @throws PropelException
     */
    public function countCustomShippingZoneZips(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCustomShippingZoneZipsPartial && !$this->isNew();
        if (null === $this->collCustomShippingZoneZips || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCustomShippingZoneZips) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCustomShippingZoneZips());
            }

            $query = ChildCustomShippingZoneZipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCustomShippingZone($this)
                ->count($con);
        }

        return count($this->collCustomShippingZoneZips);
    }

    /**
     * Method called to associate a ChildCustomShippingZoneZip object to this object
     * through the ChildCustomShippingZoneZip foreign key attribute.
     *
     * @param    ChildCustomShippingZoneZip $l ChildCustomShippingZoneZip
     * @return   \CustomShippingZone\Model\CustomShippingZone The current object (for fluent API support)
     */
    public function addCustomShippingZoneZip(ChildCustomShippingZoneZip $l)
    {
        if ($this->collCustomShippingZoneZips === null) {
            $this->initCustomShippingZoneZips();
            $this->collCustomShippingZoneZipsPartial = true;
        }

        if (!in_array($l, $this->collCustomShippingZoneZips->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCustomShippingZoneZip($l);
        }

        return $this;
    }

    /**
     * @param CustomShippingZoneZip $customShippingZoneZip The customShippingZoneZip object to add.
     */
    protected function doAddCustomShippingZoneZip($customShippingZoneZip)
    {
        $this->collCustomShippingZoneZips[]= $customShippingZoneZip;
        $customShippingZoneZip->setCustomShippingZone($this);
    }

    /**
     * @param  CustomShippingZoneZip $customShippingZoneZip The customShippingZoneZip object to remove.
     * @return ChildCustomShippingZone The current object (for fluent API support)
     */
    public function removeCustomShippingZoneZip($customShippingZoneZip)
    {
        if ($this->getCustomShippingZoneZips()->contains($customShippingZoneZip)) {
            $this->collCustomShippingZoneZips->remove($this->collCustomShippingZoneZips->search($customShippingZoneZip));
            if (null === $this->customShippingZoneZipsScheduledForDeletion) {
                $this->customShippingZoneZipsScheduledForDeletion = clone $this->collCustomShippingZoneZips;
                $this->customShippingZoneZipsScheduledForDeletion->clear();
            }
            $this->customShippingZoneZipsScheduledForDeletion[]= clone $customShippingZoneZip;
            $customShippingZoneZip->setCustomShippingZone(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this CustomShippingZone is new, it will return
     * an empty collection; or if this CustomShippingZone has previously
     * been saved, it will retrieve related CustomShippingZoneZips from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in CustomShippingZone.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildCustomShippingZoneZip[] List of ChildCustomShippingZoneZip objects
     */
    public function getCustomShippingZoneZipsJoinCountry($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCustomShippingZoneZipQuery::create(null, $criteria);
        $query->joinWith('Country', $joinBehavior);

        return $this->getCustomShippingZoneZips($query, $con);
    }

    /**
     * Clears out the collCustomShippingZoneModuless collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCustomShippingZoneModuless()
     */
    public function clearCustomShippingZoneModuless()
    {
        $this->collCustomShippingZoneModuless = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCustomShippingZoneModuless collection loaded partially.
     */
    public function resetPartialCustomShippingZoneModuless($v = true)
    {
        $this->collCustomShippingZoneModulessPartial = $v;
    }

    /**
     * Initializes the collCustomShippingZoneModuless collection.
     *
     * By default this just sets the collCustomShippingZoneModuless collection to an empty array (like clearcollCustomShippingZoneModuless());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCustomShippingZoneModuless($overrideExisting = true)
    {
        if (null !== $this->collCustomShippingZoneModuless && !$overrideExisting) {
            return;
        }
        $this->collCustomShippingZoneModuless = new ObjectCollection();
        $this->collCustomShippingZoneModuless->setModel('\CustomShippingZone\Model\CustomShippingZoneModules');
    }

    /**
     * Gets an array of ChildCustomShippingZoneModules objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCustomShippingZone is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildCustomShippingZoneModules[] List of ChildCustomShippingZoneModules objects
     * @throws PropelException
     */
    public function getCustomShippingZoneModuless($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCustomShippingZoneModulessPartial && !$this->isNew();
        if (null === $this->collCustomShippingZoneModuless || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCustomShippingZoneModuless) {
                // return empty collection
                $this->initCustomShippingZoneModuless();
            } else {
                $collCustomShippingZoneModuless = ChildCustomShippingZoneModulesQuery::create(null, $criteria)
                    ->filterByCustomShippingZone($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCustomShippingZoneModulessPartial && count($collCustomShippingZoneModuless)) {
                        $this->initCustomShippingZoneModuless(false);

                        foreach ($collCustomShippingZoneModuless as $obj) {
                            if (false == $this->collCustomShippingZoneModuless->contains($obj)) {
                                $this->collCustomShippingZoneModuless->append($obj);
                            }
                        }

                        $this->collCustomShippingZoneModulessPartial = true;
                    }

                    reset($collCustomShippingZoneModuless);

                    return $collCustomShippingZoneModuless;
                }

                if ($partial && $this->collCustomShippingZoneModuless) {
                    foreach ($this->collCustomShippingZoneModuless as $obj) {
                        if ($obj->isNew()) {
                            $collCustomShippingZoneModuless[] = $obj;
                        }
                    }
                }

                $this->collCustomShippingZoneModuless = $collCustomShippingZoneModuless;
                $this->collCustomShippingZoneModulessPartial = false;
            }
        }

        return $this->collCustomShippingZoneModuless;
    }

    /**
     * Sets a collection of CustomShippingZoneModules objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $customShippingZoneModuless A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildCustomShippingZone The current object (for fluent API support)
     */
    public function setCustomShippingZoneModuless(Collection $customShippingZoneModuless, ConnectionInterface $con = null)
    {
        $customShippingZoneModulessToDelete = $this->getCustomShippingZoneModuless(new Criteria(), $con)->diff($customShippingZoneModuless);


        $this->customShippingZoneModulessScheduledForDeletion = $customShippingZoneModulessToDelete;

        foreach ($customShippingZoneModulessToDelete as $customShippingZoneModulesRemoved) {
            $customShippingZoneModulesRemoved->setCustomShippingZone(null);
        }

        $this->collCustomShippingZoneModuless = null;
        foreach ($customShippingZoneModuless as $customShippingZoneModules) {
            $this->addCustomShippingZoneModules($customShippingZoneModules);
        }

        $this->collCustomShippingZoneModuless = $customShippingZoneModuless;
        $this->collCustomShippingZoneModulessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CustomShippingZoneModules objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CustomShippingZoneModules objects.
     * @throws PropelException
     */
    public function countCustomShippingZoneModuless(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCustomShippingZoneModulessPartial && !$this->isNew();
        if (null === $this->collCustomShippingZoneModuless || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCustomShippingZoneModuless) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCustomShippingZoneModuless());
            }

            $query = ChildCustomShippingZoneModulesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCustomShippingZone($this)
                ->count($con);
        }

        return count($this->collCustomShippingZoneModuless);
    }

    /**
     * Method called to associate a ChildCustomShippingZoneModules object to this object
     * through the ChildCustomShippingZoneModules foreign key attribute.
     *
     * @param    ChildCustomShippingZoneModules $l ChildCustomShippingZoneModules
     * @return   \CustomShippingZone\Model\CustomShippingZone The current object (for fluent API support)
     */
    public function addCustomShippingZoneModules(ChildCustomShippingZoneModules $l)
    {
        if ($this->collCustomShippingZoneModuless === null) {
            $this->initCustomShippingZoneModuless();
            $this->collCustomShippingZoneModulessPartial = true;
        }

        if (!in_array($l, $this->collCustomShippingZoneModuless->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCustomShippingZoneModules($l);
        }

        return $this;
    }

    /**
     * @param CustomShippingZoneModules $customShippingZoneModules The customShippingZoneModules object to add.
     */
    protected function doAddCustomShippingZoneModules($customShippingZoneModules)
    {
        $this->collCustomShippingZoneModuless[]= $customShippingZoneModules;
        $customShippingZoneModules->setCustomShippingZone($this);
    }

    /**
     * @param  CustomShippingZoneModules $customShippingZoneModules The customShippingZoneModules object to remove.
     * @return ChildCustomShippingZone The current object (for fluent API support)
     */
    public function removeCustomShippingZoneModules($customShippingZoneModules)
    {
        if ($this->getCustomShippingZoneModuless()->contains($customShippingZoneModules)) {
            $this->collCustomShippingZoneModuless->remove($this->collCustomShippingZoneModuless->search($customShippingZoneModules));
            if (null === $this->customShippingZoneModulessScheduledForDeletion) {
                $this->customShippingZoneModulessScheduledForDeletion = clone $this->collCustomShippingZoneModuless;
                $this->customShippingZoneModulessScheduledForDeletion->clear();
            }
            $this->customShippingZoneModulessScheduledForDeletion[]= clone $customShippingZoneModules;
            $customShippingZoneModules->setCustomShippingZone(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this CustomShippingZone is new, it will return
     * an empty collection; or if this CustomShippingZone has previously
     * been saved, it will retrieve related CustomShippingZoneModuless from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in CustomShippingZone.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildCustomShippingZoneModules[] List of ChildCustomShippingZoneModules objects
     */
    public function getCustomShippingZoneModulessJoinModule($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCustomShippingZoneModulesQuery::create(null, $criteria);
        $query->joinWith('Module', $joinBehavior);

        return $this->getCustomShippingZoneModuless($query, $con);
    }

    /**
     * Clears out the collCustomShippingZoneI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCustomShippingZoneI18ns()
     */
    public function clearCustomShippingZoneI18ns()
    {
        $this->collCustomShippingZoneI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCustomShippingZoneI18ns collection loaded partially.
     */
    public function resetPartialCustomShippingZoneI18ns($v = true)
    {
        $this->collCustomShippingZoneI18nsPartial = $v;
    }

    /**
     * Initializes the collCustomShippingZoneI18ns collection.
     *
     * By default this just sets the collCustomShippingZoneI18ns collection to an empty array (like clearcollCustomShippingZoneI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCustomShippingZoneI18ns($overrideExisting = true)
    {
        if (null !== $this->collCustomShippingZoneI18ns && !$overrideExisting) {
            return;
        }
        $this->collCustomShippingZoneI18ns = new ObjectCollection();
        $this->collCustomShippingZoneI18ns->setModel('\CustomShippingZone\Model\CustomShippingZoneI18n');
    }

    /**
     * Gets an array of ChildCustomShippingZoneI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCustomShippingZone is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildCustomShippingZoneI18n[] List of ChildCustomShippingZoneI18n objects
     * @throws PropelException
     */
    public function getCustomShippingZoneI18ns($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCustomShippingZoneI18nsPartial && !$this->isNew();
        if (null === $this->collCustomShippingZoneI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCustomShippingZoneI18ns) {
                // return empty collection
                $this->initCustomShippingZoneI18ns();
            } else {
                $collCustomShippingZoneI18ns = ChildCustomShippingZoneI18nQuery::create(null, $criteria)
                    ->filterByCustomShippingZone($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCustomShippingZoneI18nsPartial && count($collCustomShippingZoneI18ns)) {
                        $this->initCustomShippingZoneI18ns(false);

                        foreach ($collCustomShippingZoneI18ns as $obj) {
                            if (false == $this->collCustomShippingZoneI18ns->contains($obj)) {
                                $this->collCustomShippingZoneI18ns->append($obj);
                            }
                        }

                        $this->collCustomShippingZoneI18nsPartial = true;
                    }

                    reset($collCustomShippingZoneI18ns);

                    return $collCustomShippingZoneI18ns;
                }

                if ($partial && $this->collCustomShippingZoneI18ns) {
                    foreach ($this->collCustomShippingZoneI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collCustomShippingZoneI18ns[] = $obj;
                        }
                    }
                }

                $this->collCustomShippingZoneI18ns = $collCustomShippingZoneI18ns;
                $this->collCustomShippingZoneI18nsPartial = false;
            }
        }

        return $this->collCustomShippingZoneI18ns;
    }

    /**
     * Sets a collection of CustomShippingZoneI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $customShippingZoneI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildCustomShippingZone The current object (for fluent API support)
     */
    public function setCustomShippingZoneI18ns(Collection $customShippingZoneI18ns, ConnectionInterface $con = null)
    {
        $customShippingZoneI18nsToDelete = $this->getCustomShippingZoneI18ns(new Criteria(), $con)->diff($customShippingZoneI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->customShippingZoneI18nsScheduledForDeletion = clone $customShippingZoneI18nsToDelete;

        foreach ($customShippingZoneI18nsToDelete as $customShippingZoneI18nRemoved) {
            $customShippingZoneI18nRemoved->setCustomShippingZone(null);
        }

        $this->collCustomShippingZoneI18ns = null;
        foreach ($customShippingZoneI18ns as $customShippingZoneI18n) {
            $this->addCustomShippingZoneI18n($customShippingZoneI18n);
        }

        $this->collCustomShippingZoneI18ns = $customShippingZoneI18ns;
        $this->collCustomShippingZoneI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CustomShippingZoneI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CustomShippingZoneI18n objects.
     * @throws PropelException
     */
    public function countCustomShippingZoneI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCustomShippingZoneI18nsPartial && !$this->isNew();
        if (null === $this->collCustomShippingZoneI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCustomShippingZoneI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCustomShippingZoneI18ns());
            }

            $query = ChildCustomShippingZoneI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCustomShippingZone($this)
                ->count($con);
        }

        return count($this->collCustomShippingZoneI18ns);
    }

    /**
     * Method called to associate a ChildCustomShippingZoneI18n object to this object
     * through the ChildCustomShippingZoneI18n foreign key attribute.
     *
     * @param    ChildCustomShippingZoneI18n $l ChildCustomShippingZoneI18n
     * @return   \CustomShippingZone\Model\CustomShippingZone The current object (for fluent API support)
     */
    public function addCustomShippingZoneI18n(ChildCustomShippingZoneI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collCustomShippingZoneI18ns === null) {
            $this->initCustomShippingZoneI18ns();
            $this->collCustomShippingZoneI18nsPartial = true;
        }

        if (!in_array($l, $this->collCustomShippingZoneI18ns->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCustomShippingZoneI18n($l);
        }

        return $this;
    }

    /**
     * @param CustomShippingZoneI18n $customShippingZoneI18n The customShippingZoneI18n object to add.
     */
    protected function doAddCustomShippingZoneI18n($customShippingZoneI18n)
    {
        $this->collCustomShippingZoneI18ns[]= $customShippingZoneI18n;
        $customShippingZoneI18n->setCustomShippingZone($this);
    }

    /**
     * @param  CustomShippingZoneI18n $customShippingZoneI18n The customShippingZoneI18n object to remove.
     * @return ChildCustomShippingZone The current object (for fluent API support)
     */
    public function removeCustomShippingZoneI18n($customShippingZoneI18n)
    {
        if ($this->getCustomShippingZoneI18ns()->contains($customShippingZoneI18n)) {
            $this->collCustomShippingZoneI18ns->remove($this->collCustomShippingZoneI18ns->search($customShippingZoneI18n));
            if (null === $this->customShippingZoneI18nsScheduledForDeletion) {
                $this->customShippingZoneI18nsScheduledForDeletion = clone $this->collCustomShippingZoneI18ns;
                $this->customShippingZoneI18nsScheduledForDeletion->clear();
            }
            $this->customShippingZoneI18nsScheduledForDeletion[]= clone $customShippingZoneI18n;
            $customShippingZoneI18n->setCustomShippingZone(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->tax = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collCustomShippingZoneZips) {
                foreach ($this->collCustomShippingZoneZips as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCustomShippingZoneModuless) {
                foreach ($this->collCustomShippingZoneModuless as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCustomShippingZoneI18ns) {
                foreach ($this->collCustomShippingZoneI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'en_US';
        $this->currentTranslations = null;

        $this->collCustomShippingZoneZips = null;
        $this->collCustomShippingZoneModuless = null;
        $this->collCustomShippingZoneI18ns = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CustomShippingZoneTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     ChildCustomShippingZone The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[CustomShippingZoneTableMap::UPDATED_AT] = true;

        return $this;
    }

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    ChildCustomShippingZone The current object (for fluent API support)
     */
    public function setLocale($locale = 'en_US')
    {
        $this->currentLocale = $locale;

        return $this;
    }

    /**
     * Gets the locale for translations
     *
     * @return    string $locale Locale to use for the translation, e.g. 'fr_FR'
     */
    public function getLocale()
    {
        return $this->currentLocale;
    }

    /**
     * Returns the current translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ChildCustomShippingZoneI18n */
    public function getTranslation($locale = 'en_US', ConnectionInterface $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collCustomShippingZoneI18ns) {
                foreach ($this->collCustomShippingZoneI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ChildCustomShippingZoneI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ChildCustomShippingZoneI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addCustomShippingZoneI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return    ChildCustomShippingZone The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'en_US', ConnectionInterface $con = null)
    {
        if (!$this->isNew()) {
            ChildCustomShippingZoneI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collCustomShippingZoneI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collCustomShippingZoneI18ns[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * Returns the current translation
     *
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ChildCustomShippingZoneI18n */
    public function getCurrentTranslation(ConnectionInterface $con = null)
    {
        return $this->getTranslation($this->getLocale(), $con);
    }


        /**
         * Get the [name] column value.
         *
         * @return   string
         */
        public function getName()
        {
        return $this->getCurrentTranslation()->getName();
    }


        /**
         * Set the value of [name] column.
         *
         * @param      string $v new value
         * @return   \CustomShippingZone\Model\CustomShippingZoneI18n The current object (for fluent API support)
         */
        public function setName($v)
        {    $this->getCurrentTranslation()->setName($v);

        return $this;
    }


        /**
         * Get the [description] column value.
         *
         * @return   string
         */
        public function getDescription()
        {
        return $this->getCurrentTranslation()->getDescription();
    }


        /**
         * Set the value of [description] column.
         *
         * @param      string $v new value
         * @return   \CustomShippingZone\Model\CustomShippingZoneI18n The current object (for fluent API support)
         */
        public function setDescription($v)
        {    $this->getCurrentTranslation()->setDescription($v);

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
