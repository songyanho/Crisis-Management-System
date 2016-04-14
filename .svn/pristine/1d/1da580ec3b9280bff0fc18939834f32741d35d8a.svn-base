<?php

namespace Base;

use \IncidentReporter as ChildIncidentReporter;
use \IncidentReporterQuery as ChildIncidentReporterQuery;
use \Exception;
use \PDO;
use Map\IncidentReporterTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'incident_reporter' table.
 *
 *
 *
 * @method     ChildIncidentReporterQuery orderByIncidentId($order = Criteria::ASC) Order by the incident_id column
 * @method     ChildIncidentReporterQuery orderByReporterId($order = Criteria::ASC) Order by the reporter_id column
 * @method     ChildIncidentReporterQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildIncidentReporterQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildIncidentReporterQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildIncidentReporterQuery groupByIncidentId() Group by the incident_id column
 * @method     ChildIncidentReporterQuery groupByReporterId() Group by the reporter_id column
 * @method     ChildIncidentReporterQuery groupByDescription() Group by the description column
 * @method     ChildIncidentReporterQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildIncidentReporterQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildIncidentReporterQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildIncidentReporterQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildIncidentReporterQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildIncidentReporterQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildIncidentReporterQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildIncidentReporterQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildIncidentReporterQuery leftJoinIncident($relationAlias = null) Adds a LEFT JOIN clause to the query using the Incident relation
 * @method     ChildIncidentReporterQuery rightJoinIncident($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Incident relation
 * @method     ChildIncidentReporterQuery innerJoinIncident($relationAlias = null) Adds a INNER JOIN clause to the query using the Incident relation
 *
 * @method     ChildIncidentReporterQuery joinWithIncident($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Incident relation
 *
 * @method     ChildIncidentReporterQuery leftJoinWithIncident() Adds a LEFT JOIN clause and with to the query using the Incident relation
 * @method     ChildIncidentReporterQuery rightJoinWithIncident() Adds a RIGHT JOIN clause and with to the query using the Incident relation
 * @method     ChildIncidentReporterQuery innerJoinWithIncident() Adds a INNER JOIN clause and with to the query using the Incident relation
 *
 * @method     ChildIncidentReporterQuery leftJoinReporter($relationAlias = null) Adds a LEFT JOIN clause to the query using the Reporter relation
 * @method     ChildIncidentReporterQuery rightJoinReporter($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Reporter relation
 * @method     ChildIncidentReporterQuery innerJoinReporter($relationAlias = null) Adds a INNER JOIN clause to the query using the Reporter relation
 *
 * @method     ChildIncidentReporterQuery joinWithReporter($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Reporter relation
 *
 * @method     ChildIncidentReporterQuery leftJoinWithReporter() Adds a LEFT JOIN clause and with to the query using the Reporter relation
 * @method     ChildIncidentReporterQuery rightJoinWithReporter() Adds a RIGHT JOIN clause and with to the query using the Reporter relation
 * @method     ChildIncidentReporterQuery innerJoinWithReporter() Adds a INNER JOIN clause and with to the query using the Reporter relation
 *
 * @method     \IncidentQuery|\ReporterQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildIncidentReporter findOne(ConnectionInterface $con = null) Return the first ChildIncidentReporter matching the query
 * @method     ChildIncidentReporter findOneOrCreate(ConnectionInterface $con = null) Return the first ChildIncidentReporter matching the query, or a new ChildIncidentReporter object populated from the query conditions when no match is found
 *
 * @method     ChildIncidentReporter findOneByIncidentId(int $incident_id) Return the first ChildIncidentReporter filtered by the incident_id column
 * @method     ChildIncidentReporter findOneByReporterId(int $reporter_id) Return the first ChildIncidentReporter filtered by the reporter_id column
 * @method     ChildIncidentReporter findOneByDescription(string $description) Return the first ChildIncidentReporter filtered by the description column
 * @method     ChildIncidentReporter findOneByCreatedAt(string $created_at) Return the first ChildIncidentReporter filtered by the created_at column
 * @method     ChildIncidentReporter findOneByUpdatedAt(string $updated_at) Return the first ChildIncidentReporter filtered by the updated_at column *

 * @method     ChildIncidentReporter requirePk($key, ConnectionInterface $con = null) Return the ChildIncidentReporter by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIncidentReporter requireOne(ConnectionInterface $con = null) Return the first ChildIncidentReporter matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildIncidentReporter requireOneByIncidentId(int $incident_id) Return the first ChildIncidentReporter filtered by the incident_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIncidentReporter requireOneByReporterId(int $reporter_id) Return the first ChildIncidentReporter filtered by the reporter_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIncidentReporter requireOneByDescription(string $description) Return the first ChildIncidentReporter filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIncidentReporter requireOneByCreatedAt(string $created_at) Return the first ChildIncidentReporter filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIncidentReporter requireOneByUpdatedAt(string $updated_at) Return the first ChildIncidentReporter filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildIncidentReporter[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildIncidentReporter objects based on current ModelCriteria
 * @method     ChildIncidentReporter[]|ObjectCollection findByIncidentId(int $incident_id) Return ChildIncidentReporter objects filtered by the incident_id column
 * @method     ChildIncidentReporter[]|ObjectCollection findByReporterId(int $reporter_id) Return ChildIncidentReporter objects filtered by the reporter_id column
 * @method     ChildIncidentReporter[]|ObjectCollection findByDescription(string $description) Return ChildIncidentReporter objects filtered by the description column
 * @method     ChildIncidentReporter[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildIncidentReporter objects filtered by the created_at column
 * @method     ChildIncidentReporter[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildIncidentReporter objects filtered by the updated_at column
 * @method     ChildIncidentReporter[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class IncidentReporterQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\IncidentReporterQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cms', $modelName = '\\IncidentReporter', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildIncidentReporterQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildIncidentReporterQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildIncidentReporterQuery) {
            return $criteria;
        }
        $query = new ChildIncidentReporterQuery();
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
     * @param array[$incident_id, $reporter_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildIncidentReporter|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = IncidentReporterTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])])))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(IncidentReporterTableMap::DATABASE_NAME);
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
     * @return ChildIncidentReporter A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT incident_id, reporter_id, description, created_at, updated_at FROM incident_reporter WHERE incident_id = :p0 AND reporter_id = :p1';
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
            /** @var ChildIncidentReporter $obj */
            $obj = new ChildIncidentReporter();
            $obj->hydrate($row);
            IncidentReporterTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildIncidentReporter|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildIncidentReporterQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(IncidentReporterTableMap::COL_INCIDENT_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(IncidentReporterTableMap::COL_REPORTER_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildIncidentReporterQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(IncidentReporterTableMap::COL_INCIDENT_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(IncidentReporterTableMap::COL_REPORTER_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the incident_id column
     *
     * Example usage:
     * <code>
     * $query->filterByIncidentId(1234); // WHERE incident_id = 1234
     * $query->filterByIncidentId(array(12, 34)); // WHERE incident_id IN (12, 34)
     * $query->filterByIncidentId(array('min' => 12)); // WHERE incident_id > 12
     * </code>
     *
     * @see       filterByIncident()
     *
     * @param     mixed $incidentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIncidentReporterQuery The current query, for fluid interface
     */
    public function filterByIncidentId($incidentId = null, $comparison = null)
    {
        if (is_array($incidentId)) {
            $useMinMax = false;
            if (isset($incidentId['min'])) {
                $this->addUsingAlias(IncidentReporterTableMap::COL_INCIDENT_ID, $incidentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($incidentId['max'])) {
                $this->addUsingAlias(IncidentReporterTableMap::COL_INCIDENT_ID, $incidentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IncidentReporterTableMap::COL_INCIDENT_ID, $incidentId, $comparison);
    }

    /**
     * Filter the query on the reporter_id column
     *
     * Example usage:
     * <code>
     * $query->filterByReporterId(1234); // WHERE reporter_id = 1234
     * $query->filterByReporterId(array(12, 34)); // WHERE reporter_id IN (12, 34)
     * $query->filterByReporterId(array('min' => 12)); // WHERE reporter_id > 12
     * </code>
     *
     * @see       filterByReporter()
     *
     * @param     mixed $reporterId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIncidentReporterQuery The current query, for fluid interface
     */
    public function filterByReporterId($reporterId = null, $comparison = null)
    {
        if (is_array($reporterId)) {
            $useMinMax = false;
            if (isset($reporterId['min'])) {
                $this->addUsingAlias(IncidentReporterTableMap::COL_REPORTER_ID, $reporterId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($reporterId['max'])) {
                $this->addUsingAlias(IncidentReporterTableMap::COL_REPORTER_ID, $reporterId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IncidentReporterTableMap::COL_REPORTER_ID, $reporterId, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIncidentReporterQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(IncidentReporterTableMap::COL_DESCRIPTION, $description, $comparison);
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
     * @return $this|ChildIncidentReporterQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(IncidentReporterTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(IncidentReporterTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IncidentReporterTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildIncidentReporterQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(IncidentReporterTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(IncidentReporterTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IncidentReporterTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Incident object
     *
     * @param \Incident|ObjectCollection $incident The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildIncidentReporterQuery The current query, for fluid interface
     */
    public function filterByIncident($incident, $comparison = null)
    {
        if ($incident instanceof \Incident) {
            return $this
                ->addUsingAlias(IncidentReporterTableMap::COL_INCIDENT_ID, $incident->getId(), $comparison);
        } elseif ($incident instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(IncidentReporterTableMap::COL_INCIDENT_ID, $incident->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildIncidentReporterQuery The current query, for fluid interface
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
     * Filter the query by a related \Reporter object
     *
     * @param \Reporter|ObjectCollection $reporter The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildIncidentReporterQuery The current query, for fluid interface
     */
    public function filterByReporter($reporter, $comparison = null)
    {
        if ($reporter instanceof \Reporter) {
            return $this
                ->addUsingAlias(IncidentReporterTableMap::COL_REPORTER_ID, $reporter->getId(), $comparison);
        } elseif ($reporter instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(IncidentReporterTableMap::COL_REPORTER_ID, $reporter->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByReporter() only accepts arguments of type \Reporter or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Reporter relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildIncidentReporterQuery The current query, for fluid interface
     */
    public function joinReporter($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Reporter');

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
            $this->addJoinObject($join, 'Reporter');
        }

        return $this;
    }

    /**
     * Use the Reporter relation Reporter object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ReporterQuery A secondary query class using the current class as primary query
     */
    public function useReporterQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinReporter($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Reporter', '\ReporterQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildIncidentReporter $incidentReporter Object to remove from the list of results
     *
     * @return $this|ChildIncidentReporterQuery The current query, for fluid interface
     */
    public function prune($incidentReporter = null)
    {
        if ($incidentReporter) {
            $this->addCond('pruneCond0', $this->getAliasedColName(IncidentReporterTableMap::COL_INCIDENT_ID), $incidentReporter->getIncidentId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(IncidentReporterTableMap::COL_REPORTER_ID), $incidentReporter->getReporterId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the incident_reporter table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(IncidentReporterTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            IncidentReporterTableMap::clearInstancePool();
            IncidentReporterTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(IncidentReporterTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(IncidentReporterTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            IncidentReporterTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            IncidentReporterTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildIncidentReporterQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(IncidentReporterTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildIncidentReporterQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(IncidentReporterTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildIncidentReporterQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(IncidentReporterTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildIncidentReporterQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(IncidentReporterTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildIncidentReporterQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(IncidentReporterTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildIncidentReporterQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(IncidentReporterTableMap::COL_CREATED_AT);
    }

} // IncidentReporterQuery
