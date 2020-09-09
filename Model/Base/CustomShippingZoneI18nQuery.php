<?php

namespace CustomShippingZone\Model\Base;

use \Exception;
use \PDO;
use CustomShippingZone\Model\CustomShippingZoneI18n as ChildCustomShippingZoneI18n;
use CustomShippingZone\Model\CustomShippingZoneI18nQuery as ChildCustomShippingZoneI18nQuery;
use CustomShippingZone\Model\Map\CustomShippingZoneI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'custom_shipping_zone_i18n' table.
 *
 *
 *
 * @method     ChildCustomShippingZoneI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCustomShippingZoneI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildCustomShippingZoneI18nQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildCustomShippingZoneI18nQuery orderByDescription($order = Criteria::ASC) Order by the description column
 *
 * @method     ChildCustomShippingZoneI18nQuery groupById() Group by the id column
 * @method     ChildCustomShippingZoneI18nQuery groupByLocale() Group by the locale column
 * @method     ChildCustomShippingZoneI18nQuery groupByName() Group by the name column
 * @method     ChildCustomShippingZoneI18nQuery groupByDescription() Group by the description column
 *
 * @method     ChildCustomShippingZoneI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCustomShippingZoneI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCustomShippingZoneI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCustomShippingZoneI18nQuery leftJoinCustomShippingZone($relationAlias = null) Adds a LEFT JOIN clause to the query using the CustomShippingZone relation
 * @method     ChildCustomShippingZoneI18nQuery rightJoinCustomShippingZone($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CustomShippingZone relation
 * @method     ChildCustomShippingZoneI18nQuery innerJoinCustomShippingZone($relationAlias = null) Adds a INNER JOIN clause to the query using the CustomShippingZone relation
 *
 * @method     ChildCustomShippingZoneI18n findOne(ConnectionInterface $con = null) Return the first ChildCustomShippingZoneI18n matching the query
 * @method     ChildCustomShippingZoneI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCustomShippingZoneI18n matching the query, or a new ChildCustomShippingZoneI18n object populated from the query conditions when no match is found
 *
 * @method     ChildCustomShippingZoneI18n findOneById(int $id) Return the first ChildCustomShippingZoneI18n filtered by the id column
 * @method     ChildCustomShippingZoneI18n findOneByLocale(string $locale) Return the first ChildCustomShippingZoneI18n filtered by the locale column
 * @method     ChildCustomShippingZoneI18n findOneByName(string $name) Return the first ChildCustomShippingZoneI18n filtered by the name column
 * @method     ChildCustomShippingZoneI18n findOneByDescription(string $description) Return the first ChildCustomShippingZoneI18n filtered by the description column
 *
 * @method     array findById(int $id) Return ChildCustomShippingZoneI18n objects filtered by the id column
 * @method     array findByLocale(string $locale) Return ChildCustomShippingZoneI18n objects filtered by the locale column
 * @method     array findByName(string $name) Return ChildCustomShippingZoneI18n objects filtered by the name column
 * @method     array findByDescription(string $description) Return ChildCustomShippingZoneI18n objects filtered by the description column
 *
 */
abstract class CustomShippingZoneI18nQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \CustomShippingZone\Model\Base\CustomShippingZoneI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\CustomShippingZone\\Model\\CustomShippingZoneI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCustomShippingZoneI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCustomShippingZoneI18nQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \CustomShippingZone\Model\CustomShippingZoneI18nQuery) {
            return $criteria;
        }
        $query = new \CustomShippingZone\Model\CustomShippingZoneI18nQuery();
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
     * @param array[$id, $locale] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCustomShippingZoneI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CustomShippingZoneI18nTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CustomShippingZoneI18nTableMap::DATABASE_NAME);
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
     * @return   ChildCustomShippingZoneI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, LOCALE, NAME, DESCRIPTION FROM custom_shipping_zone_i18n WHERE ID = :p0 AND LOCALE = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildCustomShippingZoneI18n();
            $obj->hydrate($row);
            CustomShippingZoneI18nTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildCustomShippingZoneI18n|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return ChildCustomShippingZoneI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(CustomShippingZoneI18nTableMap::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(CustomShippingZoneI18nTableMap::LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildCustomShippingZoneI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(CustomShippingZoneI18nTableMap::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(CustomShippingZoneI18nTableMap::LOCALE, $key[1], Criteria::EQUAL);
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
     * @see       filterByCustomShippingZone()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomShippingZoneI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CustomShippingZoneI18nTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CustomShippingZoneI18nTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomShippingZoneI18nTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the locale column
     *
     * Example usage:
     * <code>
     * $query->filterByLocale('fooValue');   // WHERE locale = 'fooValue'
     * $query->filterByLocale('%fooValue%'); // WHERE locale LIKE '%fooValue%'
     * </code>
     *
     * @param     string $locale The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomShippingZoneI18nQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $locale)) {
                $locale = str_replace('*', '%', $locale);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CustomShippingZoneI18nTableMap::LOCALE, $locale, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomShippingZoneI18nQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CustomShippingZoneI18nTableMap::NAME, $name, $comparison);
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
     * @return ChildCustomShippingZoneI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CustomShippingZoneI18nTableMap::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query by a related \CustomShippingZone\Model\CustomShippingZone object
     *
     * @param \CustomShippingZone\Model\CustomShippingZone|ObjectCollection $customShippingZone The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomShippingZoneI18nQuery The current query, for fluid interface
     */
    public function filterByCustomShippingZone($customShippingZone, $comparison = null)
    {
        if ($customShippingZone instanceof \CustomShippingZone\Model\CustomShippingZone) {
            return $this
                ->addUsingAlias(CustomShippingZoneI18nTableMap::ID, $customShippingZone->getId(), $comparison);
        } elseif ($customShippingZone instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CustomShippingZoneI18nTableMap::ID, $customShippingZone->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCustomShippingZone() only accepts arguments of type \CustomShippingZone\Model\CustomShippingZone or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CustomShippingZone relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCustomShippingZoneI18nQuery The current query, for fluid interface
     */
    public function joinCustomShippingZone($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CustomShippingZone');

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
            $this->addJoinObject($join, 'CustomShippingZone');
        }

        return $this;
    }

    /**
     * Use the CustomShippingZone relation CustomShippingZone object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \CustomShippingZone\Model\CustomShippingZoneQuery A secondary query class using the current class as primary query
     */
    public function useCustomShippingZoneQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinCustomShippingZone($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CustomShippingZone', '\CustomShippingZone\Model\CustomShippingZoneQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCustomShippingZoneI18n $customShippingZoneI18n Object to remove from the list of results
     *
     * @return ChildCustomShippingZoneI18nQuery The current query, for fluid interface
     */
    public function prune($customShippingZoneI18n = null)
    {
        if ($customShippingZoneI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(CustomShippingZoneI18nTableMap::ID), $customShippingZoneI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(CustomShippingZoneI18nTableMap::LOCALE), $customShippingZoneI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the custom_shipping_zone_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CustomShippingZoneI18nTableMap::DATABASE_NAME);
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
            CustomShippingZoneI18nTableMap::clearInstancePool();
            CustomShippingZoneI18nTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildCustomShippingZoneI18n or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildCustomShippingZoneI18n object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CustomShippingZoneI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CustomShippingZoneI18nTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        CustomShippingZoneI18nTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CustomShippingZoneI18nTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // CustomShippingZoneI18nQuery
