<?php


namespace Aia\Packages\MysqlRegister\Mapping;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class Table implements Annotation
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $schema;

    /**
     * @var array<Index>
     */
    public $indexes;

    /**
     * @var array<UniqueConstraint>
     */
    public $uniqueConstraints;

    /**
     * @var array
     */
    public $options = array();
}

