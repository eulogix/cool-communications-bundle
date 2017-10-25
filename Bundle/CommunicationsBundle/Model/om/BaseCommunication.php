<?php

namespace Eulogix\Cool\Bundle\CommunicationsBundle\Model\om;

use \BasePeer;
use \Criteria;
use \DateTime;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelDateTime;
use \PropelException;
use \PropelPDO;
use Eulogix\Cool\Bundle\CommunicationsBundle\Model\Communication;
use Eulogix\Cool\Bundle\CommunicationsBundle\Model\CommunicationPeer;
use Eulogix\Cool\Bundle\CommunicationsBundle\Model\CommunicationQuery;
use Eulogix\Cool\Bundle\CoreBundle\Model\Core\Account;
use Eulogix\Cool\Bundle\CoreBundle\Model\Core\AccountQuery;
use Eulogix\Cool\Lib\Cool;
use Eulogix\Cool\Lib\Database\Propel\CoolPropelObject;

abstract class BaseCommunication extends CoolPropelObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Eulogix\\Cool\\Bundle\\CommunicationsBundle\\Model\\CommunicationPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        CommunicationPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the communication_id field.
     * @var        int
     */
    protected $communication_id;

    /**
     * The value for the category field.
     * @var        string
     */
    protected $category;

    /**
     * The value for the type field.
     * @var        string
     */
    protected $type;

    /**
     * The value for the subject field.
     * @var        string
     */
    protected $subject;

    /**
     * The value for the body field.
     * @var        string
     */
    protected $body;

    /**
     * The value for the sent_date field.
     * @var        string
     */
    protected $sent_date;

    /**
     * The value for the received_date field.
     * @var        string
     */
    protected $received_date;

    /**
     * The value for the transmission_method field.
     * @var        string
     */
    protected $transmission_method;

    /**
     * The value for the target field.
     * @var        string
     */
    protected $target;

    /**
     * The value for the inbound_flag field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $inbound_flag;

    /**
     * The value for the ext field.
     * @var        string
     */
    protected $ext;

    /**
     * The value for the creation_date field.
     * @var        string
     */
    protected $creation_date;

    /**
     * The value for the update_date field.
     * @var        string
     */
    protected $update_date;

    /**
     * The value for the creation_user_id field.
     * @var        int
     */
    protected $creation_user_id;

    /**
     * The value for the update_user_id field.
     * @var        int
     */
    protected $update_user_id;

    /**
     * The value for the record_version field.
     * @var        int
     */
    protected $record_version;

    /**
     * @var        Account
     */
    protected $aAccountRelatedByCreationUserId;

    /**
     * @var        Account
     */
    protected $aAccountRelatedByUpdateUserId;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->inbound_flag = false;
    }

    /**
     * Initializes internal state of BaseCommunication object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [communication_id] column value.
     *
     * @return int
     */
    public function getCommunicationId()
    {

        return $this->communication_id;
    }

    /**
     * Get the [category] column value.
     *
     * @return string
     */
    public function getCategory()
    {

        return $this->category;
    }

    /**
     * Get the [type] column value.
     *
     * @return string
     */
    public function getType()
    {

        return $this->type;
    }

    /**
     * Get the [subject] column value.
     *
     * @return string
     */
    public function getSubject()
    {

        return $this->subject;
    }

    /**
     * Get the [body] column value.
     *
     * @return string
     */
    public function getBody()
    {

        return $this->body;
    }

    /**
     * Get the [optionally formatted] temporal [sent_date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getSentDate($format = null)
    {
        if ($this->sent_date === null) {
            return null;
        }


        try {
            $dt = new DateTime($this->sent_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->sent_date, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [received_date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getReceivedDate($format = null)
    {
        if ($this->received_date === null) {
            return null;
        }


        try {
            $dt = new DateTime($this->received_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->received_date, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [transmission_method] column value.
     * communication logs such as emails, phonecalls, log their nature here
     * @return string
     */
    public function getTransmissionMethod()
    {

        return $this->transmission_method;
    }

    /**
     * Get the [target] column value.
     * phonecalls / faxes and the like store here the number called, or the caller
     * @return string
     */
    public function getTarget()
    {

        return $this->target;
    }

    /**
     * Get the [inbound_flag] column value.
     *
     * @return boolean
     */
    public function getInboundFlag()
    {

        return $this->inbound_flag;
    }

    /**
     * Get the [ext] column value.
     *
     * @return string
     */
    public function getExt()
    {

        return $this->ext;
    }

    /**
     * Get the [optionally formatted] temporal [creation_date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreationDate($format = null)
    {
        if ($this->creation_date === null) {
            return null;
        }


        try {
            $dt = new DateTime($this->creation_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->creation_date, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [update_date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdateDate($format = null)
    {
        if ($this->update_date === null) {
            return null;
        }


        try {
            $dt = new DateTime($this->update_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->update_date, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [creation_user_id] column value.
     *
     * @return int
     */
    public function getCreationUserId()
    {

        return $this->creation_user_id;
    }

    /**
     * Get the [update_user_id] column value.
     *
     * @return int
     */
    public function getUpdateUserId()
    {

        return $this->update_user_id;
    }

    /**
     * Get the [record_version] column value.
     *
     * @return int
     */
    public function getRecordVersion()
    {

        return $this->record_version;
    }

    /**
     * Set the value of [communication_id] column.
     *
     * @param  int $v new value
     * @return Communication The current object (for fluent API support)
     */
    public function setCommunicationId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->communication_id !== $v) {
            $this->communication_id = $v;
            $this->modifiedColumns[] = CommunicationPeer::COMMUNICATION_ID;
        }


        return $this;
    } // setCommunicationId()

    /**
     * Set the value of [category] column.
     *
     * @param  string $v new value
     * @return Communication The current object (for fluent API support)
     */
    public function setCategory($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->category !== $v) {
            $this->category = $v;
            $this->modifiedColumns[] = CommunicationPeer::CATEGORY;
        }


        return $this;
    } // setCategory()

    /**
     * Set the value of [type] column.
     *
     * @param  string $v new value
     * @return Communication The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[] = CommunicationPeer::TYPE;
        }


        return $this;
    } // setType()

    /**
     * Set the value of [subject] column.
     *
     * @param  string $v new value
     * @return Communication The current object (for fluent API support)
     */
    public function setSubject($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->subject !== $v) {
            $this->subject = $v;
            $this->modifiedColumns[] = CommunicationPeer::SUBJECT;
        }


        return $this;
    } // setSubject()

    /**
     * Set the value of [body] column.
     *
     * @param  string $v new value
     * @return Communication The current object (for fluent API support)
     */
    public function setBody($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->body !== $v) {
            $this->body = $v;
            $this->modifiedColumns[] = CommunicationPeer::BODY;
        }


        return $this;
    } // setBody()

    /**
     * Sets the value of [sent_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Communication The current object (for fluent API support)
     */
    public function setSentDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->sent_date !== null || $dt !== null) {
            $currentDateAsString = ($this->sent_date !== null && $tmpDt = new DateTime($this->sent_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->sent_date = $newDateAsString;
                $this->modifiedColumns[] = CommunicationPeer::SENT_DATE;
            }
        } // if either are not null


        return $this;
    } // setSentDate()

    /**
     * Sets the value of [received_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Communication The current object (for fluent API support)
     */
    public function setReceivedDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->received_date !== null || $dt !== null) {
            $currentDateAsString = ($this->received_date !== null && $tmpDt = new DateTime($this->received_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->received_date = $newDateAsString;
                $this->modifiedColumns[] = CommunicationPeer::RECEIVED_DATE;
            }
        } // if either are not null


        return $this;
    } // setReceivedDate()

    /**
     * Set the value of [transmission_method] column.
     * communication logs such as emails, phonecalls, log their nature here
     * @param  string $v new value
     * @return Communication The current object (for fluent API support)
     */
    public function setTransmissionMethod($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->transmission_method !== $v) {
            $this->transmission_method = $v;
            $this->modifiedColumns[] = CommunicationPeer::TRANSMISSION_METHOD;
        }


        return $this;
    } // setTransmissionMethod()

    /**
     * Set the value of [target] column.
     * phonecalls / faxes and the like store here the number called, or the caller
     * @param  string $v new value
     * @return Communication The current object (for fluent API support)
     */
    public function setTarget($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->target !== $v) {
            $this->target = $v;
            $this->modifiedColumns[] = CommunicationPeer::TARGET;
        }


        return $this;
    } // setTarget()

    /**
     * Sets the value of the [inbound_flag] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Communication The current object (for fluent API support)
     */
    public function setInboundFlag($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->inbound_flag !== $v) {
            $this->inbound_flag = $v;
            $this->modifiedColumns[] = CommunicationPeer::INBOUND_FLAG;
        }


        return $this;
    } // setInboundFlag()

    /**
     * Set the value of [ext] column.
     *
     * @param  string $v new value
     * @return Communication The current object (for fluent API support)
     */
    public function setExt($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ext !== $v) {
            $this->ext = $v;
            $this->modifiedColumns[] = CommunicationPeer::EXT;
        }


        return $this;
    } // setExt()

    /**
     * Sets the value of [creation_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Communication The current object (for fluent API support)
     */
    public function setCreationDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->creation_date !== null || $dt !== null) {
            $currentDateAsString = ($this->creation_date !== null && $tmpDt = new DateTime($this->creation_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->creation_date = $newDateAsString;
                $this->modifiedColumns[] = CommunicationPeer::CREATION_DATE;
            }
        } // if either are not null


        return $this;
    } // setCreationDate()

    /**
     * Sets the value of [update_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Communication The current object (for fluent API support)
     */
    public function setUpdateDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->update_date !== null || $dt !== null) {
            $currentDateAsString = ($this->update_date !== null && $tmpDt = new DateTime($this->update_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->update_date = $newDateAsString;
                $this->modifiedColumns[] = CommunicationPeer::UPDATE_DATE;
            }
        } // if either are not null


        return $this;
    } // setUpdateDate()

    /**
     * Set the value of [creation_user_id] column.
     *
     * @param  int $v new value
     * @return Communication The current object (for fluent API support)
     */
    public function setCreationUserId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->creation_user_id !== $v) {
            $this->creation_user_id = $v;
            $this->modifiedColumns[] = CommunicationPeer::CREATION_USER_ID;
        }

        if ($this->aAccountRelatedByCreationUserId !== null && $this->aAccountRelatedByCreationUserId->getAccountId() !== $v) {
            $this->aAccountRelatedByCreationUserId = null;
        }


        return $this;
    } // setCreationUserId()

    /**
     * Set the value of [update_user_id] column.
     *
     * @param  int $v new value
     * @return Communication The current object (for fluent API support)
     */
    public function setUpdateUserId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->update_user_id !== $v) {
            $this->update_user_id = $v;
            $this->modifiedColumns[] = CommunicationPeer::UPDATE_USER_ID;
        }

        if ($this->aAccountRelatedByUpdateUserId !== null && $this->aAccountRelatedByUpdateUserId->getAccountId() !== $v) {
            $this->aAccountRelatedByUpdateUserId = null;
        }


        return $this;
    } // setUpdateUserId()

    /**
     * Set the value of [record_version] column.
     *
     * @param  int $v new value
     * @return Communication The current object (for fluent API support)
     */
    public function setRecordVersion($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->record_version !== $v) {
            $this->record_version = $v;
            $this->modifiedColumns[] = CommunicationPeer::RECORD_VERSION;
        }


        return $this;
    } // setRecordVersion()

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
            if ($this->inbound_flag !== false) {
                return false;
            }

        // otherwise, everything was equal, so return true
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
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->communication_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->category = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->type = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->subject = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->body = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->sent_date = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->received_date = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->transmission_method = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->target = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->inbound_flag = ($row[$startcol + 9] !== null) ? (boolean) $row[$startcol + 9] : null;
            $this->ext = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
            $this->creation_date = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
            $this->update_date = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
            $this->creation_user_id = ($row[$startcol + 13] !== null) ? (int) $row[$startcol + 13] : null;
            $this->update_user_id = ($row[$startcol + 14] !== null) ? (int) $row[$startcol + 14] : null;
            $this->record_version = ($row[$startcol + 15] !== null) ? (int) $row[$startcol + 15] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 16; // 16 = CommunicationPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Communication object", $e);
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

        if ($this->aAccountRelatedByCreationUserId !== null && $this->creation_user_id !== $this->aAccountRelatedByCreationUserId->getAccountId()) {
            $this->aAccountRelatedByCreationUserId = null;
        }
        if ($this->aAccountRelatedByUpdateUserId !== null && $this->update_user_id !== $this->aAccountRelatedByUpdateUserId->getAccountId()) {
            $this->aAccountRelatedByUpdateUserId = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CommunicationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = CommunicationPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAccountRelatedByCreationUserId = null;
            $this->aAccountRelatedByUpdateUserId = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CommunicationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = CommunicationQuery::create()
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
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CommunicationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                CommunicationPeer::addInstanceToPool($this);
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
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aAccountRelatedByCreationUserId !== null) {
                if ($this->aAccountRelatedByCreationUserId->isModified() || $this->aAccountRelatedByCreationUserId->isNew()) {
                    $affectedRows += $this->aAccountRelatedByCreationUserId->save($con);
                }
                $this->setAccountRelatedByCreationUserId($this->aAccountRelatedByCreationUserId);
            }

            if ($this->aAccountRelatedByUpdateUserId !== null) {
                if ($this->aAccountRelatedByUpdateUserId->isModified() || $this->aAccountRelatedByUpdateUserId->isNew()) {
                    $affectedRows += $this->aAccountRelatedByUpdateUserId->save($con);
                }
                $this->setAccountRelatedByUpdateUserId($this->aAccountRelatedByUpdateUserId);
            }

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

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = CommunicationPeer::COMMUNICATION_ID;
        if (null !== $this->communication_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CommunicationPeer::COMMUNICATION_ID . ')');
        }
        if (null === $this->communication_id) {
            try {
                $stmt = $con->query("SELECT nextval('communication_communication_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->communication_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CommunicationPeer::COMMUNICATION_ID)) {
            $modifiedColumns[':p' . $index++]  = 'communication_id';
        }
        if ($this->isColumnModified(CommunicationPeer::CATEGORY)) {
            $modifiedColumns[':p' . $index++]  = 'category';
        }
        if ($this->isColumnModified(CommunicationPeer::TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'type';
        }
        if ($this->isColumnModified(CommunicationPeer::SUBJECT)) {
            $modifiedColumns[':p' . $index++]  = 'subject';
        }
        if ($this->isColumnModified(CommunicationPeer::BODY)) {
            $modifiedColumns[':p' . $index++]  = 'body';
        }
        if ($this->isColumnModified(CommunicationPeer::SENT_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'sent_date';
        }
        if ($this->isColumnModified(CommunicationPeer::RECEIVED_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'received_date';
        }
        if ($this->isColumnModified(CommunicationPeer::TRANSMISSION_METHOD)) {
            $modifiedColumns[':p' . $index++]  = 'transmission_method';
        }
        if ($this->isColumnModified(CommunicationPeer::TARGET)) {
            $modifiedColumns[':p' . $index++]  = 'target';
        }
        if ($this->isColumnModified(CommunicationPeer::INBOUND_FLAG)) {
            $modifiedColumns[':p' . $index++]  = 'inbound_flag';
        }
        if ($this->isColumnModified(CommunicationPeer::EXT)) {
            $modifiedColumns[':p' . $index++]  = 'ext';
        }
        if ($this->isColumnModified(CommunicationPeer::CREATION_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'creation_date';
        }
        if ($this->isColumnModified(CommunicationPeer::UPDATE_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'update_date';
        }
        if ($this->isColumnModified(CommunicationPeer::CREATION_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'creation_user_id';
        }
        if ($this->isColumnModified(CommunicationPeer::UPDATE_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'update_user_id';
        }
        if ($this->isColumnModified(CommunicationPeer::RECORD_VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'record_version';
        }

        $sql = sprintf(
            'INSERT INTO communication (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'communication_id':
                        $stmt->bindValue($identifier, $this->communication_id, PDO::PARAM_INT);
                        break;
                    case 'category':
                        $stmt->bindValue($identifier, $this->category, PDO::PARAM_STR);
                        break;
                    case 'type':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_STR);
                        break;
                    case 'subject':
                        $stmt->bindValue($identifier, $this->subject, PDO::PARAM_STR);
                        break;
                    case 'body':
                        $stmt->bindValue($identifier, $this->body, PDO::PARAM_STR);
                        break;
                    case 'sent_date':
                        $stmt->bindValue($identifier, $this->sent_date, PDO::PARAM_STR);
                        break;
                    case 'received_date':
                        $stmt->bindValue($identifier, $this->received_date, PDO::PARAM_STR);
                        break;
                    case 'transmission_method':
                        $stmt->bindValue($identifier, $this->transmission_method, PDO::PARAM_STR);
                        break;
                    case 'target':
                        $stmt->bindValue($identifier, $this->target, PDO::PARAM_STR);
                        break;
                    case 'inbound_flag':
                        $stmt->bindValue($identifier, $this->inbound_flag, PDO::PARAM_BOOL);
                        break;
                    case 'ext':
                        $stmt->bindValue($identifier, $this->ext, PDO::PARAM_STR);
                        break;
                    case 'creation_date':
                        $stmt->bindValue($identifier, $this->creation_date, PDO::PARAM_STR);
                        break;
                    case 'update_date':
                        $stmt->bindValue($identifier, $this->update_date, PDO::PARAM_STR);
                        break;
                    case 'creation_user_id':
                        $stmt->bindValue($identifier, $this->creation_user_id, PDO::PARAM_INT);
                        break;
                    case 'update_user_id':
                        $stmt->bindValue($identifier, $this->update_user_id, PDO::PARAM_INT);
                        break;
                    case 'record_version':
                        $stmt->bindValue($identifier, $this->record_version, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggregated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objects otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            // We call the validate method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aAccountRelatedByCreationUserId !== null) {
                if (!$this->aAccountRelatedByCreationUserId->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAccountRelatedByCreationUserId->getValidationFailures());
                }
            }

            if ($this->aAccountRelatedByUpdateUserId !== null) {
                if (!$this->aAccountRelatedByUpdateUserId->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAccountRelatedByUpdateUserId->getValidationFailures());
                }
            }


            if (($retval = CommunicationPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }



            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = CommunicationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getCommunicationId();
                break;
            case 1:
                return $this->getCategory();
                break;
            case 2:
                return $this->getType();
                break;
            case 3:
                return $this->getSubject();
                break;
            case 4:
                return $this->getBody();
                break;
            case 5:
                return $this->getSentDate();
                break;
            case 6:
                return $this->getReceivedDate();
                break;
            case 7:
                return $this->getTransmissionMethod();
                break;
            case 8:
                return $this->getTarget();
                break;
            case 9:
                return $this->getInboundFlag();
                break;
            case 10:
                return $this->getExt();
                break;
            case 11:
                return $this->getCreationDate();
                break;
            case 12:
                return $this->getUpdateDate();
                break;
            case 13:
                return $this->getCreationUserId();
                break;
            case 14:
                return $this->getUpdateUserId();
                break;
            case 15:
                return $this->getRecordVersion();
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
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Communication'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Communication'][$this->getPrimaryKey()] = true;
        $keys = CommunicationPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getCommunicationId(),
            $keys[1] => $this->getCategory(),
            $keys[2] => $this->getType(),
            $keys[3] => $this->getSubject(),
            $keys[4] => $this->getBody(),
            $keys[5] => $this->getSentDate(),
            $keys[6] => $this->getReceivedDate(),
            $keys[7] => $this->getTransmissionMethod(),
            $keys[8] => $this->getTarget(),
            $keys[9] => $this->getInboundFlag(),
            $keys[10] => $this->getExt(),
            $keys[11] => $this->getCreationDate(),
            $keys[12] => $this->getUpdateDate(),
            $keys[13] => $this->getCreationUserId(),
            $keys[14] => $this->getUpdateUserId(),
            $keys[15] => $this->getRecordVersion(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAccountRelatedByCreationUserId) {
                $result['AccountRelatedByCreationUserId'] = $this->aAccountRelatedByCreationUserId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAccountRelatedByUpdateUserId) {
                $result['AccountRelatedByUpdateUserId'] = $this->aAccountRelatedByUpdateUserId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = CommunicationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setCommunicationId($value);
                break;
            case 1:
                $this->setCategory($value);
                break;
            case 2:
                $this->setType($value);
                break;
            case 3:
                $this->setSubject($value);
                break;
            case 4:
                $this->setBody($value);
                break;
            case 5:
                $this->setSentDate($value);
                break;
            case 6:
                $this->setReceivedDate($value);
                break;
            case 7:
                $this->setTransmissionMethod($value);
                break;
            case 8:
                $this->setTarget($value);
                break;
            case 9:
                $this->setInboundFlag($value);
                break;
            case 10:
                $this->setExt($value);
                break;
            case 11:
                $this->setCreationDate($value);
                break;
            case 12:
                $this->setUpdateDate($value);
                break;
            case 13:
                $this->setCreationUserId($value);
                break;
            case 14:
                $this->setUpdateUserId($value);
                break;
            case 15:
                $this->setRecordVersion($value);
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
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = CommunicationPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setCommunicationId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setCategory($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setType($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setSubject($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setBody($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setSentDate($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setReceivedDate($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setTransmissionMethod($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setTarget($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setInboundFlag($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setExt($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setCreationDate($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setUpdateDate($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setCreationUserId($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setUpdateUserId($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setRecordVersion($arr[$keys[15]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CommunicationPeer::DATABASE_NAME);

        if ($this->isColumnModified(CommunicationPeer::COMMUNICATION_ID)) $criteria->add(CommunicationPeer::COMMUNICATION_ID, $this->communication_id);
        if ($this->isColumnModified(CommunicationPeer::CATEGORY)) $criteria->add(CommunicationPeer::CATEGORY, $this->category);
        if ($this->isColumnModified(CommunicationPeer::TYPE)) $criteria->add(CommunicationPeer::TYPE, $this->type);
        if ($this->isColumnModified(CommunicationPeer::SUBJECT)) $criteria->add(CommunicationPeer::SUBJECT, $this->subject);
        if ($this->isColumnModified(CommunicationPeer::BODY)) $criteria->add(CommunicationPeer::BODY, $this->body);
        if ($this->isColumnModified(CommunicationPeer::SENT_DATE)) $criteria->add(CommunicationPeer::SENT_DATE, $this->sent_date);
        if ($this->isColumnModified(CommunicationPeer::RECEIVED_DATE)) $criteria->add(CommunicationPeer::RECEIVED_DATE, $this->received_date);
        if ($this->isColumnModified(CommunicationPeer::TRANSMISSION_METHOD)) $criteria->add(CommunicationPeer::TRANSMISSION_METHOD, $this->transmission_method);
        if ($this->isColumnModified(CommunicationPeer::TARGET)) $criteria->add(CommunicationPeer::TARGET, $this->target);
        if ($this->isColumnModified(CommunicationPeer::INBOUND_FLAG)) $criteria->add(CommunicationPeer::INBOUND_FLAG, $this->inbound_flag);
        if ($this->isColumnModified(CommunicationPeer::EXT)) $criteria->add(CommunicationPeer::EXT, $this->ext);
        if ($this->isColumnModified(CommunicationPeer::CREATION_DATE)) $criteria->add(CommunicationPeer::CREATION_DATE, $this->creation_date);
        if ($this->isColumnModified(CommunicationPeer::UPDATE_DATE)) $criteria->add(CommunicationPeer::UPDATE_DATE, $this->update_date);
        if ($this->isColumnModified(CommunicationPeer::CREATION_USER_ID)) $criteria->add(CommunicationPeer::CREATION_USER_ID, $this->creation_user_id);
        if ($this->isColumnModified(CommunicationPeer::UPDATE_USER_ID)) $criteria->add(CommunicationPeer::UPDATE_USER_ID, $this->update_user_id);
        if ($this->isColumnModified(CommunicationPeer::RECORD_VERSION)) $criteria->add(CommunicationPeer::RECORD_VERSION, $this->record_version);

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
        $criteria = new Criteria(CommunicationPeer::DATABASE_NAME);
        $criteria->add(CommunicationPeer::COMMUNICATION_ID, $this->communication_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getCommunicationId();
    }

    /**
     * Generic method to set the primary key (communication_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setCommunicationId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getCommunicationId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Communication (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCategory($this->getCategory());
        $copyObj->setType($this->getType());
        $copyObj->setSubject($this->getSubject());
        $copyObj->setBody($this->getBody());
        $copyObj->setSentDate($this->getSentDate());
        $copyObj->setReceivedDate($this->getReceivedDate());
        $copyObj->setTransmissionMethod($this->getTransmissionMethod());
        $copyObj->setTarget($this->getTarget());
        $copyObj->setInboundFlag($this->getInboundFlag());
        $copyObj->setExt($this->getExt());
        $copyObj->setCreationDate($this->getCreationDate());
        $copyObj->setUpdateDate($this->getUpdateDate());
        $copyObj->setCreationUserId($this->getCreationUserId());
        $copyObj->setUpdateUserId($this->getUpdateUserId());
        $copyObj->setRecordVersion($this->getRecordVersion());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setCommunicationId(NULL); // this is a auto-increment column, so set to default value
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
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return Communication Clone of current object.
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
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return CommunicationPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new CommunicationPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Account object.
     *
     * @param                  Account $v
     * @return Communication The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAccountRelatedByCreationUserId(Account $v = null)
    {
        if ($v === null) {
            $this->setCreationUserId(NULL);
        } else {
            $this->setCreationUserId($v->getAccountId());
        }

        $this->aAccountRelatedByCreationUserId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Account object, it will not be re-added.
        if ($v !== null) {
            $v->addCommunicationRelatedByCreationUserId($this);
        }


        return $this;
    }


    /**
     * Get the associated Account object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Account The associated Account object.
     * @throws PropelException
     */
    public function getAccountRelatedByCreationUserId(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAccountRelatedByCreationUserId === null && ($this->creation_user_id !== null) && $doQuery) {
            $this->aAccountRelatedByCreationUserId = AccountQuery::create()->findPk($this->creation_user_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAccountRelatedByCreationUserId->addCommunicationsRelatedByCreationUserId($this);
             */
        }

        return $this->aAccountRelatedByCreationUserId;
    }

    /**
     * Declares an association between this object and a Account object.
     *
     * @param                  Account $v
     * @return Communication The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAccountRelatedByUpdateUserId(Account $v = null)
    {
        if ($v === null) {
            $this->setUpdateUserId(NULL);
        } else {
            $this->setUpdateUserId($v->getAccountId());
        }

        $this->aAccountRelatedByUpdateUserId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Account object, it will not be re-added.
        if ($v !== null) {
            $v->addCommunicationRelatedByUpdateUserId($this);
        }


        return $this;
    }


    /**
     * Get the associated Account object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Account The associated Account object.
     * @throws PropelException
     */
    public function getAccountRelatedByUpdateUserId(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAccountRelatedByUpdateUserId === null && ($this->update_user_id !== null) && $doQuery) {
            $this->aAccountRelatedByUpdateUserId = AccountQuery::create()->findPk($this->update_user_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAccountRelatedByUpdateUserId->addCommunicationsRelatedByUpdateUserId($this);
             */
        }

        return $this->aAccountRelatedByUpdateUserId;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->communication_id = null;
        $this->category = null;
        $this->type = null;
        $this->subject = null;
        $this->body = null;
        $this->sent_date = null;
        $this->received_date = null;
        $this->transmission_method = null;
        $this->target = null;
        $this->inbound_flag = null;
        $this->ext = null;
        $this->creation_date = null;
        $this->update_date = null;
        $this->creation_user_id = null;
        $this->update_user_id = null;
        $this->record_version = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
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
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->aAccountRelatedByCreationUserId instanceof Persistent) {
              $this->aAccountRelatedByCreationUserId->clearAllReferences($deep);
            }
            if ($this->aAccountRelatedByUpdateUserId instanceof Persistent) {
              $this->aAccountRelatedByUpdateUserId->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aAccountRelatedByCreationUserId = null;
        $this->aAccountRelatedByUpdateUserId = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CommunicationPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

}
