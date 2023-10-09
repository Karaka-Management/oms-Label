<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\Labeling\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Labeling\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Shape type enum.
 *
 * @package Modules\Labeling\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
abstract class ShapeType extends Enum
{
    public const LINE = 1;

    public const RECTANGLE = 2;

    public const CIRCLE = 3;

    public const TRIANGLE = 4;
}
