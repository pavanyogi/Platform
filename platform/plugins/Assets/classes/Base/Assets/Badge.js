/**
 * Autogenerated base class representing badge rows
 * in the Assets database.
 *
 * Don't change this file, since it can be overwritten.
 * Instead, change the Assets/Badge.js file.
 *
 * @module Assets
 */

var Q = require('Q');
var Db = Q.require('Db');
var Assets = Q.require('Assets');
var Row = Q.require('Db/Row');

/**
 * Base class representing 'Badge' rows in the 'Assets' database
 * @namespace Base.Assets
 * @class Badge
 * @extends Db.Row
 * @constructor
 * @param {object} [fields={}] The fields values to initialize table row as 
 * an associative array of {column: value} pairs
 * @param {string} [$fields.app] defaults to ""
 * @param {string} [$fields.name] defaults to ""
 * @param {string} [$fields.title] defaults to ""
 * @param {string} [$fields.pic_small] defaults to ""
 * @param {string} [$fields.pic_big] defaults to ""
 * @param {integer} [$fields.points] defaults to 0
 */
function Base (fields) {
	Base.constructors.apply(this, arguments);
}

Q.mixin(Base, Row);

/**
 * @property app
 * @type String|Buffer
 * @default ""
 * 
 */
/**
 * @property name
 * @type String
 * @default ""
 * 
 */
/**
 * @property title
 * @type String
 * @default ""
 * 
 */
/**
 * @property pic_small
 * @type String|Buffer
 * @default ""
 * 
 */
/**
 * @property pic_big
 * @type String|Buffer
 * @default ""
 * 
 */
/**
 * @property points
 * @type Integer
 * @default 0
 * 
 */

/**
 * This method calls Db.connect() using information stored in the configuration.
 * If this has already been called, then the same db object is returned.
 * @method db
 * @return {Db} The database connection
 */
Base.db = function () {
	return Assets.db();
};

/**
 * Retrieve the table name to use in SQL statements
 * @method table
 * @param {boolean} [withoutDbName=false] Indicates wheather table name should contain the database name
 * @return {String|Db.Expression} The table name as string optionally without database name if no table sharding was started
 * or Db.Expression object with prefix and database name templates is table was sharded
 */
Base.table = function (withoutDbName) {
	if (Q.Config.get(['Db', 'connections', 'Assets', 'indexes', 'Badge'], false)) {
		return new Db.Expression((withoutDbName ? '' : '{$dbname}.')+'{$prefix}badge');
	} else {
		var conn = Db.getConnection('Assets');
		var prefix = conn.prefix || '';
		var tableName = prefix + 'badge';
		var dbname = Base.table.dbname;
		if (!dbname) {
			var dsn = Db.parseDsnString(conn['dsn']);
			dbname = Base.table.dbname = dsn.dbname;
		}
		return withoutDbName ? tableName : dbname + '.' + tableName;
	}
};

/**
 * The connection name for the class
 * @method connectionName
 * @return {String} The name of the connection
 */
Base.connectionName = function() {
	return 'Assets';
};

/**
 * Create SELECT query to the class table
 * @method SELECT
 * @param {String|Object} [fields='*'] The fields as strings, or object of {alias:field} pairs
 * @param {String|Object} [alias=null] The tables as strings, or object of {alias:table} pairs
 * @return {Db.Query.Mysql} The generated query
 */
Base.SELECT = function(fields, alias) {
	fields = fields || '*';
	var q = Base.db().SELECT(fields, Base.table()+(alias ? ' '+alias : ''));
	q.className = 'Assets_Badge';
	return q;
};

/**
 * Create UPDATE query to the class table. Use Db.Query.Mysql.set() method to define SET clause
 * @method UPDATE
 * @param {String} [alias=null] Table alias
 * @return {Db.Query.Mysql} The generated query
 */
Base.UPDATE = function(alias) {
	var q = Base.db().UPDATE(Base.table()+(alias ? ' '+alias : ''));
	q.className = 'Assets_Badge';
	return q;
};

/**
 * Create DELETE query to the class table
 * @method DELETE
 * @param {Object}[table_using=null] If set, adds a USING clause with this table
 * @param {String} [alias=null] Table alias
 * @return {Db.Query.Mysql} The generated query
 */
Base.DELETE = function(table_using, alias) {
	var q = Base.db().DELETE(Base.table()+(alias ? ' '+alias : ''), table_using);
	q.className = 'Assets_Badge';
	return q;
};

/**
 * Create INSERT query to the class table
 * @method INSERT
 * @param {Object} [fields={}] The fields as an associative array of {column: value} pairs
 * @param {String} [alias=null] Table alias
 * @return {Db.Query.Mysql} The generated query
 */
Base.INSERT = function(fields, alias) {
	var q = Base.db().INSERT(Base.table()+(alias ? ' '+alias : ''), fields || {});
	q.className = 'Assets_Badge';
	return q;
};

/**
 * Create raw query with BEGIN clause.
 * You'll have to specify shards yourself when calling execute().
 * @method BEGIN
 * @param {string} [$lockType] First parameter to pass to query.begin() function
 * @return {Db.Query.Mysql} The generated query
 */
Base.BEGIN = function($lockType) {
	var q = Base.db().rawQuery('').begin($lockType);
	q.className = 'Assets_Badge';
	return q;
};

/**
 * Create raw query with COMMIT clause
 * You'll have to specify shards yourself when calling execute().
 * @method COMMIT
 * @return {Db.Query.Mysql} The generated query
 */
Base.COMMIT = function(fields, alias) {
	var q = Base.db().rawQuery('').commit();
	q.className = 'Assets_Badge';
	return q;
};

/**
 * The name of the class
 * @property className
 * @type string
 */
Base.prototype.className = "Assets_Badge";

// Instance methods

/**
 * Create INSERT query to the class table
 * @method INSERT
 * @param {object} [fields={}] The fields as an associative array of {column: value} pairs
 * @param {string} [alias=null] Table alias
 * @return {Db.Query.Mysql} The generated query
 */
Base.prototype.setUp = function() {
	// does nothing for now
};

/**
 * Create INSERT query to the class table
 * @method INSERT
 * @param {object} [fields={}] The fields as an associative array of {column: value} pairs
 * @param {string} [alias=null] Table alias
 * @return {Db.Query.Mysql} The generated query
 */
Base.prototype.db = function () {
	return Base.db();
};

/**
 * Retrieve the table name to use in SQL statements
 * @method table
 * @param {boolean} [withoutDbName=false] Indicates wheather table name should contain the database name
 * @return {String|Db.Expression} The table name as string optionally without database name if no table sharding was started
 * or Db.Expression object with prefix and database name templates is table was sharded
 */
Base.prototype.table = function () {
	return Base.table();
};

/**
 * Retrieves primary key fields names for class table
 * @method primaryKey
 * @return {string[]} An array of field names
 */
Base.prototype.primaryKey = function () {
	return [
		"app",
		"name"
	];
};

/**
 * Retrieves field names for class table
 * @method fieldNames
 * @return {array} An array of field names
 */
Base.prototype.fieldNames = function () {
	return [
		"app",
		"name",
		"title",
		"pic_small",
		"pic_big",
		"points"
	];
};

/**
 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
 * Optionally accept numeric value which is converted to string
 * @method beforeSet_app
 * @param {string} value
 * @return {string} The value
 * @throws {Error} An exception is thrown if 'value' is not string or is exceedingly long
 */
Base.prototype.beforeSet_app = function (value) {
		if (value == null) {
			value='';
		}
		if (value instanceof Db.Expression) return value;
		if (typeof value !== "string" && typeof value !== "number" && !(value instanceof Buffer))
			throw new Error('Must pass a String or Buffer to '+this.table()+".app");
		if (typeof value === "string" && value.length > 255)
			throw new Error('Exceedingly long value being assigned to '+this.table()+".app");
		return value;
};

	/**
	 * Returns the maximum string length that can be assigned to the app field
	 * @return {integer}
	 */
Base.prototype.maxSize_app = function () {

		return 255;
};

	/**
	 * Returns schema information for app column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
Base.column_app = function () {

return [["varbinary","255","",false],false,"PRI",null];
};

/**
 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
 * Optionally accept numeric value which is converted to string
 * @method beforeSet_name
 * @param {string} value
 * @return {string} The value
 * @throws {Error} An exception is thrown if 'value' is not string or is exceedingly long
 */
Base.prototype.beforeSet_name = function (value) {
		if (value == null) {
			value='';
		}
		if (value instanceof Db.Expression) return value;
		if (typeof value !== "string" && typeof value !== "number")
			throw new Error('Must pass a String to '+this.table()+".name");
		if (typeof value === "string" && value.length > 255)
			throw new Error('Exceedingly long value being assigned to '+this.table()+".name");
		return value;
};

	/**
	 * Returns the maximum string length that can be assigned to the name field
	 * @return {integer}
	 */
Base.prototype.maxSize_name = function () {

		return 255;
};

	/**
	 * Returns schema information for name column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
Base.column_name = function () {

return [["varchar","255","",false],false,"PRI",null];
};

/**
 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
 * Optionally accept numeric value which is converted to string
 * @method beforeSet_title
 * @param {string} value
 * @return {string} The value
 * @throws {Error} An exception is thrown if 'value' is not string or is exceedingly long
 */
Base.prototype.beforeSet_title = function (value) {
		if (value == null) {
			value='';
		}
		if (value instanceof Db.Expression) return value;
		if (typeof value !== "string" && typeof value !== "number")
			throw new Error('Must pass a String to '+this.table()+".title");
		if (typeof value === "string" && value.length > 65535)
			throw new Error('Exceedingly long value being assigned to '+this.table()+".title");
		return value;
};

	/**
	 * Returns the maximum string length that can be assigned to the title field
	 * @return {integer}
	 */
Base.prototype.maxSize_title = function () {

		return 65535;
};

	/**
	 * Returns schema information for title column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
Base.column_title = function () {

return [["text",65535,"",false],false,"",null];
};

/**
 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
 * Optionally accept numeric value which is converted to string
 * @method beforeSet_pic_small
 * @param {string} value
 * @return {string} The value
 * @throws {Error} An exception is thrown if 'value' is not string or is exceedingly long
 */
Base.prototype.beforeSet_pic_small = function (value) {
		if (value == null) {
			value='';
		}
		if (value instanceof Db.Expression) return value;
		if (typeof value !== "string" && typeof value !== "number" && !(value instanceof Buffer))
			throw new Error('Must pass a String or Buffer to '+this.table()+".pic_small");
		if (typeof value === "string" && value.length > 255)
			throw new Error('Exceedingly long value being assigned to '+this.table()+".pic_small");
		return value;
};

	/**
	 * Returns the maximum string length that can be assigned to the pic_small field
	 * @return {integer}
	 */
Base.prototype.maxSize_pic_small = function () {

		return 255;
};

	/**
	 * Returns schema information for pic_small column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
Base.column_pic_small = function () {

return [["varbinary","255","",false],false,"",null];
};

/**
 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
 * Optionally accept numeric value which is converted to string
 * @method beforeSet_pic_big
 * @param {string} value
 * @return {string} The value
 * @throws {Error} An exception is thrown if 'value' is not string or is exceedingly long
 */
Base.prototype.beforeSet_pic_big = function (value) {
		if (value == null) {
			value='';
		}
		if (value instanceof Db.Expression) return value;
		if (typeof value !== "string" && typeof value !== "number" && !(value instanceof Buffer))
			throw new Error('Must pass a String or Buffer to '+this.table()+".pic_big");
		if (typeof value === "string" && value.length > 255)
			throw new Error('Exceedingly long value being assigned to '+this.table()+".pic_big");
		return value;
};

	/**
	 * Returns the maximum string length that can be assigned to the pic_big field
	 * @return {integer}
	 */
Base.prototype.maxSize_pic_big = function () {

		return 255;
};

	/**
	 * Returns schema information for pic_big column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
Base.column_pic_big = function () {

return [["varbinary","255","",false],false,"",null];
};

/**
 * Method is called before setting the field and verifies if integer value falls within allowed limits
 * @method beforeSet_points
 * @param {integer} value
 * @return {integer} The value
 * @throws {Error} An exception is thrown if 'value' is not integer or does not fit in allowed range
 */
Base.prototype.beforeSet_points = function (value) {
		if (value instanceof Db.Expression) return value;
		value = Number(value);
		if (isNaN(value) || Math.floor(value) != value) 
			throw new Error('Non-integer value being assigned to '+this.table()+".points");
		if (value < -32768 || value > 32767)
			throw new Error("Out-of-range value "+JSON.stringify(value)+" being assigned to "+this.table()+".points");
		return value;
};

/**
 * Returns the maximum integer that can be assigned to the points field
 * @return {integer}
 */
Base.prototype.maxSize_points = function () {

		return 32767;
};

	/**
	 * Returns schema information for points column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
Base.column_points = function () {

return [["smallint","4","",false],false,"","0"];
};

/**
 * Check if mandatory fields are set and updates 'magic fields' with appropriate values
 * @method beforeSave
 * @param {Object} value The object of fields
 * @param {Function} callback Call this callback if you return null
 * @return {Object|null} Return the fields, modified if necessary. If you return null, then you should call the callback(err, modifiedFields)
 * @throws {Error} If e.g. mandatory field is not set or a bad values are supplied
 */
Base.prototype.beforeSave = function (value) {
	var fields = ['app','name'], i;
	if (!this._retrieved) {
		var table = this.table();
		for (i=0; i<fields.length; i++) {
			if (this.fields[fields[i]] === undefined) {
				throw new Error("the field "+table+"."+fields[i]+" needs a value, because it is NOT NULL, not auto_increment, and lacks a default value.");
			}
		}
	}
	return value;
};

module.exports = Base;