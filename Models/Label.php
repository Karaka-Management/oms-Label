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

            // @todo replace int type with enum
            if ($element instanceof Shape) {
                if ($element->type === ShapeType::LINE) {
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
                } elseif ($element->type === ShapeType::RECTANGLE) {
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
                } elseif ($element->type === ShapeType::ELLIPSE) {
                    if ($element->fillColor === -1) {
                        \imageellipse(
                            $im,
                            $element->x, $element->y,
                            $element->x2, $element->y2,
                            $bg
                        );
                    } else {
                        \imagefilledellipse(
                            $im,
                            $element->x, $element->y,
                            $element->x2, $element->y2,
                            $bg
                        );
                    }
                }
            } elseif ($element instanceof Text) {
                \imagettftext($im, $element->size, 0, $element->x, $element->y, $color, $element->font, $element->text);
            } elseif ($element instanceof Image) {
                $in = $element->resource === null ? \imagecreatefrompng(__DIR__ . '/../../..' . $element->src) : $element->resource;
                if ($in === false) {
                    return null;
                }

                \imagealphablending($in, false);
                \imagesavealpha($in, true);

                $transparency = \imagecolorallocatealpha($in, 0, 0, 0, 127);
                if ($transparency === false) {
                    return null;
                }

                $srcW = \imagesx($in);
                $srcH = \imagesy($in);

                // should crop
                if ($element->x1 !== 0 || $element->x2 !== 0 || $element->y1 !== 0 || $element->y2 !== 0) {
                    $cropped = \imagecrop($in, [
                        'x'      => $element->x1,
                        'y'      => $element->y1,
                        'width'  => $element->x2 === 0 ? $srcW - $element->x1 : $element->x2 - $element->x1,
                        'height' => $element->y2 === 0 ? $srcH - $element->y1 : $element->y2 - $element->y1,
                    ]);

                    if ($cropped === false) {
                        return null;
                    }

                    /*
                    $newIn = \imagecreatetruecolor($crop['width'], $crop['height']);
                    if ($newIn === false) {
                        return null;
                    }

                    \imagecolortransparent($newIn, $transparency);
                    \imagealphablending($newIn, false);
                    \imagesavealpha($newIn, true);

                    \imagecopyresampled(
                        $newIn, $cropped,
                        0, 0,
                        0, 0,
                        $crop['width'], $crop['height'],
                        $srcW, $srcH
                    );

                    $srcW = \imagesx($newIn);
                    $srcH = \imagesy($newIn);
                    */

                    $srcW = \imagesx($cropped);
                    $srcH = \imagesy($cropped);

                    \imagedestroy($in);

                    $in = $cropped;
                }

                // should resize
                if ($element->ratio !== 0.0 || $element->width !== 0 || $element->height !== 0) {
                    $ratioX = $element->ratio === 0.0 ? $element->width / $srcW : $element->ratio;
                    $ratioY = $element->ratio === 0.0 ? $element->height / $srcH : $element->ratio;

                    $ratioX = \abs($ratioX);
                    $ratioY = \abs($ratioY);

                    if ($ratioX === 0.0) {
                        $ratioX = $ratioY;
                    }

                    if ($ratioY === 0.0) {
                        $ratioY = $ratioX;
                    }

                    // @todo handle use original width or height but resize height or width.

                    $newW = (int) ($srcW * $ratioX);
                    $newH = (int) ($srcH * $ratioY);

                    $newIn = \imagecreatetruecolor($newW, $newH);
                    if ($newIn === false) {
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

                // should rotate
                if ($element->rotate !== 0.0) {
                    $rotated = \imagerotate($in, $element->rotate, $transparency);
                    \imagealphablending($rotated, false);
                    \imagesavealpha($rotated, true);

                    $srcW = \imagesx($rotated);
                    $srcH = \imagesy($rotated);

                    \imagedestroy($in);

                    $in = $rotated;
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
