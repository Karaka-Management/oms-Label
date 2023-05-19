<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Modules\Labeling\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\Labeling\Admin;

use phpOMS\Module\UpdaterAbstract;

/**
 * Updater class.
 *
 * @package Modules\Labeling\Admin
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class Updater extends UpdaterAbstract
{
    /**
     * Path of the file
     *
     * @var string
     * @since 1.0.0
     */
    public const PATH = __DIR__;
}
