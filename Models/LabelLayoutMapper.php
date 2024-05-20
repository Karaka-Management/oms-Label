<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Labeling\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Labeling\Models;

use Modules\Media\Models\CollectionMapper;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Labeling mapper class.
 *
 * @package Modules\Labeling\Models
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of LabelLayout
 * @extends DataMapperFactory<T>
 */
final class LabelLayoutMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'labeling_layout_id'       => ['name' => 'labeling_layout_id',             'type' => 'int',    'internal' => 'id'],
        'labeling_layout_template' => ['name' => 'labeling_layout_template',  'type' => 'int',    'internal' => 'template'],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:class-string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    public const HAS_MANY = [
        'l11n' => [
            'mapper'   => LabelLayoutL11nMapper::class,
            'table'    => 'labeling_layout_l11n',
            'self'     => 'labeling_layout_l11n_type',
            'column'   => 'content',
            'external' => null,
        ],
    ];

    /**
     * Has one relation.
     *
     * @var array<string, array{mapper:class-string, external:string, by?:string, column?:string, conditional?:bool}>
     * @since 1.0.0
     */
    public const OWNS_ONE = [
        'template' => [
            'mapper'   => CollectionMapper::class,
            'external' => 'labeling_layout_template',
        ],
    ];

    /**
     * Model to use by the mapper.
     *
     * @var class-string<T>
     * @since 1.0.0
     */
    public const MODEL = LabelLayout::class;

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'labeling_layout';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'labeling_layout_id';
}
