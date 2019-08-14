<?php

class DLS_Utility_Helper_Color
{
    const IS_LIGHT_COLOR_RGB_THRESHOLD = 650;

    public function isColorDark($color_as_hex_rgb)
    {
        // If the color has # in front of it, remove it
        $first_char = substr($color_as_hex_rgb, 0, 1);
        if (!strcmp('#', $first_char))
        {
            $color_as_hex_rgb = substr($color_as_hex_rgb, 1);
        }

        // MUST DO SOME MORE ERROR CHECKING HERE
        $r_hex_value = substr($color_as_hex_rgb, 0, 2);
        $g_hex_value = substr($color_as_hex_rgb, 2, 2);
        $b_hex_value = substr($color_as_hex_rgb, 4, 2);

        $r_int_value = hexdec($r_hex_value);
        $g_int_value = hexdec($g_hex_value);
        $b_int_value = hexdec($b_hex_value);

        $rgb_int_sum = $r_int_value + $g_int_value + $b_int_value;

        return ($rgb_int_sum <= self::IS_LIGHT_COLOR_RGB_THRESHOLD);
    }
}
