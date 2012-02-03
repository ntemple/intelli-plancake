<?php

/**
 * Base class that represents a row from the 'pc_bookkeeping_entry' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BasePcBookkeepingEntry extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PcBookkeepingEntryPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the type_id field.
	 * @var        int
	 */
	protected $type_id;

	/**
	 * The value for the contact_id field.
	 * @var        int
	 */
	protected $contact_id;

	/**
	 * The value for the amount field.
	 * @var        double
	 */
	protected $amount;

	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;

	/**
	 * The value for the date field.
	 * @var        string
	 */
	protected $date;

	/**
	 * The value for the vat field.
	 * @var        string
	 */
	protected $vat;

	/**
	 * The value for the category_id field.
	 * @var        int
	 */
	protected $category_id;

	/**
	 * The value for the payment_method_id field.
	 * @var        int
	 */
	protected $payment_method_id;

	/**
	 * The value for the ref_number field.
	 * @var        string
	 */
	protected $ref_number;

	/**
	 * The value for the needs_clarification field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $needs_clarification;

	/**
	 * The value for the question field.
	 * @var        string
	 */
	protected $question;

	/**
	 * The value for the updated_at field.
	 * @var        string
	 */
	protected $updated_at;

	/**
	 * The value for the created_at field.
	 * @var        string
	 */
	protected $created_at;

	/**
	 * @var        PcBookkeepingType
	 */
	protected $aPcBookkeepingType;

	/**
	 * @var        PcBookkeepingContact
	 */
	protected $aPcBookkeepingContact;

	/**
	 * @var        PcBookkeepingCategory
	 */
	protected $aPcBookkeepingCategory;

	/**
	 * @var        PcBookkeepingPaymentMethod
	 */
	protected $aPcBookkeepingPaymentMethod;

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

	// symfony behavior
	
	const PEER = 'PcBookkeepingEntryPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->needs_clarification = false;
	}

	/**
	 * Initializes internal state of BasePcBookkeepingEntry object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Get the [id] column value.
	 * 
	 * @return     int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get the [type_id] column value.
	 * 
	 * @return     int
	 */
	public function getTypeId()
	{
		return $this->type_id;
	}

	/**
	 * Get the [contact_id] column value.
	 * 
	 * @return     int
	 */
	public function getContactId()
	{
		return $this->contact_id;
	}

	/**
	 * Get the [amount] column value.
	 * 
	 * @return     double
	 */
	public function getAmount()
	{
		return $this->amount;
	}

	/**
	 * Get the [description] column value.
	 * 
	 * @return     string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Get the [optionally formatted] temporal [date] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getDate($format = 'Y-m-d')
	{
		if ($this->date === null) {
			return null;
		}


		if ($this->date === '0000-00-00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->date);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->date, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [vat] column value.
	 * 
	 * @return     string
	 */
	public function getVat()
	{
		return $this->vat;
	}

	/**
	 * Get the [category_id] column value.
	 * 
	 * @return     int
	 */
	public function getCategoryId()
	{
		return $this->category_id;
	}

	/**
	 * Get the [payment_method_id] column value.
	 * 
	 * @return     int
	 */
	public function getPaymentMethodId()
	{
		return $this->payment_method_id;
	}

	/**
	 * Get the [ref_number] column value.
	 * 
	 * @return     string
	 */
	public function getRefNumber()
	{
		return $this->ref_number;
	}

	/**
	 * Get the [needs_clarification] column value.
	 * 
	 * @return     boolean
	 */
	public function getNeedsClarification()
	{
		return $this->needs_clarification;
	}

	/**
	 * Get the [question] column value.
	 * 
	 * @return     string
	 */
	public function getQuestion()
	{
		return $this->question;
	}

	/**
	 * Get the [optionally formatted] temporal [updated_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->updated_at === null) {
			return null;
		}


		if ($this->updated_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->updated_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->updated_at, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [optionally formatted] temporal [created_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->created_at === null) {
			return null;
		}


		if ($this->created_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->created_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcBookkeepingEntry The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = PcBookkeepingEntryPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [type_id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcBookkeepingEntry The current object (for fluent API support)
	 */
	public function setTypeId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->type_id !== $v) {
			$this->type_id = $v;
			$this->modifiedColumns[] = PcBookkeepingEntryPeer::TYPE_ID;
		}

		if ($this->aPcBookkeepingType !== null && $this->aPcBookkeepingType->getId() !== $v) {
			$this->aPcBookkeepingType = null;
		}

		return $this;
	} // setTypeId()

	/**
	 * Set the value of [contact_id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcBookkeepingEntry The current object (for fluent API support)
	 */
	public function setContactId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->contact_id !== $v) {
			$this->contact_id = $v;
			$this->modifiedColumns[] = PcBookkeepingEntryPeer::CONTACT_ID;
		}

		if ($this->aPcBookkeepingContact !== null && $this->aPcBookkeepingContact->getId() !== $v) {
			$this->aPcBookkeepingContact = null;
		}

		return $this;
	} // setContactId()

	/**
	 * Set the value of [amount] column.
	 * 
	 * @param      double $v new value
	 * @return     PcBookkeepingEntry The current object (for fluent API support)
	 */
	public function setAmount($v)
	{
		if ($v !== null) {
			$v = (double) $v;
		}

		if ($this->amount !== $v) {
			$this->amount = $v;
			$this->modifiedColumns[] = PcBookkeepingEntryPeer::AMOUNT;
		}

		return $this;
	} // setAmount()

	/**
	 * Set the value of [description] column.
	 * 
	 * @param      string $v new value
	 * @return     PcBookkeepingEntry The current object (for fluent API support)
	 */
	public function setDescription($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = PcBookkeepingEntryPeer::DESCRIPTION;
		}

		return $this;
	} // setDescription()

	/**
	 * Sets the value of [date] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcBookkeepingEntry The current object (for fluent API support)
	 */
	public function setDate($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->date !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->date !== null && $tmpDt = new DateTime($this->date)) ? $tmpDt->format('Y-m-d') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->date = ($dt ? $dt->format('Y-m-d') : null);
				$this->modifiedColumns[] = PcBookkeepingEntryPeer::DATE;
			}
		} // if either are not null

		return $this;
	} // setDate()

	/**
	 * Set the value of [vat] column.
	 * 
	 * @param      string $v new value
	 * @return     PcBookkeepingEntry The current object (for fluent API support)
	 */
	public function setVat($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->vat !== $v) {
			$this->vat = $v;
			$this->modifiedColumns[] = PcBookkeepingEntryPeer::VAT;
		}

		return $this;
	} // setVat()

	/**
	 * Set the value of [category_id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcBookkeepingEntry The current object (for fluent API support)
	 */
	public function setCategoryId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->category_id !== $v) {
			$this->category_id = $v;
			$this->modifiedColumns[] = PcBookkeepingEntryPeer::CATEGORY_ID;
		}

		if ($this->aPcBookkeepingCategory !== null && $this->aPcBookkeepingCategory->getId() !== $v) {
			$this->aPcBookkeepingCategory = null;
		}

		return $this;
	} // setCategoryId()

	/**
	 * Set the value of [payment_method_id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcBookkeepingEntry The current object (for fluent API support)
	 */
	public function setPaymentMethodId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->payment_method_id !== $v) {
			$this->payment_method_id = $v;
			$this->modifiedColumns[] = PcBookkeepingEntryPeer::PAYMENT_METHOD_ID;
		}

		if ($this->aPcBookkeepingPaymentMethod !== null && $this->aPcBookkeepingPaymentMethod->getId() !== $v) {
			$this->aPcBookkeepingPaymentMethod = null;
		}

		return $this;
	} // setPaymentMethodId()

	/**
	 * Set the value of [ref_number] column.
	 * 
	 * @param      string $v new value
	 * @return     PcBookkeepingEntry The current object (for fluent API support)
	 */
	public function setRefNumber($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->ref_number !== $v) {
			$this->ref_number = $v;
			$this->modifiedColumns[] = PcBookkeepingEntryPeer::REF_NUMBER;
		}

		return $this;
	} // setRefNumber()

	/**
	 * Set the value of [needs_clarification] column.
	 * 
	 * @param      boolean $v new value
	 * @return     PcBookkeepingEntry The current object (for fluent API support)
	 */
	public function setNeedsClarification($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->needs_clarification !== $v || $this->isNew()) {
			$this->needs_clarification = $v;
			$this->modifiedColumns[] = PcBookkeepingEntryPeer::NEEDS_CLARIFICATION;
		}

		return $this;
	} // setNeedsClarification()

	/**
	 * Set the value of [question] column.
	 * 
	 * @param      string $v new value
	 * @return     PcBookkeepingEntry The current object (for fluent API support)
	 */
	public function setQuestion($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->question !== $v) {
			$this->question = $v;
			$this->modifiedColumns[] = PcBookkeepingEntryPeer::QUESTION;
		}

		return $this;
	} // setQuestion()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcBookkeepingEntry The current object (for fluent API support)
	 */
	public function setUpdatedAt($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->updated_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->updated_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = PcBookkeepingEntryPeer::UPDATED_AT;
			}
		} // if either are not null

		return $this;
	} // setUpdatedAt()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcBookkeepingEntry The current object (for fluent API support)
	 */
	public function setCreatedAt($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->created_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->created_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = PcBookkeepingEntryPeer::CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setCreatedAt()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
			if ($this->needs_clarification !== false) {
				return false;
			}

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
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->type_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->contact_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->amount = ($row[$startcol + 3] !== null) ? (double) $row[$startcol + 3] : null;
			$this->description = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->date = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->vat = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->category_id = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
			$this->payment_method_id = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
			$this->ref_number = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
			$this->needs_clarification = ($row[$startcol + 10] !== null) ? (boolean) $row[$startcol + 10] : null;
			$this->question = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
			$this->updated_at = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
			$this->created_at = ($row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 14; // 14 = PcBookkeepingEntryPeer::NUM_COLUMNS - PcBookkeepingEntryPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating PcBookkeepingEntry object", $e);
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
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

		if ($this->aPcBookkeepingType !== null && $this->type_id !== $this->aPcBookkeepingType->getId()) {
			$this->aPcBookkeepingType = null;
		}
		if ($this->aPcBookkeepingContact !== null && $this->contact_id !== $this->aPcBookkeepingContact->getId()) {
			$this->aPcBookkeepingContact = null;
		}
		if ($this->aPcBookkeepingCategory !== null && $this->category_id !== $this->aPcBookkeepingCategory->getId()) {
			$this->aPcBookkeepingCategory = null;
		}
		if ($this->aPcBookkeepingPaymentMethod !== null && $this->payment_method_id !== $this->aPcBookkeepingPaymentMethod->getId()) {
			$this->aPcBookkeepingPaymentMethod = null;
		}
	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
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
			$con = Propel::getConnection(PcBookkeepingEntryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = PcBookkeepingEntryPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aPcBookkeepingType = null;
			$this->aPcBookkeepingContact = null;
			$this->aPcBookkeepingCategory = null;
			$this->aPcBookkeepingPaymentMethod = null;
		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(PcBookkeepingEntryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcBookkeepingEntry:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				PcBookkeepingEntryPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BasePcBookkeepingEntry:delete:post') as $callable)
				{
				  call_user_func($callable, $this, $con);
				}

				$this->setDeleted(true);
				$con->commit();
			} else {
				$con->commit();
			}
		} catch (PropelException $e) {
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
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(PcBookkeepingEntryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcBookkeepingEntry:save:pre') as $callable)
			{
			  if (is_integer($affectedRows = call_user_func($callable, $this, $con)))
			  {
			    $con->commit();
			
			    return $affectedRows;
			  }
			}

			// symfony_timestampable behavior
			if ($this->isModified() && !$this->isColumnModified(PcBookkeepingEntryPeer::UPDATED_AT))
			{
			  $this->setUpdatedAt(time());
			}

			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
				// symfony_timestampable behavior
				if (!$this->isColumnModified(PcBookkeepingEntryPeer::CREATED_AT))
				{
				  $this->setCreatedAt(time());
				}

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
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BasePcBookkeepingEntry:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				PcBookkeepingEntryPeer::addInstanceToPool($this);
			} else {
				$affectedRows = 0;
			}
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
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
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aPcBookkeepingType !== null) {
				if ($this->aPcBookkeepingType->isModified() || $this->aPcBookkeepingType->isNew()) {
					$affectedRows += $this->aPcBookkeepingType->save($con);
				}
				$this->setPcBookkeepingType($this->aPcBookkeepingType);
			}

			if ($this->aPcBookkeepingContact !== null) {
				if ($this->aPcBookkeepingContact->isModified() || $this->aPcBookkeepingContact->isNew()) {
					$affectedRows += $this->aPcBookkeepingContact->save($con);
				}
				$this->setPcBookkeepingContact($this->aPcBookkeepingContact);
			}

			if ($this->aPcBookkeepingCategory !== null) {
				if ($this->aPcBookkeepingCategory->isModified() || $this->aPcBookkeepingCategory->isNew()) {
					$affectedRows += $this->aPcBookkeepingCategory->save($con);
				}
				$this->setPcBookkeepingCategory($this->aPcBookkeepingCategory);
			}

			if ($this->aPcBookkeepingPaymentMethod !== null) {
				if ($this->aPcBookkeepingPaymentMethod->isModified() || $this->aPcBookkeepingPaymentMethod->isNew()) {
					$affectedRows += $this->aPcBookkeepingPaymentMethod->save($con);
				}
				$this->setPcBookkeepingPaymentMethod($this->aPcBookkeepingPaymentMethod);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = PcBookkeepingEntryPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PcBookkeepingEntryPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += PcBookkeepingEntryPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
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
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aPcBookkeepingType !== null) {
				if (!$this->aPcBookkeepingType->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPcBookkeepingType->getValidationFailures());
				}
			}

			if ($this->aPcBookkeepingContact !== null) {
				if (!$this->aPcBookkeepingContact->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPcBookkeepingContact->getValidationFailures());
				}
			}

			if ($this->aPcBookkeepingCategory !== null) {
				if (!$this->aPcBookkeepingCategory->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPcBookkeepingCategory->getValidationFailures());
				}
			}

			if ($this->aPcBookkeepingPaymentMethod !== null) {
				if (!$this->aPcBookkeepingPaymentMethod->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPcBookkeepingPaymentMethod->getValidationFailures());
				}
			}


			if (($retval = PcBookkeepingEntryPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = PcBookkeepingEntryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getTypeId();
				break;
			case 2:
				return $this->getContactId();
				break;
			case 3:
				return $this->getAmount();
				break;
			case 4:
				return $this->getDescription();
				break;
			case 5:
				return $this->getDate();
				break;
			case 6:
				return $this->getVat();
				break;
			case 7:
				return $this->getCategoryId();
				break;
			case 8:
				return $this->getPaymentMethodId();
				break;
			case 9:
				return $this->getRefNumber();
				break;
			case 10:
				return $this->getNeedsClarification();
				break;
			case 11:
				return $this->getQuestion();
				break;
			case 12:
				return $this->getUpdatedAt();
				break;
			case 13:
				return $this->getCreatedAt();
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
	 * @param      string $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                        BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. Defaults to BasePeer::TYPE_PHPNAME.
	 * @param      boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns.  Defaults to TRUE.
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = PcBookkeepingEntryPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getTypeId(),
			$keys[2] => $this->getContactId(),
			$keys[3] => $this->getAmount(),
			$keys[4] => $this->getDescription(),
			$keys[5] => $this->getDate(),
			$keys[6] => $this->getVat(),
			$keys[7] => $this->getCategoryId(),
			$keys[8] => $this->getPaymentMethodId(),
			$keys[9] => $this->getRefNumber(),
			$keys[10] => $this->getNeedsClarification(),
			$keys[11] => $this->getQuestion(),
			$keys[12] => $this->getUpdatedAt(),
			$keys[13] => $this->getCreatedAt(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = PcBookkeepingEntryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setTypeId($value);
				break;
			case 2:
				$this->setContactId($value);
				break;
			case 3:
				$this->setAmount($value);
				break;
			case 4:
				$this->setDescription($value);
				break;
			case 5:
				$this->setDate($value);
				break;
			case 6:
				$this->setVat($value);
				break;
			case 7:
				$this->setCategoryId($value);
				break;
			case 8:
				$this->setPaymentMethodId($value);
				break;
			case 9:
				$this->setRefNumber($value);
				break;
			case 10:
				$this->setNeedsClarification($value);
				break;
			case 11:
				$this->setQuestion($value);
				break;
			case 12:
				$this->setUpdatedAt($value);
				break;
			case 13:
				$this->setCreatedAt($value);
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
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = PcBookkeepingEntryPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTypeId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setContactId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setAmount($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDescription($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setDate($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setVat($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setCategoryId($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setPaymentMethodId($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setRefNumber($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setNeedsClarification($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setQuestion($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setUpdatedAt($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setCreatedAt($arr[$keys[13]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PcBookkeepingEntryPeer::DATABASE_NAME);

		if ($this->isColumnModified(PcBookkeepingEntryPeer::ID)) $criteria->add(PcBookkeepingEntryPeer::ID, $this->id);
		if ($this->isColumnModified(PcBookkeepingEntryPeer::TYPE_ID)) $criteria->add(PcBookkeepingEntryPeer::TYPE_ID, $this->type_id);
		if ($this->isColumnModified(PcBookkeepingEntryPeer::CONTACT_ID)) $criteria->add(PcBookkeepingEntryPeer::CONTACT_ID, $this->contact_id);
		if ($this->isColumnModified(PcBookkeepingEntryPeer::AMOUNT)) $criteria->add(PcBookkeepingEntryPeer::AMOUNT, $this->amount);
		if ($this->isColumnModified(PcBookkeepingEntryPeer::DESCRIPTION)) $criteria->add(PcBookkeepingEntryPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(PcBookkeepingEntryPeer::DATE)) $criteria->add(PcBookkeepingEntryPeer::DATE, $this->date);
		if ($this->isColumnModified(PcBookkeepingEntryPeer::VAT)) $criteria->add(PcBookkeepingEntryPeer::VAT, $this->vat);
		if ($this->isColumnModified(PcBookkeepingEntryPeer::CATEGORY_ID)) $criteria->add(PcBookkeepingEntryPeer::CATEGORY_ID, $this->category_id);
		if ($this->isColumnModified(PcBookkeepingEntryPeer::PAYMENT_METHOD_ID)) $criteria->add(PcBookkeepingEntryPeer::PAYMENT_METHOD_ID, $this->payment_method_id);
		if ($this->isColumnModified(PcBookkeepingEntryPeer::REF_NUMBER)) $criteria->add(PcBookkeepingEntryPeer::REF_NUMBER, $this->ref_number);
		if ($this->isColumnModified(PcBookkeepingEntryPeer::NEEDS_CLARIFICATION)) $criteria->add(PcBookkeepingEntryPeer::NEEDS_CLARIFICATION, $this->needs_clarification);
		if ($this->isColumnModified(PcBookkeepingEntryPeer::QUESTION)) $criteria->add(PcBookkeepingEntryPeer::QUESTION, $this->question);
		if ($this->isColumnModified(PcBookkeepingEntryPeer::UPDATED_AT)) $criteria->add(PcBookkeepingEntryPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(PcBookkeepingEntryPeer::CREATED_AT)) $criteria->add(PcBookkeepingEntryPeer::CREATED_AT, $this->created_at);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(PcBookkeepingEntryPeer::DATABASE_NAME);

		$criteria->add(PcBookkeepingEntryPeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of PcBookkeepingEntry (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setTypeId($this->type_id);

		$copyObj->setContactId($this->contact_id);

		$copyObj->setAmount($this->amount);

		$copyObj->setDescription($this->description);

		$copyObj->setDate($this->date);

		$copyObj->setVat($this->vat);

		$copyObj->setCategoryId($this->category_id);

		$copyObj->setPaymentMethodId($this->payment_method_id);

		$copyObj->setRefNumber($this->ref_number);

		$copyObj->setNeedsClarification($this->needs_clarification);

		$copyObj->setQuestion($this->question);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setCreatedAt($this->created_at);


		$copyObj->setNew(true);

		$copyObj->setId(NULL); // this is a auto-increment column, so set to default value

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
	 * @return     PcBookkeepingEntry Clone of current object.
	 * @throws     PropelException
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
	 * @return     PcBookkeepingEntryPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PcBookkeepingEntryPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a PcBookkeepingType object.
	 *
	 * @param      PcBookkeepingType $v
	 * @return     PcBookkeepingEntry The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPcBookkeepingType(PcBookkeepingType $v = null)
	{
		if ($v === null) {
			$this->setTypeId(NULL);
		} else {
			$this->setTypeId($v->getId());
		}

		$this->aPcBookkeepingType = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the PcBookkeepingType object, it will not be re-added.
		if ($v !== null) {
			$v->addPcBookkeepingEntry($this);
		}

		return $this;
	}


	/**
	 * Get the associated PcBookkeepingType object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     PcBookkeepingType The associated PcBookkeepingType object.
	 * @throws     PropelException
	 */
	public function getPcBookkeepingType(PropelPDO $con = null)
	{
		if ($this->aPcBookkeepingType === null && ($this->type_id !== null)) {
			$this->aPcBookkeepingType = PcBookkeepingTypePeer::retrieveByPk($this->type_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aPcBookkeepingType->addPcBookkeepingEntrys($this);
			 */
		}
		return $this->aPcBookkeepingType;
	}

	/**
	 * Declares an association between this object and a PcBookkeepingContact object.
	 *
	 * @param      PcBookkeepingContact $v
	 * @return     PcBookkeepingEntry The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPcBookkeepingContact(PcBookkeepingContact $v = null)
	{
		if ($v === null) {
			$this->setContactId(NULL);
		} else {
			$this->setContactId($v->getId());
		}

		$this->aPcBookkeepingContact = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the PcBookkeepingContact object, it will not be re-added.
		if ($v !== null) {
			$v->addPcBookkeepingEntry($this);
		}

		return $this;
	}


	/**
	 * Get the associated PcBookkeepingContact object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     PcBookkeepingContact The associated PcBookkeepingContact object.
	 * @throws     PropelException
	 */
	public function getPcBookkeepingContact(PropelPDO $con = null)
	{
		if ($this->aPcBookkeepingContact === null && ($this->contact_id !== null)) {
			$this->aPcBookkeepingContact = PcBookkeepingContactPeer::retrieveByPk($this->contact_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aPcBookkeepingContact->addPcBookkeepingEntrys($this);
			 */
		}
		return $this->aPcBookkeepingContact;
	}

	/**
	 * Declares an association between this object and a PcBookkeepingCategory object.
	 *
	 * @param      PcBookkeepingCategory $v
	 * @return     PcBookkeepingEntry The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPcBookkeepingCategory(PcBookkeepingCategory $v = null)
	{
		if ($v === null) {
			$this->setCategoryId(NULL);
		} else {
			$this->setCategoryId($v->getId());
		}

		$this->aPcBookkeepingCategory = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the PcBookkeepingCategory object, it will not be re-added.
		if ($v !== null) {
			$v->addPcBookkeepingEntry($this);
		}

		return $this;
	}


	/**
	 * Get the associated PcBookkeepingCategory object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     PcBookkeepingCategory The associated PcBookkeepingCategory object.
	 * @throws     PropelException
	 */
	public function getPcBookkeepingCategory(PropelPDO $con = null)
	{
		if ($this->aPcBookkeepingCategory === null && ($this->category_id !== null)) {
			$this->aPcBookkeepingCategory = PcBookkeepingCategoryPeer::retrieveByPk($this->category_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aPcBookkeepingCategory->addPcBookkeepingEntrys($this);
			 */
		}
		return $this->aPcBookkeepingCategory;
	}

	/**
	 * Declares an association between this object and a PcBookkeepingPaymentMethod object.
	 *
	 * @param      PcBookkeepingPaymentMethod $v
	 * @return     PcBookkeepingEntry The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPcBookkeepingPaymentMethod(PcBookkeepingPaymentMethod $v = null)
	{
		if ($v === null) {
			$this->setPaymentMethodId(NULL);
		} else {
			$this->setPaymentMethodId($v->getId());
		}

		$this->aPcBookkeepingPaymentMethod = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the PcBookkeepingPaymentMethod object, it will not be re-added.
		if ($v !== null) {
			$v->addPcBookkeepingEntry($this);
		}

		return $this;
	}


	/**
	 * Get the associated PcBookkeepingPaymentMethod object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     PcBookkeepingPaymentMethod The associated PcBookkeepingPaymentMethod object.
	 * @throws     PropelException
	 */
	public function getPcBookkeepingPaymentMethod(PropelPDO $con = null)
	{
		if ($this->aPcBookkeepingPaymentMethod === null && ($this->payment_method_id !== null)) {
			$this->aPcBookkeepingPaymentMethod = PcBookkeepingPaymentMethodPeer::retrieveByPk($this->payment_method_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aPcBookkeepingPaymentMethod->addPcBookkeepingEntrys($this);
			 */
		}
		return $this->aPcBookkeepingPaymentMethod;
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
		} // if ($deep)

			$this->aPcBookkeepingType = null;
			$this->aPcBookkeepingContact = null;
			$this->aPcBookkeepingCategory = null;
			$this->aPcBookkeepingPaymentMethod = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BasePcBookkeepingEntry:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BasePcBookkeepingEntry::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BasePcBookkeepingEntry
