<?php
namespace Maksuco\Helpers\Traits;
use Mexitek\PHPColors\Color;
use Exception;

trait Colors {


    public function gradient($originalColor,$amount=17) {
        $color = new Color($originalColor);
        $colors[0] = $originalColor;
        if($color->isLight()){
            $colors[1] = '#'.$color->darken($amount);
        } else {
            $colors[1] = '#'.$color->lighten($amount);
        }
        $colors['css'] = 'linear-gradient(180deg, rgba('.$colors[0].',1) 0%, rgba('.$colors[1].',1) 100%);';
        return $colors;
    }


    private static function sanitizeHex(string $hex): string
    {
        // Strip # sign if it is present
        $color = str_replace("#", "", $hex);

        // Validate hex string
        if (!preg_match('/^[a-fA-F0-9]+$/', $color)) {
            throw new Exception("HEX color does not match format");
        }

        // Make sure it's 6 digits
        if (strlen($color) === 3) {
            $color = $color[0] . $color[0] . $color[1] . $color[1] . $color[2] . $color[2];
        } elseif (strlen($color) !== 6) {
            throw new Exception("HEX color needs to be 6 or 3 digits long");
        }

        return $color;
    }

    public static function hexToHsl(string $color): array
    {
        // Sanity check
        $color = self::sanitizeHex($color);

        // Convert HEX to DEC
        $R = hexdec($color[0] . $color[1]);
        $G = hexdec($color[2] . $color[3]);
        $B = hexdec($color[4] . $color[5]);

        $HSL = array();

        $var_R = ($R / 255);
        $var_G = ($G / 255);
        $var_B = ($B / 255);

        $var_Min = min($var_R, $var_G, $var_B);
        $var_Max = max($var_R, $var_G, $var_B);
        $del_Max = $var_Max - $var_Min;

        $L = ($var_Max + $var_Min) / 2;

        if ($del_Max == 0) {
            $H = 0;
            $S = 0;
        } else {
            if ($L < 0.5) {
                $S = $del_Max / ($var_Max + $var_Min);
            } else {
                $S = $del_Max / (2 - $var_Max - $var_Min);
            }

            $del_R = ((($var_Max - $var_R) / 6) + ($del_Max / 2)) / $del_Max;
            $del_G = ((($var_Max - $var_G) / 6) + ($del_Max / 2)) / $del_Max;
            $del_B = ((($var_Max - $var_B) / 6) + ($del_Max / 2)) / $del_Max;

            if ($var_R == $var_Max) {
                $H = $del_B - $del_G;
            } elseif ($var_G == $var_Max) {
                $H = (1 / 3) + $del_R - $del_B;
            } elseif ($var_B == $var_Max) {
                $H = (2 / 3) + $del_G - $del_R;
            }

            if ($H < 0) {
                $H++;
            }
            if ($H > 1) {
                $H--;
            }
        }

        $HSL['H'] = ($H * 360);
        $HSL['S'] = $S;
        $HSL['L'] = $L;

        return $HSL;
    }

    public static function hslToHex(array $hsl = array()): string
    {
        // Make sure it's HSL
        if (empty($hsl) || !isset($hsl["H"], $hsl["S"], $hsl["L"])) {
            throw new Exception("Param was not an HSL array");
        }

        list($H, $S, $L) = array($hsl['H'] / 360, $hsl['S'], $hsl['L']);

        if ($S == 0) {
            $r = $L * 255;
            $g = $L * 255;
            $b = $L * 255;
        } else {
            if ($L < 0.5) {
                $var_2 = $L * (1 + $S);
            } else {
                $var_2 = ($L + $S) - ($S * $L);
            }

            $var_1 = 2 * $L - $var_2;

            $r = 255 * self::hueToRgb($var_1, $var_2, $H + (1 / 3));
            $g = 255 * self::hueToRgb($var_1, $var_2, $H);
            $b = 255 * self::hueToRgb($var_1, $var_2, $H - (1 / 3));
        }

        // Convert to hex
        $r = dechex(round($r));
        $g = dechex(round($g));
        $b = dechex(round($b));

        // Make sure we get 2 digits for decimals
        $r = (strlen("" . $r) === 1) ? "0" . $r : $r;
        $g = (strlen("" . $g) === 1) ? "0" . $g : $g;
        $b = (strlen("" . $b) === 1) ? "0" . $b : $b;

        return $r . $g . $b;
    }

    public function darken(int $amount = 10): string
    {
        // Darken
        $darkerHSL = $this->darkenHsl($this->_hsl, $amount);
        // Return as HEX
        return self::hslToHex($darkerHSL);
    }

    private function darkenHsl(array $hsl, int $amount = 10): array
    {
        // Check if we were provided a number
        if ($amount) {
            $hsl['L'] = ($hsl['L'] * 100) - $amount;
            $hsl['L'] = ($hsl['L'] < 0) ? 0 : $hsl['L'] / 100;
        } else {
            // We need to find out how much to darken
            $hsl['L'] /= 2;
        }

        return $hsl;
    }

    public function isDark($color = false, int $darkerThan = 130): bool
    {
        // Get our color
        $color = ($color) ? $color : $this->_hex;

        // Calculate straight from rbg
        $r = hexdec($color[0] . $color[1]);
        $g = hexdec($color[2] . $color[3]);
        $b = hexdec($color[4] . $color[5]);

        return (($r * 299 + $g * 587 + $b * 114) / 1000 <= $darkerThan);
    }

    public function lighten(int $amount = 10): string
    {
        // Lighten
        $lighterHSL = $this->lightenHsl($this->_hsl, $amount);
        // Return as HEX
        return self::hslToHex($lighterHSL);
    }

    private function lightenHsl(array $hsl, int $amount = 10): array
    {
        // Check if we were provided a number
        if ($amount) {
            $hsl['L'] = ($hsl['L'] * 100) + $amount;
            $hsl['L'] = ($hsl['L'] > 100) ? 1 : $hsl['L'] / 100;
        } else {
            // We need to find out how much to lighten
            $hsl['L'] += (1 - $hsl['L']) / 2;
        }

        return $hsl;
    }

    public function isLight($color = false, int $lighterThan = 130): bool
    {
        // Get our color
        $color = ($color) ? $color : $this->_hex;

        // Calculate straight from rbg
        $r = hexdec($color[0] . $color[1]);
        $g = hexdec($color[2] . $color[3]);
        $b = hexdec($color[4] . $color[5]);

        return (($r * 299 + $g * 587 + $b * 114) / 1000 > $lighterThan);
    }


    public function mix(string $hex2, int $amount = 0): string
    {
        $rgb2 = self::hexToRgb($hex2);
        $mixed = $this->mixRgb($this->_rgb, $rgb2, $amount);
        // Return as HEX
        return self::rgbToHex($mixed);
    }

}
