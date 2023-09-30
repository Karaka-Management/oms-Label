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

/**
 * Shape.
 *
 * @package Modules\Labeling\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class Text
{
    public int $x = 0;

    public int $y = 0;

    public int $x2 = 0;

    public int $y2 = 0;

    public int $size = 11;

    public string $font = __DIR__ . '/../../../Resources/fonts/lato/Lato-Regular.ttf';

    public string $text = '';

    public int $color = 0;

    // align (-1 = start, 0 = middle, 1 = end)
    public int $alignX = -1;

    public int $alignY = -1;

    public bool $bold = false;

    public bool $underline = false;

    public bool $italic = false;
}
