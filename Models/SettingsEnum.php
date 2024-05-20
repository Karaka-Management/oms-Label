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

use phpOMS\Stdlib\Base\Enum;

/**
 * Module settings enum.
 *
 * @package  Modules\Labeling\Models
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 */
abstract class SettingsEnum extends Enum
{
    public const DEFAULT_LABEL = '1005100001';
}
