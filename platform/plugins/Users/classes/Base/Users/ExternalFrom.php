<?php

/**
 * Autogenerated base class representing external_from rows
 * in the Users database.
 *
 * Don't change this file, since it can be overwritten.
 * Instead, change the Users_ExternalFrom.php file.
 *
 * @module Users
 */
/**
 * Base class representing 'ExternalFrom' rows in the 'Users' database
 * @class Base_Users_ExternalFrom
 * @extends Db_Row
 *
 * @param {array} [$fields=array()] The fields values to initialize table row as 
 * an associative array of $column => $value pairs
 * @param {string} [$fields.platform] defaults to ""
 * @param {string} [$fields.appId] defaults to ""
 * @param {string} [$fields.xid] defaults to ""
 * @param {string|Db_Expression} [$fields.insertedTime] defaults to new Db_Expression("CURRENT_TIMESTAMP")
 * @param {string|Db_Expression} [$fields.updatedTime] defaults to null
 * @param {string} [$fields.userId] defaults to ""
 * @param {string} [$fields.responseType] defaults to null
 * @param {string} [$fields.accessToken] defaults to null
 * @param {string|Db_Expression} [$fields.expires] defaults to null
 * @param {string} [$fields.extra] defaults to "{}"
 */
abstract class Base_Users_ExternalFrom extends Db_Row
{
	/**
	 * @property $platform
	 * @type string
	 * @default ""
	 * A platform like facebook or github or web
	 */
	/**
	 * @property $appId
	 * @type string
	 * @default ""
	 * An ID in the local/app.json config for the app
	 */
	/**
	 * @property $xid
	 * @type string
	 * @default ""
	 * The user's external id
	 */
	/**
	 * @property $insertedTime
	 * @type string|Db_Expression
	 * @default new Db_Expression("CURRENT_TIMESTAMP")
	 * 
	 */
	/**
	 * @property $updatedTime
	 * @type string|Db_Expression
	 * @default null
	 * 
	 */
	/**
	 * @property $userId
	 * @type string
	 * @default ""
	 * The native user id in our platform
	 */
	/**
	 * @property $responseType
	 * @type string
	 * @default null
	 * The type of oAuth 2 response
	 */
	/**
	 * @property $accessToken
	 * @type string
	 * @default null
	 * Bearer token given to the client to access resources
	 */
	/**
	 * @property $expires
	 * @type string|Db_Expression
	 * @default null
	 * When the token expires
	 */
	/**
	 * @property $extra
	 * @type string
	 * @default "{}"
	 * JSON with any extra attributes
	 */
	/**
	 * The setUp() method is called the first time
	 * an object of this class is constructed.
	 * @method setUp
	 */
	function setUp()
	{
		$this->setDb(self::db());
		$this->setTable(self::table());
		$this->setPrimaryKey(
			array (
			  0 => 'platform',
			  1 => 'appId',
			  2 => 'xid',
			)
		);
	}

	/**
	 * Connects to database
	 * @method db
	 * @static
	 * @return {Db_Interface} The database object
	 */
	static function db()
	{
		return Db::connect('Users');
	}

	/**
	 * Retrieve the table name to use in SQL statement
	 * @method table
	 * @static
	 * @param {boolean} [$with_db_name=true] Indicates wheather table name should contain the database name
 	 * @return {string|Db_Expression} The table name as string optionally without database name if no table sharding
	 * was started or Db_Expression class with prefix and database name templates is table was sharded
	 */
	static function table($with_db_name = true)
	{
		if (Q_Config::get('Db', 'connections', 'Users', 'indexes', 'ExternalFrom', false)) {
			return new Db_Expression(($with_db_name ? '{$dbname}.' : '').'{$prefix}'.'external_from');
		} else {
			$conn = Db::getConnection('Users');
  			$prefix = empty($conn['prefix']) ? '' : $conn['prefix'];
  			$table_name = $prefix . 'external_from';
  			if (!$with_db_name)
  				return $table_name;
  			$db = Db::connect('Users');
  			return $db->dbName().'.'.$table_name;
		}
	}
	/**
	 * The connection name for the class
	 * @method connectionName
	 * @static
	 * @return {string} The name of the connection
	 */
	static function connectionName()
	{
		return 'Users';
	}

	/**
	 * Create SELECT query to the class table
	 * @method select
	 * @static
	 * @param {string|array} [$fields=null] The fields as strings, or array of alias=>field.
	 *   The default is to return all fields of the table.
	 * @param {string|array} [$alias=null] The tables as strings, or array of alias=>table.
	 * @return {Db_Query_Mysql} The generated query
	 */
	static function select($fields=null, $alias = null)
	{
		if (!isset($fields)) {
			$fieldNames = array();
			foreach (self::fieldNames() as $fn) {
				$fieldNames[] = $fn;
			}
			$fields = implode(',', $fieldNames);
		}
		if (!isset($alias)) $alias = '';
		$q = self::db()->select($fields, self::table().' '.$alias);
		$q->className = 'Users_ExternalFrom';
		return $q;
	}

	/**
	 * Create UPDATE query to the class table
	 * @method update
	 * @static
	 * @param {string} [$alias=null] Table alias
	 * @return {Db_Query_Mysql} The generated query
	 */
	static function update($alias = null)
	{
		if (!isset($alias)) $alias = '';
		$q = self::db()->update(self::table().' '.$alias);
		$q->className = 'Users_ExternalFrom';
		return $q;
	}

	/**
	 * Create DELETE query to the class table
	 * @method delete
	 * @static
	 * @param {object} [$table_using=null] If set, adds a USING clause with this table
	 * @param {string} [$alias=null] Table alias
	 * @return {Db_Query_Mysql} The generated query
	 */
	static function delete($table_using = null, $alias = null)
	{
		if (!isset($alias)) $alias = '';
		$q = self::db()->delete(self::table().' '.$alias, $table_using);
		$q->className = 'Users_ExternalFrom';
		return $q;
	}

	/**
	 * Create INSERT query to the class table
	 * @method insert
	 * @static
	 * @param {object} [$fields=array()] The fields as an associative array of column => value pairs
	 * @param {string} [$alias=null] Table alias
	 * @return {Db_Query_Mysql} The generated query
	 */
	static function insert($fields = array(), $alias = null)
	{
		if (!isset($alias)) $alias = '';
		$q = self::db()->insert(self::table().' '.$alias, $fields);
		$q->className = 'Users_ExternalFrom';
		return $q;
	}
	
	/**
	 * Inserts multiple rows into a single table, preparing the statement only once,
	 * and executes all the queries.
	 * @method insertManyAndExecute
	 * @static
	 * @param {array} [$rows=array()] The array of rows to insert. 
	 * (The field names for the prepared statement are taken from the first row.)
	 * You cannot use Db_Expression objects here, because the function binds all parameters with PDO.
	 * @param {array} [$options=array()]
	 *   An associative array of options, including:
	 *
	 * * "chunkSize" {integer} The number of rows to insert at a time. defaults to 20.<br>
	 * * "onDuplicateKeyUpdate" {array} You can put an array of fieldname => value pairs here,
	 * 		which will add an ON DUPLICATE KEY UPDATE clause to the query.
	 *
	 */
	static function insertManyAndExecute($rows = array(), $options = array())
	{
		self::db()->insertManyAndExecute(
			self::table(), $rows,
			array_merge($options, array('className' => 'Users_ExternalFrom'))
		);
	}
	
	/**
	 * Create raw query with begin clause
	 * You'll have to specify shards yourself when calling execute().
	 * @method begin
	 * @static
	 * @param {string} [$lockType=null] First parameter to pass to query->begin() function
	 * @return {Db_Query_Mysql} The generated query
	 */
	static function begin($lockType = null)
	{
		$q = self::db()->rawQuery('')->begin($lockType);
		$q->className = 'Users_ExternalFrom';
		return $q;
	}
	
	/**
	 * Create raw query with commit clause
	 * You'll have to specify shards yourself when calling execute().
	 * @method commit
	 * @static
	 * @return {Db_Query_Mysql} The generated query
	 */
	static function commit()
	{
		$q = self::db()->rawQuery('')->commit();
		$q->className = 'Users_ExternalFrom';
		return $q;
	}
	
	/**
	 * Create raw query with rollback clause
	 * @method rollback
	 * @static
	 * @param {array} $criteria Can be used to target the rollback to some shards.
	 *  Otherwise you'll have to specify shards yourself when calling execute().
	 * @return {Db_Query_Mysql} The generated query
	 */
	static function rollback()
	{
		$q = self::db()->rawQuery('')->rollback();
		$q->className = 'Users_ExternalFrom';
		return $q;
	}
	
	/**
	 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
	 * Optionally accept numeric value which is converted to string
	 * @method beforeSet_platform
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not string or is exceedingly long
	 */
	function beforeSet_platform($value)
	{
		if (!isset($value)) {
			$value='';
		}
		if ($value instanceof Db_Expression) {
			return array('platform', $value);
		}
		if (!is_string($value) and !is_numeric($value))
			throw new Exception('Must pass a string to '.$this->getTable().".platform");
		if (strlen($value) > 31)
			throw new Exception('Exceedingly long value being assigned to '.$this->getTable().".platform");
		return array('platform', $value);			
	}

	/**
	 * Returns the maximum string length that can be assigned to the platform field
	 * @return {integer}
	 */
	function maxSize_platform()
	{

		return 31;			
	}

	/**
	 * Returns schema information for platform column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_platform()
	{

return array (
  0 => 
  array (
    0 => 'varchar',
    1 => '31',
    2 => '',
    3 => false,
  ),
  1 => false,
  2 => 'PRI',
  3 => '',
);			
	}

	/**
	 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
	 * Optionally accept numeric value which is converted to string
	 * @method beforeSet_appId
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not string or is exceedingly long
	 */
	function beforeSet_appId($value)
	{
		if (!isset($value)) {
			$value='';
		}
		if ($value instanceof Db_Expression) {
			return array('appId', $value);
		}
		if (!is_string($value) and !is_numeric($value))
			throw new Exception('Must pass a string to '.$this->getTable().".appId");
		if (strlen($value) > 200)
			throw new Exception('Exceedingly long value being assigned to '.$this->getTable().".appId");
		return array('appId', $value);			
	}

	/**
	 * Returns the maximum string length that can be assigned to the appId field
	 * @return {integer}
	 */
	function maxSize_appId()
	{

		return 200;			
	}

	/**
	 * Returns schema information for appId column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_appId()
	{

return array (
  0 => 
  array (
    0 => 'varchar',
    1 => '200',
    2 => '',
    3 => false,
  ),
  1 => false,
  2 => 'PRI',
  3 => '',
);			
	}

	/**
	 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
	 * Optionally accept numeric value which is converted to string
	 * @method beforeSet_xid
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not string or is exceedingly long
	 */
	function beforeSet_xid($value)
	{
		if (!isset($value)) {
			$value='';
		}
		if ($value instanceof Db_Expression) {
			return array('xid', $value);
		}
		if (!is_string($value) and !is_numeric($value))
			throw new Exception('Must pass a string to '.$this->getTable().".xid");
		if (strlen($value) > 200)
			throw new Exception('Exceedingly long value being assigned to '.$this->getTable().".xid");
		return array('xid', $value);			
	}

	/**
	 * Returns the maximum string length that can be assigned to the xid field
	 * @return {integer}
	 */
	function maxSize_xid()
	{

		return 200;			
	}

	/**
	 * Returns schema information for xid column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_xid()
	{

return array (
  0 => 
  array (
    0 => 'varchar',
    1 => '200',
    2 => '',
    3 => false,
  ),
  1 => false,
  2 => 'PRI',
  3 => '',
);			
	}

	/**
	 * Method is called before setting the field and normalize the DateTime string
	 * @method beforeSet_insertedTime
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value does not represent valid DateTime
	 */
	function beforeSet_insertedTime($value)
	{
		if (!isset($value)) {
			return array('insertedTime', $value);
		}
		if ($value instanceof Db_Expression) {
			return array('insertedTime', $value);
		}
		if ($value instanceof DateTime) {
			$value = $value->getTimestamp();
		}
		if (is_numeric($value)) {
			$newDateTime = new DateTime();
			$datetime = $newDateTime->setTimestamp($value);
		} else {
			$datetime = new DateTime($value);
		}
		$value = $datetime->format("Y-m-d H:i:s");
		return array('insertedTime', $value);			
	}

	/**
	 * Returns schema information for insertedTime column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_insertedTime()
	{

return array (
  0 => 
  array (
    0 => 'timestamp',
    1 => '200',
    2 => '',
    3 => false,
  ),
  1 => true,
  2 => '',
  3 => 'CURRENT_TIMESTAMP',
);			
	}

	/**
	 * Method is called before setting the field and normalize the DateTime string
	 * @method beforeSet_updatedTime
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value does not represent valid DateTime
	 */
	function beforeSet_updatedTime($value)
	{
		if (!isset($value)) {
			return array('updatedTime', $value);
		}
		if ($value instanceof Db_Expression) {
			return array('updatedTime', $value);
		}
		if ($value instanceof DateTime) {
			$value = $value->getTimestamp();
		}
		if (is_numeric($value)) {
			$newDateTime = new DateTime();
			$datetime = $newDateTime->setTimestamp($value);
		} else {
			$datetime = new DateTime($value);
		}
		$value = $datetime->format("Y-m-d H:i:s");
		return array('updatedTime', $value);			
	}

	/**
	 * Returns schema information for updatedTime column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_updatedTime()
	{

return array (
  0 => 
  array (
    0 => 'timestamp',
    1 => '200',
    2 => '',
    3 => false,
  ),
  1 => true,
  2 => '',
  3 => NULL,
);			
	}

	/**
	 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
	 * Optionally accept numeric value which is converted to string
	 * @method beforeSet_userId
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not string or is exceedingly long
	 */
	function beforeSet_userId($value)
	{
		if (!isset($value)) {
			$value='';
		}
		if ($value instanceof Db_Expression) {
			return array('userId', $value);
		}
		if (!is_string($value) and !is_numeric($value))
			throw new Exception('Must pass a string to '.$this->getTable().".userId");
		if (strlen($value) > 31)
			throw new Exception('Exceedingly long value being assigned to '.$this->getTable().".userId");
		return array('userId', $value);			
	}

	/**
	 * Returns the maximum string length that can be assigned to the userId field
	 * @return {integer}
	 */
	function maxSize_userId()
	{

		return 31;			
	}

	/**
	 * Returns schema information for userId column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_userId()
	{

return array (
  0 => 
  array (
    0 => 'varchar',
    1 => '31',
    2 => '',
    3 => false,
  ),
  1 => false,
  2 => '',
  3 => '',
);			
	}

	/**
	 * Method is called before setting the field and verifies if value belongs to enum values list
	 * @method beforeSet_responseType
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value does not belong to enum values list
	 */
	function beforeSet_responseType($value)
	{
		if (!isset($value)) {
			return array('responseType', $value);
		}
		if ($value instanceof Db_Expression) {
			return array('responseType', $value);
		}
		if (!in_array($value, array('token','code')))
			throw new Exception("Out-of-range value '$value' being assigned to ".$this->getTable().".responseType");
		return array('responseType', $value);			
	}

	/**
	 * Returns schema information for responseType column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_responseType()
	{

return array (
  0 => 
  array (
    0 => 'enum',
    1 => '\'token\',\'code\'',
    2 => '',
    3 => false,
  ),
  1 => true,
  2 => '',
  3 => NULL,
);			
	}

	/**
	 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
	 * Optionally accept numeric value which is converted to string
	 * @method beforeSet_accessToken
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not string or is exceedingly long
	 */
	function beforeSet_accessToken($value)
	{
		if (!isset($value)) {
			return array('accessToken', $value);
		}
		if ($value instanceof Db_Expression) {
			return array('accessToken', $value);
		}
		if (!is_string($value) and !is_numeric($value))
			throw new Exception('Must pass a string to '.$this->getTable().".accessToken");
		if (strlen($value) > 1023)
			throw new Exception('Exceedingly long value being assigned to '.$this->getTable().".accessToken");
		return array('accessToken', $value);			
	}

	/**
	 * Returns the maximum string length that can be assigned to the accessToken field
	 * @return {integer}
	 */
	function maxSize_accessToken()
	{

		return 1023;			
	}

	/**
	 * Returns schema information for accessToken column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_accessToken()
	{

return array (
  0 => 
  array (
    0 => 'varchar',
    1 => '1023',
    2 => '',
    3 => false,
  ),
  1 => true,
  2 => '',
  3 => NULL,
);			
	}

	/**
	 * Method is called before setting the field and normalize the DateTime string
	 * @method beforeSet_expires
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value does not represent valid DateTime
	 */
	function beforeSet_expires($value)
	{
		if (!isset($value)) {
			return array('expires', $value);
		}
		if ($value instanceof Db_Expression) {
			return array('expires', $value);
		}
		if ($value instanceof DateTime) {
			$value = $value->getTimestamp();
		}
		if (is_numeric($value)) {
			$newDateTime = new DateTime();
			$datetime = $newDateTime->setTimestamp($value);
		} else {
			$datetime = new DateTime($value);
		}
		$value = $datetime->format("Y-m-d H:i:s");
		return array('expires', $value);			
	}

	/**
	 * Returns schema information for expires column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_expires()
	{

return array (
  0 => 
  array (
    0 => 'timestamp',
    1 => '1023',
    2 => '',
    3 => false,
  ),
  1 => true,
  2 => '',
  3 => NULL,
);			
	}

	/**
	 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
	 * Optionally accept numeric value which is converted to string
	 * @method beforeSet_extra
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not string or is exceedingly long
	 */
	function beforeSet_extra($value)
	{
		if (!isset($value)) {
			return array('extra', $value);
		}
		if ($value instanceof Db_Expression) {
			return array('extra', $value);
		}
		if (!is_string($value) and !is_numeric($value))
			throw new Exception('Must pass a string to '.$this->getTable().".extra");
		if (strlen($value) > 1023)
			throw new Exception('Exceedingly long value being assigned to '.$this->getTable().".extra");
		return array('extra', $value);			
	}

	/**
	 * Returns the maximum string length that can be assigned to the extra field
	 * @return {integer}
	 */
	function maxSize_extra()
	{

		return 1023;			
	}

	/**
	 * Returns schema information for extra column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_extra()
	{

return array (
  0 => 
  array (
    0 => 'varchar',
    1 => '1023',
    2 => '',
    3 => false,
  ),
  1 => true,
  2 => '',
  3 => '{}',
);			
	}

	function beforeSave($value)
	{
						
		// convention: we'll have updatedTime = insertedTime if just created.
		$this->updatedTime = $value['updatedTime'] = new Db_Expression('CURRENT_TIMESTAMP');
		return $value;			
	}

	/**
	 * Retrieves field names for class table
	 * @method fieldNames
	 * @static
	 * @param {string} [$table_alias=null] If set, the alieas is added to each field
	 * @param {string} [$field_alias_prefix=null] If set, the method returns associative array of ('prefixed field' => 'field') pairs
	 * @return {array} An array of field names
	 */
	static function fieldNames($table_alias = null, $field_alias_prefix = null)
	{
		$field_names = array('platform', 'appId', 'xid', 'insertedTime', 'updatedTime', 'userId', 'responseType', 'accessToken', 'expires', 'extra');
		$result = $field_names;
		if (!empty($table_alias)) {
			$temp = array();
			foreach ($result as $field_name)
				$temp[] = $table_alias . '.' . $field_name;
			$result = $temp;
		} 
		if (!empty($field_alias_prefix)) {
			$temp = array();
			reset($field_names);
			foreach ($result as $field_name) {
				$temp[$field_alias_prefix . current($field_names)] = $field_name;
				next($field_names);
			}
			$result = $temp;
		}
		return $result;			
	}
};