<?php

namespace ContainerApKIbKM;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{

    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolder76e7e = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer3424f = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicPropertiesa5826 = [
        
    ];

    public function getConnection()
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'getConnection', array(), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'getMetadataFactory', array(), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'getExpressionBuilder', array(), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'beginTransaction', array(), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->beginTransaction();
    }

    public function getCache()
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'getCache', array(), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->getCache();
    }

    public function transactional($func)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'transactional', array('func' => $func), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->transactional($func);
    }

    public function wrapInTransaction(callable $func)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'wrapInTransaction', array('func' => $func), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->wrapInTransaction($func);
    }

    public function commit()
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'commit', array(), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->commit();
    }

    public function rollback()
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'rollback', array(), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'getClassMetadata', array('className' => $className), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'createQuery', array('dql' => $dql), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'createNamedQuery', array('name' => $name), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'createQueryBuilder', array(), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'flush', array('entity' => $entity), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'clear', array('entityName' => $entityName), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->clear($entityName);
    }

    public function close()
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'close', array(), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->close();
    }

    public function persist($entity)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'persist', array('entity' => $entity), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'remove', array('entity' => $entity), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'refresh', array('entity' => $entity), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'detach', array('entity' => $entity), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'merge', array('entity' => $entity), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'getRepository', array('entityName' => $entityName), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'contains', array('entity' => $entity), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'getEventManager', array(), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'getConfiguration', array(), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'isOpen', array(), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'getUnitOfWork', array(), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'getProxyFactory', array(), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'initializeObject', array('obj' => $obj), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'getFilters', array(), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'isFiltersStateClean', array(), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'hasFilters', array(), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return $this->valueHolder76e7e->hasFilters();
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();

        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $instance, 'Doctrine\\ORM\\EntityManager')->__invoke($instance);

        $instance->initializer3424f = $initializer;

        return $instance;
    }

    protected function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config, \Doctrine\Common\EventManager $eventManager)
    {
        static $reflection;

        if (! $this->valueHolder76e7e) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolder76e7e = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolder76e7e->__construct($conn, $config, $eventManager);
    }

    public function & __get($name)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, '__get', ['name' => $name], $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        if (isset(self::$publicPropertiesa5826[$name])) {
            return $this->valueHolder76e7e->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder76e7e;

            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder76e7e;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder76e7e;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder76e7e;
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;

            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, '__isset', array('name' => $name), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder76e7e;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolder76e7e;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, '__unset', array('name' => $name), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder76e7e;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolder76e7e;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);

            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }

    public function __clone()
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, '__clone', array(), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        $this->valueHolder76e7e = clone $this->valueHolder76e7e;
    }

    public function __sleep()
    {
        $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, '__sleep', array(), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;

        return array('valueHolder76e7e');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializer3424f = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializer3424f;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer3424f && ($this->initializer3424f->__invoke($valueHolder76e7e, $this, 'initializeProxy', array(), $this->initializer3424f) || 1) && $this->valueHolder76e7e = $valueHolder76e7e;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder76e7e;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolder76e7e;
    }


}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
