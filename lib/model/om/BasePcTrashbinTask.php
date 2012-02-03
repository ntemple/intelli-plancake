<?php

/**
 * Base class that represents a row from the 'pc_trashbin_task' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BasePcTrashbinTask extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PcTrashbinTaskPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the list_id field.
	 * @var        int
	 */
	protected $list_id;

	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;

	/**
	 * The value for the sort_order field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $sort_order;

	/**
	 * The value for the due_date field.
	 * @var        string
	 */
	protected $due_date;

	/**
	 * The value for the repetition_id field.
	 * @var        int
	 */
	protected $repetition_id;

	/**
	 * The value for the repetition_param field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $repetition_param;

	/**
	 * The value for the is_completed field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_completed;

	/**
	 * The value for the is_header field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_header;

	/**
	 * The value for the is_from_system field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_from_system;

	/**
	 * The value for the note field.
	 * @var        string
	 */
	protected $note;

	/**
	 * The value for the contexts field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $contexts;

	/**
	 * The value for the contact_id field.
	 * @var        int
	 */
	protected $contact_id;

	/**
	 * The value for the completed_at field.
	 * @var        string
	 */
	protected $completed_at;

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
	 * The value for the deleted_at field.
	 * @var        int
	 */
	protected $deleted_at;

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
	
	const PEER = 'PcTrashbinTaskPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->sort_order = 0;
		$this->repetition_param = 0;
		$this->is_completed = false;
		$this->is_header = false;
		$this->is_from_system = false;
		$this->contexts = '';
	}

	/**
	 * Initializes internal state of BasePcTrashbinTask object.
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
	 * Get the [list_id] column value.
	 * 
	 * @return     int
	 */
	public function getListId()
	{
		return $this->list_id;
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
	 * Get the [sort_order] column value.
	 * 
	 * @return     int
	 */
	public function getSortOrder()
	{
		return $this->sort_order;
	}

	/**
	 * Get the [optionally formatted] temporal [due_date] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getDueDate($format = 'Y-m-d')
	{
		if ($this->due_date === null) {
			return null;
		}


		if ($this->due_date === '0000-00-00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->due_date);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->due_date, true), $x);
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
	 * Get the [repetition_id] column value.
	 * 
	 * @return     int
	 */
	public function getRepetitionId()
	{
		return $this->repetition_id;
	}

	/**
	 * Get the [repetition_param] column value.
	 * 
	 * @return     int
	 */
	public function getRepetitionParam()
	{
		return $this->repetition_param;
	}

	/**
	 * Get the [is_completed] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsCompleted()
	{
		return $this->is_completed;
	}

	/**
	 * Get the [is_header] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsHeader()
	{
		return $this->is_header;
	}

	/**
	 * Get the [is_from_system] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsFromSystem()
	{
		return $this->is_from_system;
	}

	/**
	 * Get the [note] column value.
	 * 
	 * @return     string
	 */
	public function getNote()
	{
		return $this->note;
	}

	/**
	 * Get the [contexts] column value.
	 * it is a comma separated list
	 * @return     string
	 */
	public function getContexts()
	{
		return $this->contexts;
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
	 * Get the [optionally formatted] temporal [completed_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getCompletedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->completed_at === null) {
			return null;
		}


		if ($this->completed_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->completed_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->completed_at, true), $x);
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
	 * Get the [deleted_at] column value.
	 * 
	 * @return     int
	 */
	public function getDeletedAt()
	{
		return $this->deleted_at;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcTrashbinTask The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = PcTrashbinTaskPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [list_id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcTrashbinTask The current object (for fluent API support)
	 */
	public function setListId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->list_id !== $v) {
			$this->list_id = $v;
			$this->modifiedColumns[] = PcTrashbinTaskPeer::LIST_ID;
		}

		return $this;
	} // setListId()

	/**
	 * Set the value of [description] column.
	 * 
	 * @param      string $v new value
	 * @return     PcTrashbinTask The current object (for fluent API support)
	 */
	public function setDescription($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = PcTrashbinTaskPeer::DESCRIPTION;
		}

		return $this;
	} // setDescription()

	/**
	 * Set the value of [sort_order] column.
	 * 
	 * @param      int $v new value
	 * @return     PcTrashbinTask The current object (for fluent API support)
	 */
	public function setSortOrder($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->sort_order !== $v || $this->isNew()) {
			$this->sort_order = $v;
			$this->modifiedColumns[] = PcTrashbinTaskPeer::SORT_ORDER;
		}

		return $this;
	} // setSortOrder()

	/**
	 * Sets the value of [due_date] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcTrashbinTask The current object (for fluent API support)
	 */
	public function setDueDate($v)
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

		if ( $this->due_date !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->due_date !== null && $tmpDt = new DateTime($this->due_date)) ? $tmpDt->format('Y-m-d') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->due_date = ($dt ? $dt->format('Y-m-d') : null);
				$this->modifiedColumns[] = PcTrashbinTaskPeer::DUE_DATE;
			}
		} // if either are not null

		return $this;
	} // setDueDate()

	/**
	 * Set the value of [repetition_id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcTrashbinTask The current object (for fluent API support)
	 */
	public function setRepetitionId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->repetition_id !== $v) {
			$this->repetition_id = $v;
			$this->modifiedColumns[] = PcTrashbinTaskPeer::REPETITION_ID;
		}

		return $this;
	} // setRepetitionId()

	/**
	 * Set the value of [repetition_param] column.
	 * 
	 * @param      int $v new value
	 * @return     PcTrashbinTask The current object (for fluent API support)
	 */
	public function setRepetitionParam($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->repetition_param !== $v || $this->isNew()) {
			$this->repetition_param = $v;
			$this->modifiedColumns[] = PcTrashbinTaskPeer::REPETITION_PARAM;
		}

		return $this;
	} // setRepetitionParam()

	/**
	 * Set the value of [is_completed] column.
	 * 
	 * @param      boolean $v new value
	 * @return     PcTrashbinTask The current object (for fluent API support)
	 */
	public function setIsCompleted($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_completed !== $v || $this->isNew()) {
			$this->is_completed = $v;
			$this->modifiedColumns[] = PcTrashbinTaskPeer::IS_COMPLETED;
		}

		return $this;
	} // setIsCompleted()

	/**
	 * Set the value of [is_header] column.
	 * 
	 * @param      boolean $v new value
	 * @return     PcTrashbinTask The current object (for fluent API support)
	 */
	public function setIsHeader($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_header !== $v || $this->isNew()) {
			$this->is_header = $v;
			$this->modifiedColumns[] = PcTrashbinTaskPeer::IS_HEADER;
		}

		return $this;
	} // setIsHeader()

	/**
	 * Set the value of [is_from_system] column.
	 * 
	 * @param      boolean $v new value
	 * @return     PcTrashbinTask The current object (for fluent API support)
	 */
	public function setIsFromSystem($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_from_system !== $v || $this->isNew()) {
			$this->is_from_system = $v;
			$this->modifiedColumns[] = PcTrashbinTaskPeer::IS_FROM_SYSTEM;
		}

		return $this;
	} // setIsFromSystem()

	/**
	 * Set the value of [note] column.
	 * 
	 * @param      string $v new value
	 * @return     PcTrashbinTask The current object (for fluent API support)
	 */
	public function setNote($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->note !== $v) {
			$this->note = $v;
			$this->modifiedColumns[] = PcTrashbinTaskPeer::NOTE;
		}

		return $this;
	} // setNote()

	/**
	 * Set the value of [contexts] column.
	 * it is a comma separated list
	 * @param      string $v new value
	 * @return     PcTrashbinTask The current object (for fluent API support)
	 */
	public function setContexts($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->contexts !== $v || $this->isNew()) {
			$this->contexts = $v;
			$this->modifiedColumns[] = PcTrashbinTaskPeer::CONTEXTS;
		}

		return $this;
	} // setContexts()

	/**
	 * Set the value of [contact_id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcTrashbinTask The current object (for fluent API support)
	 */
	public function setContactId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->contact_id !== $v) {
			$this->contact_id = $v;
			$this->modifiedColumns[] = PcTrashbinTaskPeer::CONTACT_ID;
		}

		return $this;
	} // setContactId()

	/**
	 * Sets the value of [completed_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcTrashbinTask The current object (for fluent API support)
	 */
	public function setCompletedAt($v)
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

		if ( $this->completed_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->completed_at !== null && $tmpDt = new DateTime($this->completed_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->completed_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = PcTrashbinTaskPeer::COMPLETED_AT;
			}
		} // if either are not null

		return $this;
	} // setCompletedAt()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcTrashbinTask The current object (for fluent API support)
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
				$this->modifiedColumns[] = PcTrashbinTaskPeer::UPDATED_AT;
			}
		} // if either are not null

		return $this;
	} // setUpdatedAt()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcTrashbinTask The current object (for fluent API support)
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
				$this->modifiedColumns[] = PcTrashbinTaskPeer::CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setCreatedAt()

	/**
	 * Set the value of [deleted_at] column.
	 * 
	 * @param      int $v new value
	 * @return     PcTrashbinTask The current object (for fluent API support)
	 */
	public function setDeletedAt($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->deleted_at !== $v) {
			$this->deleted_at = $v;
			$this->modifiedColumns[] = PcTrashbinTaskPeer::DELETED_AT;
		}

		return $this;
	} // setDeletedAt()

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
			if ($this->sort_order !== 0) {
				return false;
			}

			if ($this->repetition_param !== 0) {
				return false;
			}

			if ($this->is_completed !== false) {
				return false;
			}

			if ($this->is_header !== false) {
				return false;
			}

			if ($this->is_from_system !== false) {
				return false;
			}

			if ($this->contexts !== '') {
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
			$this->list_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->description = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->sort_order = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->due_date = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->repetition_id = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
			$this->repetition_param = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
			$this->is_completed = ($row[$startcol + 7] !== null) ? (boolean) $row[$startcol + 7] : null;
			$this->is_header = ($row[$startcol + 8] !== null) ? (boolean) $row[$startcol + 8] : null;
			$this->is_from_system = ($row[$startcol + 9] !== null) ? (boolean) $row[$startcol + 9] : null;
			$this->note = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
			$this->contexts = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
			$this->contact_id = ($row[$startcol + 12] !== null) ? (int) $row[$startcol + 12] : null;
			$this->completed_at = ($row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
			$this->updated_at = ($row[$startcol + 14] !== null) ? (string) $row[$startcol + 14] : null;
			$this->created_at = ($row[$startcol + 15] !== null) ? (string) $row[$startcol + 15] : null;
			$this->deleted_at = ($row[$startcol + 16] !== null) ? (int) $row[$startcol + 16] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 17; // 17 = PcTrashbinTaskPeer::NUM_COLUMNS - PcTrashbinTaskPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating PcTrashbinTask object", $e);
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
			$con = Propel::getConnection(PcTrashbinTaskPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = PcTrashbinTaskPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

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
			$con = Propel::getConnection(PcTrashbinTaskPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcTrashbinTask:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				PcTrashbinTaskPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BasePcTrashbinTask:delete:post') as $callable)
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
			$con = Propel::getConnection(PcTrashbinTaskPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcTrashbinTask:save:pre') as $callable)
			{
			  if (is_integer($affectedRows = call_user_func($callable, $this, $con)))
			  {
			    $con->commit();
			
			    return $affectedRows;
			  }
			}

			// symfony_timestampable behavior
			if ($this->isModified() && !$this->isColumnModified(PcTrashbinTaskPeer::UPDATED_AT))
			{
			  $this->setUpdatedAt(time());
			}

			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
				// symfony_timestampable behavior
				if (!$this->isColumnModified(PcTrashbinTaskPeer::CREATED_AT))
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
				foreach (sfMixer::getCallables('BasePcTrashbinTask:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				PcTrashbinTaskPeer::addInstanceToPool($this);
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


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PcTrashbinTaskPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += PcTrashbinTaskPeer::doUpdate($this, $con);
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


			if (($retval = PcTrashbinTaskPeer::doValidate($this, $columns)) !== true) {
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
		$pos = PcTrashbinTaskPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getListId();
				break;
			case 2:
				return $this->getDescription();
				break;
			case 3:
				return $this->getSortOrder();
				break;
			case 4:
				return $this->getDueDate();
				break;
			case 5:
				return $this->getRepetitionId();
				break;
			case 6:
				return $this->getRepetitionParam();
				break;
			case 7:
				return $this->getIsCompleted();
				break;
			case 8:
				return $this->getIsHeader();
				break;
			case 9:
				return $this->getIsFromSystem();
				break;
			case 10:
				return $this->getNote();
				break;
			case 11:
				return $this->getContexts();
				break;
			case 12:
				return $this->getContactId();
				break;
			case 13:
				return $this->getCompletedAt();
				break;
			case 14:
				return $this->getUpdatedAt();
				break;
			case 15:
				return $this->getCreatedAt();
				break;
			case 16:
				return $this->getDeletedAt();
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
		$keys = PcTrashbinTaskPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getListId(),
			$keys[2] => $this->getDescription(),
			$keys[3] => $this->getSortOrder(),
			$keys[4] => $this->getDueDate(),
			$keys[5] => $this->getRepetitionId(),
			$keys[6] => $this->getRepetitionParam(),
			$keys[7] => $this->getIsCompleted(),
			$keys[8] => $this->getIsHeader(),
			$keys[9] => $this->getIsFromSystem(),
			$keys[10] => $this->getNote(),
			$keys[11] => $this->getContexts(),
			$keys[12] => $this->getContactId(),
			$keys[13] => $this->getCompletedAt(),
			$keys[14] => $this->getUpdatedAt(),
			$keys[15] => $this->getCreatedAt(),
			$keys[16] => $this->getDeletedAt(),
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
		$pos = PcTrashbinTaskPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setListId($value);
				break;
			case 2:
				$this->setDescription($value);
				break;
			case 3:
				$this->setSortOrder($value);
				break;
			case 4:
				$this->setDueDate($value);
				break;
			case 5:
				$this->setRepetitionId($value);
				break;
			case 6:
				$this->setRepetitionParam($value);
				break;
			case 7:
				$this->setIsCompleted($value);
				break;
			case 8:
				$this->setIsHeader($value);
				break;
			case 9:
				$this->setIsFromSystem($value);
				break;
			case 10:
				$this->setNote($value);
				break;
			case 11:
				$this->setContexts($value);
				break;
			case 12:
				$this->setContactId($value);
				break;
			case 13:
				$this->setCompletedAt($value);
				break;
			case 14:
				$this->setUpdatedAt($value);
				break;
			case 15:
				$this->setCreatedAt($value);
				break;
			case 16:
				$this->setDeletedAt($value);
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
		$keys = PcTrashbinTaskPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setListId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDescription($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSortOrder($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDueDate($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setRepetitionId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setRepetitionParam($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setIsCompleted($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setIsHeader($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setIsFromSystem($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setNote($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setContexts($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setContactId($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setCompletedAt($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setUpdatedAt($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setCreatedAt($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setDeletedAt($arr[$keys[16]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PcTrashbinTaskPeer::DATABASE_NAME);

		if ($this->isColumnModified(PcTrashbinTaskPeer::ID)) $criteria->add(PcTrashbinTaskPeer::ID, $this->id);
		if ($this->isColumnModified(PcTrashbinTaskPeer::LIST_ID)) $criteria->add(PcTrashbinTaskPeer::LIST_ID, $this->list_id);
		if ($this->isColumnModified(PcTrashbinTaskPeer::DESCRIPTION)) $criteria->add(PcTrashbinTaskPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(PcTrashbinTaskPeer::SORT_ORDER)) $criteria->add(PcTrashbinTaskPeer::SORT_ORDER, $this->sort_order);
		if ($this->isColumnModified(PcTrashbinTaskPeer::DUE_DATE)) $criteria->add(PcTrashbinTaskPeer::DUE_DATE, $this->due_date);
		if ($this->isColumnModified(PcTrashbinTaskPeer::REPETITION_ID)) $criteria->add(PcTrashbinTaskPeer::REPETITION_ID, $this->repetition_id);
		if ($this->isColumnModified(PcTrashbinTaskPeer::REPETITION_PARAM)) $criteria->add(PcTrashbinTaskPeer::REPETITION_PARAM, $this->repetition_param);
		if ($this->isColumnModified(PcTrashbinTaskPeer::IS_COMPLETED)) $criteria->add(PcTrashbinTaskPeer::IS_COMPLETED, $this->is_completed);
		if ($this->isColumnModified(PcTrashbinTaskPeer::IS_HEADER)) $criteria->add(PcTrashbinTaskPeer::IS_HEADER, $this->is_header);
		if ($this->isColumnModified(PcTrashbinTaskPeer::IS_FROM_SYSTEM)) $criteria->add(PcTrashbinTaskPeer::IS_FROM_SYSTEM, $this->is_from_system);
		if ($this->isColumnModified(PcTrashbinTaskPeer::NOTE)) $criteria->add(PcTrashbinTaskPeer::NOTE, $this->note);
		if ($this->isColumnModified(PcTrashbinTaskPeer::CONTEXTS)) $criteria->add(PcTrashbinTaskPeer::CONTEXTS, $this->contexts);
		if ($this->isColumnModified(PcTrashbinTaskPeer::CONTACT_ID)) $criteria->add(PcTrashbinTaskPeer::CONTACT_ID, $this->contact_id);
		if ($this->isColumnModified(PcTrashbinTaskPeer::COMPLETED_AT)) $criteria->add(PcTrashbinTaskPeer::COMPLETED_AT, $this->completed_at);
		if ($this->isColumnModified(PcTrashbinTaskPeer::UPDATED_AT)) $criteria->add(PcTrashbinTaskPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(PcTrashbinTaskPeer::CREATED_AT)) $criteria->add(PcTrashbinTaskPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(PcTrashbinTaskPeer::DELETED_AT)) $criteria->add(PcTrashbinTaskPeer::DELETED_AT, $this->deleted_at);

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
		$criteria = new Criteria(PcTrashbinTaskPeer::DATABASE_NAME);

		$criteria->add(PcTrashbinTaskPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of PcTrashbinTask (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setId($this->id);

		$copyObj->setListId($this->list_id);

		$copyObj->setDescription($this->description);

		$copyObj->setSortOrder($this->sort_order);

		$copyObj->setDueDate($this->due_date);

		$copyObj->setRepetitionId($this->repetition_id);

		$copyObj->setRepetitionParam($this->repetition_param);

		$copyObj->setIsCompleted($this->is_completed);

		$copyObj->setIsHeader($this->is_header);

		$copyObj->setIsFromSystem($this->is_from_system);

		$copyObj->setNote($this->note);

		$copyObj->setContexts($this->contexts);

		$copyObj->setContactId($this->contact_id);

		$copyObj->setCompletedAt($this->completed_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setDeletedAt($this->deleted_at);


		$copyObj->setNew(true);

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
	 * @return     PcTrashbinTask Clone of current object.
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
	 * @return     PcTrashbinTaskPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PcTrashbinTaskPeer();
		}
		return self::$peer;
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

	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BasePcTrashbinTask:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BasePcTrashbinTask::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BasePcTrashbinTask
