<?php

namespace Aia\Packages\MysqlRegister\Mapping;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class GeneratedValue implements Annotation
{
    /**
     * The type of Id generator.
     *
     * @var string
     *
     * @Enum({"AUTO", "SEQUENCE", "TABLE", "IDENTITY", "NONE", "UUID", "CUSTOM"})
     */
    public $strategy = 'AUTO';
}
