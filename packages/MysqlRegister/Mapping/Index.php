<?php

namespace Aia\Packages\MysqlRegister\Mapping;

/**
 * @Annotation
 * @Target("ANNOTATION")
 */
final class Index implements Annotation
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
     * @var array<string>
     */
    public $flags;

    /**
     * @var array
     */
    public $options;
}
