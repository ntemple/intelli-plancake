<?php

/**
 * Base class that represents a row from the 'pc_repetition' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BasePcRepetition extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PcRepetitionPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the human_expression field.
	 * @var        string
	 */
	protected $human_expression;

	/**
	 * The value for the computer_expression field.
	 * @var        string
	 */
	protected $computer_expression;

	/**
	 * The value for the initial_computer_expression field.
	 * @var        string
	 */
	protected $initial_computer_expression;

	/**
	 * The value for the special field.
	 * @var        string
	 */
	protected $special;

	/**
	 * The value for the needs_param field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $needs_param;

	/**
	 * The value for the is_param_cardinal field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_param_cardinal;

	/**
	 * The value for the min_param field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $min_param;

	/**
	 * The value for the max_param field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $max_param;

	/**
	 * The value for the sort_order field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $sort_order;

	/**
	 * The value for the has_divider_below field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $has_divider_below;

	/**
	 * The value for the ical_rrule field.
	 * @var        string
	 */
	protected $ical_rrule;

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
	 * @var        array PcTask[] Collection to store aggregation of PcTask objects.
	 */
	protected $collPcTasks;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcTasks.
	 */
	private $lastPcTaskCriteria = null;

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
	
	const PEER = 'PcRepetitionPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->needs_param = false;
		$this->is_param_cardinal = false;
		$this->min_param = 0;
		$this->max_param = 0;
		$this->sort_order = 0;
		$this->has_divider_below = false;
	}

	/**
	 * Initializes internal state of BasePcRepetition object.
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
	 * Get the [human_expression] column value.
	 * 
	 * @return     string
	 */
	public function getHumanExpression()
	{
		return $this->human_expression;
	}

	/**
	 * Get the [computer_expression] column value.
	 * a PHP strtostring compatible expression
	 * @return     string
	 */
	public function getComputerExpression()
	{
		return $this->computer_expression;
	}

	/**
	 * Get the [initial_computer_expression] column value.
	 * a PHP strtostring compatible expression
	 * @return     string
	 */
	public function getInitialComputerExpression()
	{
		return $this->initial_computer_expression;
	}

	/**
	 * Get the [special] column value.
	 * whether it is a special case, as for many weekdays
	 * @return     string
	 */
	public function getSpecial()
	{
		return $this->special;
	}

	/**
	 * Get the [needs_param] column value.
	 * whether the expression needs a numerical parameter
	 * @return     boolean
	 */
	public function getNeedsParam()
	{
		return $this->needs_param;
	}

	/**
	 * Get the [is_param_cardinal] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsParamCardinal()
	{
		return $this->is_param_cardinal;
	}

	/**
	 * Get the [min_param] column value.
	 * 
	 * @return     int
	 */
	public function getMinParam()
	{
		return $this->min_param;
	}

	/**
	 * Get the [max_param] column value.
	 * 
	 * @return     int
	 */
	public function getMaxParam()
	{
		return $this->max_param;
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
	 * Get the [has_divider_below] column value.
	 * says whether to add a divider below in a combo box
	 * @return     boolean
	 */
	public function getHasDividerBelow()
	{
		return $this->has_divider_below;
	}

	/**
	 * Get the [ical_rrule] column value.
	 * 
	 * @return     string
	 */
	public function getIcalRrule()
	{
		return $this->ical_rrule;
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
	 * @return     PcRepetition The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = PcRepetitionPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [human_expression] column.
	 * 
	 * @param      string $v new value
	 * @return     PcRepetition The current object (for fluent API support)
	 */
	public function setHumanExpression($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->human_expression !== $v) {
			$this->human_expression = $v;
			$this->modifiedColumns[] = PcRepetitionPeer::HUMAN_EXPRESSION;
		}

		return $this;
	} // setHumanExpression()

	/**
	 * Set the value of [computer_expression] column.
	 * a PHP strtostring compatible expression
	 * @param      string $v new value
	 * @return     PcRepetition The current object (for fluent API support)
	 */
	public function setComputerExpression($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->computer_expression !== $v) {
			$this->computer_expression = $v;
			$this->modifiedColumns[] = PcRepetitionPeer::COMPUTER_EXPRESSION;
		}

		return $this;
	} // setComputerExpression()

	/**
	 * Set the value of [initial_computer_expression] column.
	 * a PHP strtostring compatible expression
	 * @param      string $v new value
	 * @return     PcRepetition The current object (for fluent API support)
	 */
	public function setInitialComputerExpression($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->initial_computer_expression !== $v) {
			$this->initial_computer_expression = $v;
			$this->modifiedColumns[] = PcRepetitionPeer::INITIAL_COMPUTER_EXPRESSION;
		}

		return $this;
	} // setInitialComputerExpression()

	/**
	 * Set the value of [special] column.
	 * whether it is a special case, as for many weekdays
	 * @param      string $v new value
	 * @return     PcRepetition The current object (for fluent API support)
	 */
	public function setSpecial($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->special !== $v) {
			$this->special = $v;
			$this->modifiedColumns[] = PcRepetitionPeer::SPECIAL;
		}

		return $this;
	} // setSpecial()

	/**
	 * Set the value of [needs_param] column.
	 * whether the expression needs a numerical parameter
	 * @param      boolean $v new value
	 * @return     PcRepetition The current object (for fluent API support)
	 */
	public function setNeedsParam($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->needs_param !== $v || $this->isNew()) {
			$this->needs_param = $v;
			$this->modifiedColumns[] = PcRepetitionPeer::NEEDS_PARAM;
		}

		return $this;
	} // setNeedsParam()

	/**
	 * Set the value of [is_param_cardinal] column.
	 * 
	 * @param      boolean $v new value
	 * @return     PcRepetition The current object (for fluent API support)
	 */
	public function setIsParamCardinal($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_param_cardinal !== $v || $this->isNew()) {
			$this->is_param_cardinal = $v;
			$this->modifiedColumns[] = PcRepetitionPeer::IS_PARAM_CARDINAL;
		}

		return $this;
	} // setIsParamCardinal()

	/**
	 * Set the value of [min_param] column.
	 * 
	 * @param      int $v new value
	 * @return     PcRepetition The current object (for fluent API support)
	 */
	public function setMinParam($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->min_param !== $v || $this->isNew()) {
			$this->min_param = $v;
			$this->modifiedColumns[] = PcRepetitionPeer::MIN_PARAM;
		}

		return $this;
	} // setMinParam()

	/**
	 * Set the value of [max_param] column.
	 * 
	 * @param      int $v new value
	 * @return     PcRepetition The current object (for fluent API support)
	 */
	public function setMaxParam($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->max_param !== $v || $this->isNew()) {
			$this->max_param = $v;
			$this->modifiedColumns[] = PcRepetitionPeer::MAX_PARAM;
		}

		return $this;
	} // setMaxParam()

	/**
	 * Set the value of [sort_order] column.
	 * 
	 * @param      int $v new value
	 * @return     PcRepetition The current object (for fluent API support)
	 */
	public function setSortOrder($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->sort_order !== $v || $this->isNew()) {
			$this->sort_order = $v;
			$this->modifiedColumns[] = PcRepetitionPeer::SORT_ORDER;
		}

		return $this;
	} // setSortOrder()

	/**
	 * Set the value of [has_divider_below] column.
	 * says whether to add a divider below in a combo box
	 * @param      boolean $v new value
	 * @return     PcRepetition The current object (for fluent API support)
	 */
	public function setHasDividerBelow($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->has_divider_below !== $v || $this->isNew()) {
			$this->has_divider_below = $v;
			$this->modifiedColumns[] = PcRepetitionPeer::HAS_DIVIDER_BELOW;
		}

		return $this;
	} // setHasDividerBelow()

	/**
	 * Set the value of [ical_rrule] column.
	 * 
	 * @param      string $v new value
	 * @return     PcRepetition The current object (for fluent API support)
	 */
	public function setIcalRrule($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->ical_rrule !== $v) {
			$this->ical_rrule = $v;
			$this->modifiedColumns[] = PcRepetitionPeer::ICAL_RRULE;
		}

		return $this;
	} // setIcalRrule()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcRepetition The current object (for fluent API support)
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
				$this->modifiedColumns[] = PcRepetitionPeer::UPDATED_AT;
			}
		} // if either are not null

		return $this;
	} // setUpdatedAt()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcRepetition The current object (for fluent API support)
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
				$this->modifiedColumns[] = PcRepetitionPeer::CREATED_AT;
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
			if ($this->needs_param !== false) {
				return false;
			}

			if ($this->is_param_cardinal !== false) {
				return false;
			}

			if ($this->min_param !== 0) {
				return false;
			}

			if ($this->max_param !== 0) {
				return false;
			}

			if ($this->sort_order !== 0) {
				return false;
			}

			if ($this->has_divider_below !== false) {
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
			$this->human_expression = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->computer_expression = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->initial_computer_expression = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->special = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->needs_param = ($row[$startcol + 5] !== null) ? (boolean) $row[$startcol + 5] : null;
			$this->is_param_cardinal = ($row[$startcol + 6] !== null) ? (boolean) $row[$startcol + 6] : null;
			$this->min_param = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
			$this->max_param = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
			$this->sort_order = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
			$this->has_divider_below = ($row[$startcol + 10] !== null) ? (boolean) $row[$startcol + 10] : null;
			$this->ical_rrule = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
			$this->updated_at = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
			$this->created_at = ($row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 14; // 14 = PcRepetitionPeer::NUM_COLUMNS - PcRepetitionPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating PcRepetition object", $e);
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
			$con = Propel::getConnection(PcRepetitionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = PcRepetitionPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->collPcTasks = null;
			$this->lastPcTaskCriteria = null;

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
			$con = Propel::getConnection(PcRepetitionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcRepetition:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				PcRepetitionPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BasePcRepetition:delete:post') as $callable)
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
			$con = Propel::getConnection(PcRepetitionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcRepetition:save:pre') as $callable)
			{
			  if (is_integer($affectedRows = call_user_func($callable, $this, $con)))
			  {
			    $con->commit();
			
			    return $affectedRows;
			  }
			}

			// symfony_timestampable behavior
			if ($this->isModified() && !$this->isColumnModified(PcRepetitionPeer::UPDATED_AT))
			{
			  $this->setUpdatedAt(time());
			}

			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
				// symfony_timestampable behavior
				if (!$this->isColumnModified(PcRepetitionPeer::CREATED_AT))
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
				foreach (sfMixer::getCallables('BasePcRepetition:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				PcRepetitionPeer::addInstanceToPool($this);
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
					$pk = PcRepetitionPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += PcRepetitionPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collPcTasks !== null) {
				foreach ($this->collPcTasks as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
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


			if (($retval = PcRepetitionPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPcTasks !== null) {
					foreach ($this->collPcTasks as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
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
		$pos = PcRepetitionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getHumanExpression();
				break;
			case 2:
				return $this->getComputerExpression();
				break;
			case 3:
				return $this->getInitialComputerExpression();
				break;
			case 4:
				return $this->getSpecial();
				break;
			case 5:
				return $this->getNeedsParam();
				break;
			case 6:
				return $this->getIsParamCardinal();
				break;
			case 7:
				return $this->getMinParam();
				break;
			case 8:
				return $this->getMaxParam();
				break;
			case 9:
				return $this->getSortOrder();
				break;
			case 10:
				return $this->getHasDividerBelow();
				break;
			case 11:
				return $this->getIcalRrule();
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
		$keys = PcRepetitionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getHumanExpression(),
			$keys[2] => $this->getComputerExpression(),
			$keys[3] => $this->getInitialComputerExpression(),
			$keys[4] => $this->getSpecial(),
			$keys[5] => $this->getNeedsParam(),
			$keys[6] => $this->getIsParamCardinal(),
			$keys[7] => $this->getMinParam(),
			$keys[8] => $this->getMaxParam(),
			$keys[9] => $this->getSortOrder(),
			$keys[10] => $this->getHasDividerBelow(),
			$keys[11] => $this->getIcalRrule(),
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
		$pos = PcRepetitionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setHumanExpression($value);
				break;
			case 2:
				$this->setComputerExpression($value);
				break;
			case 3:
				$this->setInitialComputerExpression($value);
				break;
			case 4:
				$this->setSpecial($value);
				break;
			case 5:
				$this->setNeedsParam($value);
				break;
			case 6:
				$this->setIsParamCardinal($value);
				break;
			case 7:
				$this->setMinParam($value);
				break;
			case 8:
				$this->setMaxParam($value);
				break;
			case 9:
				$this->setSortOrder($value);
				break;
			case 10:
				$this->setHasDividerBelow($value);
				break;
			case 11:
				$this->setIcalRrule($value);
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
		$keys = PcRepetitionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setHumanExpression($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setComputerExpression($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setInitialComputerExpression($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setSpecial($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setNeedsParam($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setIsParamCardinal($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setMinParam($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setMaxParam($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setSortOrder($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setHasDividerBelow($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setIcalRrule($arr[$keys[11]]);
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
		$criteria = new Criteria(PcRepetitionPeer::DATABASE_NAME);

		if ($this->isColumnModified(PcRepetitionPeer::ID)) $criteria->add(PcRepetitionPeer::ID, $this->id);
		if ($this->isColumnModified(PcRepetitionPeer::HUMAN_EXPRESSION)) $criteria->add(PcRepetitionPeer::HUMAN_EXPRESSION, $this->human_expression);
		if ($this->isColumnModified(PcRepetitionPeer::COMPUTER_EXPRESSION)) $criteria->add(PcRepetitionPeer::COMPUTER_EXPRESSION, $this->computer_expression);
		if ($this->isColumnModified(PcRepetitionPeer::INITIAL_COMPUTER_EXPRESSION)) $criteria->add(PcRepetitionPeer::INITIAL_COMPUTER_EXPRESSION, $this->initial_computer_expression);
		if ($this->isColumnModified(PcRepetitionPeer::SPECIAL)) $criteria->add(PcRepetitionPeer::SPECIAL, $this->special);
		if ($this->isColumnModified(PcRepetitionPeer::NEEDS_PARAM)) $criteria->add(PcRepetitionPeer::NEEDS_PARAM, $this->needs_param);
		if ($this->isColumnModified(PcRepetitionPeer::IS_PARAM_CARDINAL)) $criteria->add(PcRepetitionPeer::IS_PARAM_CARDINAL, $this->is_param_cardinal);
		if ($this->isColumnModified(PcRepetitionPeer::MIN_PARAM)) $criteria->add(PcRepetitionPeer::MIN_PARAM, $this->min_param);
		if ($this->isColumnModified(PcRepetitionPeer::MAX_PARAM)) $criteria->add(PcRepetitionPeer::MAX_PARAM, $this->max_param);
		if ($this->isColumnModified(PcRepetitionPeer::SORT_ORDER)) $criteria->add(PcRepetitionPeer::SORT_ORDER, $this->sort_order);
		if ($this->isColumnModified(PcRepetitionPeer::HAS_DIVIDER_BELOW)) $criteria->add(PcRepetitionPeer::HAS_DIVIDER_BELOW, $this->has_divider_below);
		if ($this->isColumnModified(PcRepetitionPeer::ICAL_RRULE)) $criteria->add(PcRepetitionPeer::ICAL_RRULE, $this->ical_rrule);
		if ($this->isColumnModified(PcRepetitionPeer::UPDATED_AT)) $criteria->add(PcRepetitionPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(PcRepetitionPeer::CREATED_AT)) $criteria->add(PcRepetitionPeer::CREATED_AT, $this->created_at);

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
		$criteria = new Criteria(PcRepetitionPeer::DATABASE_NAME);

		$criteria->add(PcRepetitionPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of PcRepetition (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setId($this->id);

		$copyObj->setHumanExpression($this->human_expression);

		$copyObj->setComputerExpression($this->computer_expression);

		$copyObj->setInitialComputerExpression($this->initial_computer_expression);

		$copyObj->setSpecial($this->special);

		$copyObj->setNeedsParam($this->needs_param);

		$copyObj->setIsParamCardinal($this->is_param_cardinal);

		$copyObj->setMinParam($this->min_param);

		$copyObj->setMaxParam($this->max_param);

		$copyObj->setSortOrder($this->sort_order);

		$copyObj->setHasDividerBelow($this->has_divider_below);

		$copyObj->setIcalRrule($this->ical_rrule);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setCreatedAt($this->created_at);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getPcTasks() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcTask($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)


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
	 * @return     PcRepetition Clone of current object.
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
	 * @return     PcRepetitionPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PcRepetitionPeer();
		}
		return self::$peer;
	}

	/**
	 * Clears out the collPcTasks collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcTasks()
	 */
	public function clearPcTasks()
	{
		$this->collPcTasks = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcTasks collection (array).
	 *
	 * By default this just sets the collPcTasks collection to an empty array (like clearcollPcTasks());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcTasks()
	{
		$this->collPcTasks = array();
	}

	/**
	 * Gets an array of PcTask objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcRepetition has previously been saved, it will retrieve
	 * related PcTasks from storage. If this PcRepetition is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcTask[]
	 * @throws     PropelException
	 */
	public function getPcTasks($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcRepetitionPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcTasks === null) {
			if ($this->isNew()) {
			   $this->collPcTasks = array();
			} else {

				$criteria->add(PcTaskPeer::REPETITION_ID, $this->id);

				PcTaskPeer::addSelectColumns($criteria);
				$this->collPcTasks = PcTaskPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcTaskPeer::REPETITION_ID, $this->id);

				PcTaskPeer::addSelectColumns($criteria);
				if (!isset($this->lastPcTaskCriteria) || !$this->lastPcTaskCriteria->equals($criteria)) {
					$this->collPcTasks = PcTaskPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcTaskCriteria = $criteria;
		return $this->collPcTasks;
	}

	/**
	 * Returns the number of related PcTask objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcTask objects.
	 * @throws     PropelException
	 */
	public function countPcTasks(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcRepetitionPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcTasks === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcTaskPeer::REPETITION_ID, $this->id);

				$count = PcTaskPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcTaskPeer::REPETITION_ID, $this->id);

				if (!isset($this->lastPcTaskCriteria) || !$this->lastPcTaskCriteria->equals($criteria)) {
					$count = PcTaskPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcTasks);
				}
			} else {
				$count = count($this->collPcTasks);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcTask object to this object
	 * through the PcTask foreign key attribute.
	 *
	 * @param      PcTask $l PcTask
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcTask(PcTask $l)
	{
		if ($this->collPcTasks === null) {
			$this->initPcTasks();
		}
		if (!in_array($l, $this->collPcTasks, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcTasks, $l);
			$l->setPcRepetition($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PcRepetition is new, it will return
	 * an empty collection; or if this PcRepetition has previously
	 * been saved, it will retrieve related PcTasks from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PcRepetition.
	 */
	public function getPcTasksJoinPcList($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcRepetitionPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcTasks === null) {
			if ($this->isNew()) {
				$this->collPcTasks = array();
			} else {

				$criteria->add(PcTaskPeer::REPETITION_ID, $this->id);

				$this->collPcTasks = PcTaskPeer::doSelectJoinPcList($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PcTaskPeer::REPETITION_ID, $this->id);

			if (!isset($this->lastPcTaskCriteria) || !$this->lastPcTaskCriteria->equals($criteria)) {
				$this->collPcTasks = PcTaskPeer::doSelectJoinPcList($criteria, $con, $join_behavior);
			}
		}
		$this->lastPcTaskCriteria = $criteria;

		return $this->collPcTasks;
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
			if ($this->collPcTasks) {
				foreach ((array) $this->collPcTasks as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collPcTasks = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BasePcRepetition:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BasePcRepetition::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BasePcRepetition
