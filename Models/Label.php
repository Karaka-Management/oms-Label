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
 * Label.
 *
 * @package Modules\Labeling\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class Label
{
    public int $width = 50;

    public int $height = 25;

    public int $fillColor = -1;

    public string $unit = 'cm';

    public array $elements = [];

    /**
     * Render label
     *
     * @return null|\GdImage
     *
     * @since 1.0.0
     */
    public function render() : ?\GdImage
    {
        $im = \imagecreatetruecolor((int) (37.8 * $this->width), (int) (37.8 * $this->height));
        if ($im === false) {
            return null;
        }

        $bg = \imagecolorallocatealpha($im, 255, 255, 255, 0);
        if ($bg === false) {
            return null;
        }

        \imagefill($im, 0, 0, $bg);

        /*
        $black = \imagecolorallocate($im, 0, 0, 0);
        \imagecolortransparent($im, $black);
        \imagealphablending($im, false);
        \imagesavealpha($im, true);
        */

        foreach ($this->elements as $element) {
            $color = 0;

            // @todo: replace int type with enum
            if ($element instanceof Shape) {
                if ($element->type === 1) {
                    // Line
                    if ($element->borderThickness === 1) {
                        \imageline($im, $element->x, $element->y, $element->x2, $element->y2, $color);
                    } else {
                        \imagefilledrectangle(
                            $im,
                            $element->x, $element->y,
                            $element->x2 + $element->borderThickness - 1, $element->y2 + $element->borderThickness - 1,
                            $color
                        );
                    }
                } elseif ($element->type === 2) {
                    // Rectangle
                    \imagefilledrectangle(
                        $im,
                        $element->x, $element->y,
                        $element->x2 + $element->borderThickness, $element->y2 + $element->borderThickness,
                        $color
                    );

                    if ($element->fillColor === -1) {
                        \imagefilledrectangle(
                            $im,
                            $element->x + $element->borderThickness, $element->y + $element->borderThickness,
                            $element->x2, $element->y2,
                            $bg
                        );
                    }
                }

                // @todo: implement circle + elipse
            } elseif ($element instanceof Text) {
                \imagettftext($im, $element->size, 0, $element->x, $element->y, $color, $element->font, $element->text);
            } elseif ($element instanceof Image) {
                $in = $element->resource === null ? \imagecreatefrompng(__DIR__ . '/../../..' . $element->src) : $element->resource;
                if ($in === false) {
                    return null;
                }

                $srcW = \imagesx($in);
                $srcH = \imagesy($in);

                // should resize
                // @todo: impl. skewing
                if ($element->ratio !== 0.0 || $element->x2 !== 0 || $element->y2 !== 0) {
                    $ratio = $element->ratio;
                    if ($ratio === 0.0) {
                        $ratio = ($element->x2 - $element->x) / $srcW;
                    }

                    $newW = (int) ($srcW * $ratio);
                    $newH = (int) ($srcH * $ratio);

                    $newIn = \imagecreatetruecolor($newW, $newH);
                    if ($newIn === false) {
                        return null;
                    }

                    $transparency = \imagecolorallocatealpha($newIn, 0, 0, 0, 127);
                    if ($transparency === false) {
                        return null;
                    }

                    \imagecolortransparent($newIn, $transparency);
                    \imagealphablending($newIn, false);
                    \imagesavealpha($newIn, true);

                    \imagecopyresampled(
                        $newIn, $in,
                        0, 0,
                        0, 0,
                        $newW, $newH,
                        $srcW, $srcH
                    );

                    $srcW = $newW;
                    $srcH = $newH;

                    \imagedestroy($in);

                    $in = $newIn;
                }

                $cut = \imagecreatetruecolor($srcW, $srcH);
                if ($cut === false) {
                    return null;
                }

                \imagecopy($cut, $im, 0, 0, $element->x, $element->y, $srcW, $srcH);
                \imagecopy($cut, $in, 0, 0, 0, 0, $srcW, $srcH);
                \imagecopymerge(
                    $im, $cut,
                    $element->x, $element->y,
                    0, 0,
                    $srcW, $srcH,
                    100
                );

                \imagedestroy($in);
                \imagedestroy($cut);
            }
        }

        return $im;
    }
}
