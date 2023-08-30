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

class Shape
{
    public int $x = 0;

    public int $y = 0;

    public int $x2 = 0;

    public int $y2 = 0;

    public int $type = ShapeType::RECTANGLE;

    public int $color = 0;

    public int $borderThickness = 1;

    public int $fillColor = -1;
}
