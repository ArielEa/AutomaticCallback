<?php

namespace Aia\Packages\MysqlRegister\Mapping;

/**
 * @Annotation
 * @Target("ANNOTATION")
 */
final class UniqueConstraint implements Annotation
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var array<string>
     */
    public $columns;

    /**
     * @var array
     */
    public $options;
}
