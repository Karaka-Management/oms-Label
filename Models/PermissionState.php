<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules\Labeling\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\Labeling\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Permision state enum.
 *
 * @package Modules\Labeling\Models
 * @license OMS License 2.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
abstract class PermissionState extends Enum
{
    public const LABEL = 1;
}
