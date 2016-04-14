<?php

namespace Base;

use \IncidentVersion as ChildIncidentVersion;
use \IncidentVersionQuery as ChildIncidentVersionQuery;
use \Exception;
use \PDO;
use Map\IncidentVersionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'incident_version' table.
 *
 *
 *
 * @method     ChildIncidentVersionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildIncidentVersionQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildIncidentVersionQuery orderByLocation($order = Criteria::ASC) Order by the location column
 * @method     ChildIncidentVersionQuery orderByLatitude($order = Criteria::ASC) Order by the latitude column
 * @method     ChildIncidentVersionQuery orderByLongitude($order = Criteria::ASC) Order by the longitude column
 * @method     ChildIncidentVersionQuery orderByActive($order = Criteria::ASC) Order by the active column
 * @method     ChildIncidentVersionQuery orderBySeverity($order = Criteria::ASC) Order by the severity column
 * @method     ChildIncidentVersionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildIncidentVersionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildIncidentVersionQuery orderByVersion($order = Criteria::ASC) Order by the version column
 *
 * @method     ChildIncidentVersionQuery groupById() Group by the id column
 * @method     ChildIncidentVersionQuery groupByTitle() Group by the title column
 * @method     ChildIncidentVersionQuery groupByLocation() Group by the location column
 * @method     ChildIncidentVersionQuery groupByLatitude() Group by the latitude column
 * @method     ChildIncidentVersionQuery groupByLongitude() Group by the longitude column
 * @method     ChildIncidentVersionQuery groupByActive() Group by the active column
 * @method     ChildIncidentVersionQuery groupBySeverity() Group by the severity column
 * @method     ChildIncidentVersionQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildIncidentVersionQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildIncidentVersionQuery groupByVersion() Group by the version column
 *
 * @method     ChildIncidentVersionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildIncidentVersionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildIncidentVersionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildIncidentVersionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildIncidentVersionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildIncidentVersionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildIncidentVersionQuery leftJoinIncident($relationAlias = null) Adds a LEFT JOIN clause to the query using the Incident relation
 * @method     ChildIncidentVersionQuery rightJoinIncident($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Incident relation
 * @method     ChildIncidentVersionQuery innerJoinIncident($relationAlias = null) Adds a INNER JOIN clause to the query using the Incident relation
 *
 * @method     ChildIncidentVersionQuery joinWithIncident($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Incident relation
 *
 * @method     ChildIncidentVersionQuery leftJoinWithIncident() Adds a LEFT JOIN clause and with to the query using the Incident relation
 * @method     ChildIncidentVersionQuery rightJoinWithIncident() Adds a RIGHT JOIN clause and with to the query using the Incident relation
 * @method     ChildIncidentVersionQuery innerJoinWithIncident() Adds a INNER JOIN clause and with to the query using the Incident relation
 *
 * @method     \IncidentQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildIncidentVersion findOne(ConnectionInterface $con = null) Return the first ChildIncidentVersion matching the query
 * @method     ChildIncidentVersion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildIncidentVersion matching the query, or a new ChildIncidentVersion object populated from the query conditions when no match is found
 *
 * @method     ChildIncidentVersion findOneById(int $id) Return the first ChildIncidentVersion filtered by the id column
 * @method     ChildIncidentVersion findOneByTitle(string $title) Return the first ChildIncidentVersion filtered by the title column
 * @method     ChildIncidentVersion findOneByLocation(string $location) Return the first ChildIncidentVersion filtered by the location column
 * @method     ChildIncidentVersion findOneByLatitude(double $latitude) Return the first ChildIncidentVersion filtered by the latitude column
 * @method     ChildIncidentVersion findOneByLongitude(double $longitude) Return the first ChildIncidentVersion filtered by the longitude column
 * @method     ChildIncidentVersion findOneByActive(boolean $active) Return the first ChildIncidentVersion filtered by the active column
 * @method     ChildIncidentVersion findOneBySeverity(int $severity) Return the first ChildIncidentVersion filtered by the severity column
 * @method     ChildIncidentVersion findOneByCreatedAt(string $created_at) Return the first ChildIncidentVersion filtered by the created_at column
 * @method     ChildIncidentVersion findOneByUpdatedAt(string $updated_at) Return the first ChildIncidentVersion filtered by the updated_at column
 * @method     ChildIncidentVersion findOneByVersion(int $version) Return the first ChildIncidentVersion filtered by the version column *

 * @method     ChildIncidentVersion requirePk($key, ConnectionInterface $con = null) Return the ChildIncidentVersion by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIncidentVersion requireOne(ConnectionInterface $con = null) Return the first ChildIncidentVersion matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildIncidentVersion requireOneById(int $id) Return the first ChildIncidentVersion filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIncidentVersion requireOneByTitle(string $title) Return the first ChildIncidentVersion filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIncidentVersion requireOneByLocation(string $location) Return the first ChildIncidentVersion filtered by the location column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIncidentVersion requireOneByLatitude(double $latitude) Return the first ChildIncidentVersion filtered by the latitude column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIncidentVersion requireOneByLongitude(double $longitude) Return the first ChildIncidentVersion filtered by the longitude column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIncidentVersion requireOneByActive(boolean $active) Return the first ChildIncidentVersion filtered by the active column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIncidentVersion requireOneBySeverity(int $severity) Return the first ChildIncidentVersion filtered by the severity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIncidentVersion requireOneByCreatedAt(string $created_at) Return the first ChildIncidentVersion filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIncidentVersion requireOneByUpdatedAt(string $updated_at) Return the first ChildIncidentVersion filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIncidentVersion requireOneByVersion(int $version) Return the first ChildIncidentVersion filtered by the version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildIncidentVersion[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildIncidentVersion objects based on current ModelCriteria
 * @method     ChildIncidentVersion[]|ObjectCollection findById(int $id) Return ChildIncidentVersion objects filtered by the id column
 * @method     ChildIncidentVersion[]|ObjectCollection findByTitle(string $title) Return ChildIncidentVersion objects filtered by the title column
 * @method     ChildIncidentVersion[]|ObjectCollection findByLocation(string $location) Return ChildIncidentVersion objects filtered by the location column
 * @method     ChildIncidentVersion[]|ObjectCollection findByLatitude(double $latitude) Return ChildIncidentVersion objects filtered by the latitude column
 * @method     ChildIncidentVersion[]|ObjectCollection findByLongitude(double $longitude) Return ChildIncidentVersion objects filtered by the longitude column
 * @method     ChildIncidentVersion[]|ObjectCollection findByActive(boolean $active) Return ChildIncidentVersion objects filtered by the active column
 * @method     ChildIncidentVersion[]|ObjectCollection findBySeverity(int $severity) Return ChildIncidentVersion objects filtered by the severity column
 * @method     ChildIncidentVersion[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildIncidentVersion objects filtered by the created_at column
 * @method     ChildIncidentVersion[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildIncidentVersion objects filtered by the updated_at column
 * @method     ChildIncidentVersion[]|ObjectCollection findByVersion(int $version) Return ChildIncidentVersion objects filtered by the version column
 * @method     ChildIncidentVersion[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class IncidentVersionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\IncidentVersionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cms', $modelName = '\\IncidentVersion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildIncidentVersionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildIncidentVersionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildIncidentVersionQuery) {
            return $criteria;
        }
        $query = new ChildIncidentVersionQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id, $version] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildIncidentVersion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = IncidentVersionTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])])))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(IncidentVersionTableMap::DATABASE_NAME);
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
     * @return ChildIncidentVersion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, title, location, latitude, longitude, active, severity, created_at, updated_at, version FROM incident_version WHERE id = :p0 AND version = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildIncidentVersion $obj */
            $obj = new ChildIncidentVersion();
            $obj->hydrate($row);
            IncidentVersionTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildIncidentVersion|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildIncidentVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(IncidentVersionTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(IncidentVersionTableMap::COL_VERSION, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildIncidentVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(IncidentVersionTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(IncidentVersionTableMap::COL_VERSION, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @see       filterByIncident()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIncidentVersionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(IncidentVersionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(IncidentVersionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IncidentVersionTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIncidentVersionQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(IncidentVersionTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the location column
     *
     * Example usage:
     * <code>
     * $query->filterByLocation('fooValue');   // WHERE location = 'fooValue'
     * $query->filterByLocation('%fooValue%'); // WHERE location LIKE '%fooValue%'
     * </code>
     *
     * @param     string $location The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIncidentVersionQuery The current query, for fluid interface
     */
    public function filterByLocation($location = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($location)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $location)) {
                $location = str_replace('*', '%', $location);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(IncidentVersionTableMap::COL_LOCATION, $location, $comparison);
    }

    /**
     * Filter the query on the latitude column
     *
     * Example usage:
     * <code>
     * $query->filterByLatitude(1234); // WHERE latitude = 1234
     * $query->filterByLatitude(array(12, 34)); // WHERE latitude IN (12, 34)
     * $query->filterByLatitude(array('min' => 12)); // WHERE latitude > 12
     * </code>
     *
     * @param     mixed $latitude The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIncidentVersionQuery The current query, for fluid interface
     */
    public function filterByLatitude($latitude = null, $comparison = null)
    {
        if (is_array($latitude)) {
            $useMinMax = false;
            if (isset($latitude['min'])) {
                $this->addUsingAlias(IncidentVersionTableMap::COL_LATITUDE, $latitude['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($latitude['max'])) {
                $this->addUsingAlias(IncidentVersionTableMap::COL_LATITUDE, $latitude['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IncidentVersionTableMap::COL_LATITUDE, $latitude, $comparison);
    }

    /**
     * Filter the query on the longitude column
     *
     * Example usage:
     * <code>
     * $query->filterByLongitude(1234); // WHERE longitude = 1234
     * $query->filterByLongitude(array(12, 34)); // WHERE longitude IN (12, 34)
     * $query->filterByLongitude(array('min' => 12)); // WHERE longitude > 12
     * </code>
     *
     * @param     mixed $longitude The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIncidentVersionQuery The current query, for fluid interface
     */
    public function filterByLongitude($longitude = null, $comparison = null)
    {
        if (is_array($longitude)) {
            $useMinMax = false;
            if (isset($longitude['min'])) {
                $this->addUsingAlias(IncidentVersionTableMap::COL_LONGITUDE, $longitude['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($longitude['max'])) {
                $this->addUsingAlias(IncidentVersionTableMap::COL_LONGITUDE, $longitude['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IncidentVersionTableMap::COL_LONGITUDE, $longitude, $comparison);
    }

    /**
     * Filter the query on the active column
     *
     * Example usage:
     * <code>
     * $query->filterByActive(true); // WHERE active = true
     * $query->filterByActive('yes'); // WHERE active = true
     * </code>
     *
     * @param     boolean|string $active The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIncidentVersionQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (is_string($active)) {
            $active = in_array(strtolower($active), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(IncidentVersionTableMap::COL_ACTIVE, $active, $comparison);
    }

    /**
     * Filter the query on the severity column
     *
     * Example usage:
     * <code>
     * $query->filterBySeverity(1234); // WHERE severity = 1234
     * $query->filterBySeverity(array(12, 34)); // WHERE severity IN (12, 34)
     * $query->filterBySeverity(array('min' => 12)); // WHERE severity > 12
     * </code>
     *
     * @param     mixed $severity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIncidentVersionQuery The current query, for fluid interface
     */
    public function filterBySeverity($severity = null, $comparison = null)
    {
        if (is_array($severity)) {
            $useMinMax = false;
            if (isset($severity['min'])) {
                $this->addUsingAlias(IncidentVersionTableMap::COL_SEVERITY, $severity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($severity['max'])) {
                $this->addUsingAlias(IncidentVersionTableMap::COL_SEVERITY, $severity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IncidentVersionTableMap::COL_SEVERITY, $severity, $comparison);
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
     * @return $this|ChildIncidentVersionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(IncidentVersionTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(IncidentVersionTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IncidentVersionTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildIncidentVersionQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(IncidentVersionTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(IncidentVersionTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IncidentVersionTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query on the version column
     *
     * Example usage:
     * <code>
     * $query->filterByVersion(1234); // WHERE version = 1234
     * $query->filterByVersion(array(12, 34)); // WHERE version IN (12, 34)
     * $query->filterByVersion(array('min' => 12)); // WHERE version > 12
     * </code>
     *
     * @param     mixed $version The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIncidentVersionQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(IncidentVersionTableMap::COL_VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(IncidentVersionTableMap::COL_VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IncidentVersionTableMap::COL_VERSION, $version, $comparison);
    }

    /**
     * Filter the query by a related \Incident object
     *
     * @param \Incident|ObjectCollection $incident The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildIncidentVersionQuery The current query, for fluid interface
     */
    public function filterByIncident($incident, $comparison = null)
    {
        if ($incident instanceof \Incident) {
            return $this
                ->addUsingAlias(IncidentVersionTableMap::COL_ID, $incident->getId(), $comparison);
        } elseif ($incident instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(IncidentVersionTableMap::COL_ID, $incident->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByIncident() only accepts arguments of type \Incident or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Incident relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildIncidentVersionQuery The current query, for fluid interface
     */
    public function joinIncident($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Incident');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Incident');
        }

        return $this;
    }

    /**
     * Use the Incident relation Incident object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \IncidentQuery A secondary query class using the current class as primary query
     */
    public function useIncidentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinIncident($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Incident', '\IncidentQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildIncidentVersion $incidentVersion Object to remove from the list of results
     *
     * @return $this|ChildIncidentVersionQuery The current query, for fluid interface
     */
    public function prune($incidentVersion = null)
    {
        if ($incidentVersion) {
            $this->addCond('pruneCond0', $this->getAliasedColName(IncidentVersionTableMap::COL_ID), $incidentVersion->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(IncidentVersionTableMap::COL_VERSION), $incidentVersion->getVersion(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the incident_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(IncidentVersionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            IncidentVersionTableMap::clearInstancePool();
            IncidentVersionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(IncidentVersionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(IncidentVersionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            IncidentVersionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            IncidentVersionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildIncidentVersionQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(IncidentVersionTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildIncidentVersionQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(IncidentVersionTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildIncidentVersionQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(IncidentVersionTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildIncidentVersionQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(IncidentVersionTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildIncidentVersionQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(IncidentVersionTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildIncidentVersionQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(IncidentVersionTableMap::COL_CREATED_AT);
    }

} // IncidentVersionQuery
