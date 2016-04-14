<?php

namespace Base;

use \LoginSession as ChildLoginSession;
use \LoginSessionQuery as ChildLoginSessionQuery;
use \Exception;
use \PDO;
use Map\LoginSessionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'login_session' table.
 *
 *
 *
 * @method     ChildLoginSessionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildLoginSessionQuery orderByUserType($order = Criteria::ASC) Order by the user_type column
 * @method     ChildLoginSessionQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildLoginSessionQuery orderBySessionId($order = Criteria::ASC) Order by the session_id column
 * @method     ChildLoginSessionQuery orderBySessionKey($order = Criteria::ASC) Order by the session_key column
 * @method     ChildLoginSessionQuery orderByDisabled($order = Criteria::ASC) Order by the disabled column
 * @method     ChildLoginSessionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildLoginSessionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildLoginSessionQuery groupById() Group by the id column
 * @method     ChildLoginSessionQuery groupByUserType() Group by the user_type column
 * @method     ChildLoginSessionQuery groupByUserId() Group by the user_id column
 * @method     ChildLoginSessionQuery groupBySessionId() Group by the session_id column
 * @method     ChildLoginSessionQuery groupBySessionKey() Group by the session_key column
 * @method     ChildLoginSessionQuery groupByDisabled() Group by the disabled column
 * @method     ChildLoginSessionQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildLoginSessionQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildLoginSessionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildLoginSessionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildLoginSessionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildLoginSessionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildLoginSessionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildLoginSessionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildLoginSession findOne(ConnectionInterface $con = null) Return the first ChildLoginSession matching the query
 * @method     ChildLoginSession findOneOrCreate(ConnectionInterface $con = null) Return the first ChildLoginSession matching the query, or a new ChildLoginSession object populated from the query conditions when no match is found
 *
 * @method     ChildLoginSession findOneById(int $id) Return the first ChildLoginSession filtered by the id column
 * @method     ChildLoginSession findOneByUserType(string $user_type) Return the first ChildLoginSession filtered by the user_type column
 * @method     ChildLoginSession findOneByUserId(int $user_id) Return the first ChildLoginSession filtered by the user_id column
 * @method     ChildLoginSession findOneBySessionId(string $session_id) Return the first ChildLoginSession filtered by the session_id column
 * @method     ChildLoginSession findOneBySessionKey(string $session_key) Return the first ChildLoginSession filtered by the session_key column
 * @method     ChildLoginSession findOneByDisabled(boolean $disabled) Return the first ChildLoginSession filtered by the disabled column
 * @method     ChildLoginSession findOneByCreatedAt(string $created_at) Return the first ChildLoginSession filtered by the created_at column
 * @method     ChildLoginSession findOneByUpdatedAt(string $updated_at) Return the first ChildLoginSession filtered by the updated_at column *

 * @method     ChildLoginSession requirePk($key, ConnectionInterface $con = null) Return the ChildLoginSession by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLoginSession requireOne(ConnectionInterface $con = null) Return the first ChildLoginSession matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildLoginSession requireOneById(int $id) Return the first ChildLoginSession filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLoginSession requireOneByUserType(string $user_type) Return the first ChildLoginSession filtered by the user_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLoginSession requireOneByUserId(int $user_id) Return the first ChildLoginSession filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLoginSession requireOneBySessionId(string $session_id) Return the first ChildLoginSession filtered by the session_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLoginSession requireOneBySessionKey(string $session_key) Return the first ChildLoginSession filtered by the session_key column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLoginSession requireOneByDisabled(boolean $disabled) Return the first ChildLoginSession filtered by the disabled column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLoginSession requireOneByCreatedAt(string $created_at) Return the first ChildLoginSession filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLoginSession requireOneByUpdatedAt(string $updated_at) Return the first ChildLoginSession filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildLoginSession[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildLoginSession objects based on current ModelCriteria
 * @method     ChildLoginSession[]|ObjectCollection findById(int $id) Return ChildLoginSession objects filtered by the id column
 * @method     ChildLoginSession[]|ObjectCollection findByUserType(string $user_type) Return ChildLoginSession objects filtered by the user_type column
 * @method     ChildLoginSession[]|ObjectCollection findByUserId(int $user_id) Return ChildLoginSession objects filtered by the user_id column
 * @method     ChildLoginSession[]|ObjectCollection findBySessionId(string $session_id) Return ChildLoginSession objects filtered by the session_id column
 * @method     ChildLoginSession[]|ObjectCollection findBySessionKey(string $session_key) Return ChildLoginSession objects filtered by the session_key column
 * @method     ChildLoginSession[]|ObjectCollection findByDisabled(boolean $disabled) Return ChildLoginSession objects filtered by the disabled column
 * @method     ChildLoginSession[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildLoginSession objects filtered by the created_at column
 * @method     ChildLoginSession[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildLoginSession objects filtered by the updated_at column
 * @method     ChildLoginSession[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class LoginSessionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\LoginSessionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cms', $modelName = '\\LoginSession', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildLoginSessionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildLoginSessionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildLoginSessionQuery) {
            return $criteria;
        }
        $query = new ChildLoginSessionQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildLoginSession|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = LoginSessionTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(LoginSessionTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildLoginSession A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, user_type, user_id, session_id, session_key, disabled, created_at, updated_at FROM login_session WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildLoginSession $obj */
            $obj = new ChildLoginSession();
            $obj->hydrate($row);
            LoginSessionTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildLoginSession|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildLoginSessionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(LoginSessionTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildLoginSessionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(LoginSessionTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLoginSessionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(LoginSessionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(LoginSessionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LoginSessionTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the user_type column
     *
     * Example usage:
     * <code>
     * $query->filterByUserType('fooValue');   // WHERE user_type = 'fooValue'
     * $query->filterByUserType('%fooValue%'); // WHERE user_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLoginSessionQuery The current query, for fluid interface
     */
    public function filterByUserType($userType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userType)) {
                $userType = str_replace('*', '%', $userType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LoginSessionTableMap::COL_USER_TYPE, $userType, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLoginSessionQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(LoginSessionTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(LoginSessionTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LoginSessionTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the session_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySessionId('fooValue');   // WHERE session_id = 'fooValue'
     * $query->filterBySessionId('%fooValue%'); // WHERE session_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sessionId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLoginSessionQuery The current query, for fluid interface
     */
    public function filterBySessionId($sessionId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sessionId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sessionId)) {
                $sessionId = str_replace('*', '%', $sessionId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LoginSessionTableMap::COL_SESSION_ID, $sessionId, $comparison);
    }

    /**
     * Filter the query on the session_key column
     *
     * Example usage:
     * <code>
     * $query->filterBySessionKey('fooValue');   // WHERE session_key = 'fooValue'
     * $query->filterBySessionKey('%fooValue%'); // WHERE session_key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sessionKey The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLoginSessionQuery The current query, for fluid interface
     */
    public function filterBySessionKey($sessionKey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sessionKey)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sessionKey)) {
                $sessionKey = str_replace('*', '%', $sessionKey);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LoginSessionTableMap::COL_SESSION_KEY, $sessionKey, $comparison);
    }

    /**
     * Filter the query on the disabled column
     *
     * Example usage:
     * <code>
     * $query->filterByDisabled(true); // WHERE disabled = true
     * $query->filterByDisabled('yes'); // WHERE disabled = true
     * </code>
     *
     * @param     boolean|string $disabled The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLoginSessionQuery The current query, for fluid interface
     */
    public function filterByDisabled($disabled = null, $comparison = null)
    {
        if (is_string($disabled)) {
            $disabled = in_array(strtolower($disabled), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(LoginSessionTableMap::COL_DISABLED, $disabled, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLoginSessionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(LoginSessionTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(LoginSessionTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LoginSessionTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLoginSessionQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(LoginSessionTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(LoginSessionTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LoginSessionTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildLoginSession $loginSession Object to remove from the list of results
     *
     * @return $this|ChildLoginSessionQuery The current query, for fluid interface
     */
    public function prune($loginSession = null)
    {
        if ($loginSession) {
            $this->addUsingAlias(LoginSessionTableMap::COL_ID, $loginSession->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the login_session table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LoginSessionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            LoginSessionTableMap::clearInstancePool();
            LoginSessionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LoginSessionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(LoginSessionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            LoginSessionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            LoginSessionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildLoginSessionQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(LoginSessionTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildLoginSessionQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(LoginSessionTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildLoginSessionQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(LoginSessionTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildLoginSessionQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(LoginSessionTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildLoginSessionQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(LoginSessionTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildLoginSessionQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(LoginSessionTableMap::COL_CREATED_AT);
    }

} // LoginSessionQuery
