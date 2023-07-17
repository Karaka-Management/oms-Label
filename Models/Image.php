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
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\Labeling\Models;

class Image
{
    public int $x = 0;
    public int $y = 0;

    public float $ratio = 0.0;
    public int $x2 = 0;
    public int $y2 = 0;

    public string $src = '';
    public $resource = null;
    public int $color = 0;
}