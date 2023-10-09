<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\Labeling
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Labeling\Controller;

use phpOMS\Module\ModuleAbstract;
use phpOMS\Module\WebInterface;

/**
 * Budgeting controller class.
 *
 * @package Modules\Labeling
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class Controller extends ModuleAbstract implements WebInterface
{
    /**
     * Module path.
     *
     * @var string
     * @since 1.0.0
     */
    public const PATH = __DIR__ . '/../';

    /**
     * Module version.
     *
     * @var string
     * @since 1.0.0
     */
    public const MODULE_VERSION = '1.0.0';

    /**
     * Module name.
     *
     * @var string
     * @since 1.0.0
     */
    public const MODULE_NAME = 'Labeling';

    /**
     * Module id.
     *
     * @var int
     * @since 1.0.0
     */
    public const MODULE_ID = 1005700000;

    /**
     * Providing.
     *
     * @var string[]
     * @since 1.0.0
     */
    public static array $providing = [];

    /**
     * Dependencies.
     *
     * @var string[]
     * @since 1.0.0
     */
    public static array $dependencies = [];
}
