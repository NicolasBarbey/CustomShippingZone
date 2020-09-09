<?php

namespace CustomShippingZone\Model\Base;

use \Exception;
use \PDO;
use CustomShippingZone\Model\CustomShippingZone as ChildCustomShippingZone;
use CustomShippingZone\Model\CustomShippingZoneI18nQuery as ChildCustomShippingZoneI18nQuery;
use CustomShippingZone\Model\CustomShippingZoneQuery as ChildCustomShippingZoneQuery;
use CustomShippingZone\Model\Map\CustomShippingZoneTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'custom_shipping_zone' table.
 *
 *
 *
 * @method     ChildCustomShippingZoneQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCustomShippingZoneQuery orderByTax($order = Criteria::ASC) Order by the tax column
 * @method     ChildCustomShippingZoneQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildCustomShippingZoneQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildCustomShippingZoneQuery groupById() Group by the id column
 * @method     ChildCustomShippingZoneQuery groupByTax() Group by the tax column
 * @method     ChildCustomShippingZoneQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildCustomShippingZoneQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildCustomShippingZoneQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCustomShippingZoneQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCustomShippingZoneQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCustomShippingZoneQuery leftJoinCustomShippingZoneZip($relationAlias = null) Adds a LEFT JOIN clause to the query using the CustomShippingZoneZip relation
 * @method     ChildCustomShippingZoneQuery rightJoinCustomShippingZoneZip($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CustomShippingZoneZip relation
 * @method     ChildCustomShippingZoneQuery innerJoinCustomShippingZoneZip($relationAlias = null) Adds a INNER JOIN clause to the query using the CustomShippingZoneZip relation
 *
 * @method     ChildCustomShippingZoneQuery leftJoinCustomShippingZoneModules($relationAlias = null) Adds a LEFT JOIN clause to the query using the CustomShippingZoneModules relation
 * @method     ChildCustomShippingZoneQuery rightJoinCustomShippingZoneModules($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CustomShippingZoneModules relation
 * @method     ChildCustomShippingZoneQuery innerJoinCustomShippingZoneModules($relationAlias = null) Adds a INNER JOIN clause to the query using the CustomShippingZoneModules relation
 *
 * @method     ChildCustomShippingZoneQuery leftJoinCustomShippingZoneI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the CustomShippingZoneI18n relation
 * @method     ChildCustomShippingZoneQuery rightJoinCustomShippingZoneI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CustomShippingZoneI18n relation
 * @method     ChildCustomShippingZoneQuery innerJoinCustomShippingZoneI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the CustomShippingZoneI18n relation
 *
 * @method     ChildCustomShippingZone findOne(ConnectionInterface $con = null) Return the first ChildCustomShippingZone matching the query
 * @method     ChildCustomShippingZone findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCustomShippingZone matching the query, or a new ChildCustomShippingZone object populated from the query conditions when no match is found
 *
 * @method     ChildCustomShippingZone findOneById(int $id) Return the first ChildCustomShippingZone filtered by the id column
 * @method     ChildCustomShippingZone findOneByTax(double $tax) Return the first ChildCustomShippingZone filtered by the tax column
 * @method     ChildCustomShippingZone findOneByCreatedAt(string $created_at) Return the first ChildCustomShippingZone filtered by the created_at column
 * @method     ChildCustomShippingZone findOneByUpdatedAt(string $updated_at) Return the first ChildCustomShippingZone filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildCustomShippingZone objects filtered by the id column
 * @method     array findByTax(double $tax) Return ChildCustomShippingZone objects filtered by the tax column
 * @method     array findByCreatedAt(string $created_at) Return ChildCustomShippingZone objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildCustomShippingZone objects filtered by the updated_at column
 *
 */
abstract class CustomShippingZoneQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \CustomShippingZone\Model\Base\CustomShippingZoneQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\CustomShippingZone\\Model\\CustomShippingZone', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCustomShippingZoneQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCustomShippingZoneQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \CustomShippingZone\Model\CustomShippingZoneQuery) {
            return $criteria;
        }
        $query = new \CustomShippingZone\Model\CustomShippingZoneQuery();
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
     * @return ChildCustomShippingZone|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CustomShippingZoneTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CustomShippingZoneTableMap::DATABASE_NAME);
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
     * @return   ChildCustomShippingZone A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, TAX, CREATED_AT, UPDATED_AT FROM custom_shipping_zone WHERE ID = :p0';
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
            $obj = new ChildCustomShippingZone();
            $obj->hydrate($row);
            CustomShippingZoneTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCustomShippingZone|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
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
    public function findPks($keys, $con = null)
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
     * @return ChildCustomShippingZoneQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CustomShippingZoneTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildCustomShippingZoneQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CustomShippingZoneTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildCustomShippingZoneQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CustomShippingZoneTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CustomShippingZoneTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomShippingZoneTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the tax column
     *
     * Example usage:
     * <code>
     * $query->filterByTax(1234); // WHERE tax = 1234
     * $query->filterByTax(array(12, 34)); // WHERE tax IN (12, 34)
     * $query->filterByTax(array('min' => 12)); // WHERE tax > 12
     * </code>
     *
     * @param     mixed $tax The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomShippingZoneQuery The current query, for fluid interface
     */
    public function filterByTax($tax = null, $comparison = null)
    {
        if (is_array($tax)) {
            $useMinMax = false;
            if (isset($tax['min'])) {
                $this->addUsingAlias(CustomShippingZoneTableMap::TAX, $tax['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($tax['max'])) {
                $this->addUsingAlias(CustomShippingZoneTableMap::TAX, $tax['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomShippingZoneTableMap::TAX, $tax, $comparison);
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
     * @return ChildCustomShippingZoneQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(CustomShippingZoneTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(CustomShippingZoneTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomShippingZoneTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildCustomShippingZoneQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(CustomShippingZoneTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(CustomShippingZoneTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomShippingZoneTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \CustomShippingZone\Model\CustomShippingZoneZip object
     *
     * @param \CustomShippingZone\Model\CustomShippingZoneZip|ObjectCollection $customShippingZoneZip  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomShippingZoneQuery The current query, for fluid interface
     */
    public function filterByCustomShippingZoneZip($customShippingZoneZip, $comparison = null)
    {
        if ($customShippingZoneZip instanceof \CustomShippingZone\Model\CustomShippingZoneZip) {
            return $this
                ->addUsingAlias(CustomShippingZoneTableMap::ID, $customShippingZoneZip->getCustomShippingZoneId(), $comparison);
        } elseif ($customShippingZoneZip instanceof ObjectCollection) {
            return $this
                ->useCustomShippingZoneZipQuery()
                ->filterByPrimaryKeys($customShippingZoneZip->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCustomShippingZoneZip() only accepts arguments of type \CustomShippingZone\Model\CustomShippingZoneZip or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CustomShippingZoneZip relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCustomShippingZoneQuery The current query, for fluid interface
     */
    public function joinCustomShippingZoneZip($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CustomShippingZoneZip');

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
            $this->addJoinObject($join, 'CustomShippingZoneZip');
        }

        return $this;
    }

    /**
     * Use the CustomShippingZoneZip relation CustomShippingZoneZip object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \CustomShippingZone\Model\CustomShippingZoneZipQuery A secondary query class using the current class as primary query
     */
    public function useCustomShippingZoneZipQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCustomShippingZoneZip($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CustomShippingZoneZip', '\CustomShippingZone\Model\CustomShippingZoneZipQuery');
    }

    /**
     * Filter the query by a related \CustomShippingZone\Model\CustomShippingZoneModules object
     *
     * @param \CustomShippingZone\Model\CustomShippingZoneModules|ObjectCollection $customShippingZoneModules  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomShippingZoneQuery The current query, for fluid interface
     */
    public function filterByCustomShippingZoneModules($customShippingZoneModules, $comparison = null)
    {
        if ($customShippingZoneModules instanceof \CustomShippingZone\Model\CustomShippingZoneModules) {
            return $this
                ->addUsingAlias(CustomShippingZoneTableMap::ID, $customShippingZoneModules->getCustomShippingZoneId(), $comparison);
        } elseif ($customShippingZoneModules instanceof ObjectCollection) {
            return $this
                ->useCustomShippingZoneModulesQuery()
                ->filterByPrimaryKeys($customShippingZoneModules->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCustomShippingZoneModules() only accepts arguments of type \CustomShippingZone\Model\CustomShippingZoneModules or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CustomShippingZoneModules relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCustomShippingZoneQuery The current query, for fluid interface
     */
    public function joinCustomShippingZoneModules($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CustomShippingZoneModules');

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
            $this->addJoinObject($join, 'CustomShippingZoneModules');
        }

        return $this;
    }

    /**
     * Use the CustomShippingZoneModules relation CustomShippingZoneModules object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \CustomShippingZone\Model\CustomShippingZoneModulesQuery A secondary query class using the current class as primary query
     */
    public function useCustomShippingZoneModulesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCustomShippingZoneModules($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CustomShippingZoneModules', '\CustomShippingZone\Model\CustomShippingZoneModulesQuery');
    }

    /**
     * Filter the query by a related \CustomShippingZone\Model\CustomShippingZoneI18n object
     *
     * @param \CustomShippingZone\Model\CustomShippingZoneI18n|ObjectCollection $customShippingZoneI18n  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomShippingZoneQuery The current query, for fluid interface
     */
    public function filterByCustomShippingZoneI18n($customShippingZoneI18n, $comparison = null)
    {
        if ($customShippingZoneI18n instanceof \CustomShippingZone\Model\CustomShippingZoneI18n) {
            return $this
                ->addUsingAlias(CustomShippingZoneTableMap::ID, $customShippingZoneI18n->getId(), $comparison);
        } elseif ($customShippingZoneI18n instanceof ObjectCollection) {
            return $this
                ->useCustomShippingZoneI18nQuery()
                ->filterByPrimaryKeys($customShippingZoneI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCustomShippingZoneI18n() only accepts arguments of type \CustomShippingZone\Model\CustomShippingZoneI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CustomShippingZoneI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCustomShippingZoneQuery The current query, for fluid interface
     */
    public function joinCustomShippingZoneI18n($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CustomShippingZoneI18n');

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
            $this->addJoinObject($join, 'CustomShippingZoneI18n');
        }

        return $this;
    }

    /**
     * Use the CustomShippingZoneI18n relation CustomShippingZoneI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \CustomShippingZone\Model\CustomShippingZoneI18nQuery A secondary query class using the current class as primary query
     */
    public function useCustomShippingZoneI18nQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinCustomShippingZoneI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CustomShippingZoneI18n', '\CustomShippingZone\Model\CustomShippingZoneI18nQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCustomShippingZone $customShippingZone Object to remove from the list of results
     *
     * @return ChildCustomShippingZoneQuery The current query, for fluid interface
     */
    public function prune($customShippingZone = null)
    {
        if ($customShippingZone) {
            $this->addUsingAlias(CustomShippingZoneTableMap::ID, $customShippingZone->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the custom_shipping_zone table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CustomShippingZoneTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CustomShippingZoneTableMap::clearInstancePool();
            CustomShippingZoneTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildCustomShippingZone or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildCustomShippingZone object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CustomShippingZoneTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CustomShippingZoneTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        CustomShippingZoneTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CustomShippingZoneTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     ChildCustomShippingZoneQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(CustomShippingZoneTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildCustomShippingZoneQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(CustomShippingZoneTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     ChildCustomShippingZoneQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(CustomShippingZoneTableMap::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     ChildCustomShippingZoneQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(CustomShippingZoneTableMap::UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     ChildCustomShippingZoneQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(CustomShippingZoneTableMap::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     ChildCustomShippingZoneQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(CustomShippingZoneTableMap::CREATED_AT);
    }

    // i18n behavior

    /**
     * Adds a JOIN clause to the query using the i18n relation
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildCustomShippingZoneQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'en_US', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'CustomShippingZoneI18n';

        return $this
            ->joinCustomShippingZoneI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildCustomShippingZoneQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'en_US', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('CustomShippingZoneI18n');
        $this->with['CustomShippingZoneI18n']->setIsWithOneToMany(false);

        return $this;
    }

    /**
     * Use the I18n relation query object
     *
     * @see       useQuery()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildCustomShippingZoneI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'en_US', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CustomShippingZoneI18n', '\CustomShippingZone\Model\CustomShippingZoneI18nQuery');
    }

} // CustomShippingZoneQuery
