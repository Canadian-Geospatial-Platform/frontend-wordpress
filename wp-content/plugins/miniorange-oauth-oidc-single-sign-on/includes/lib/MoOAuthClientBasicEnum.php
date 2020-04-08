<?php


abstract class MoOAuthClientBasicEnum
{
    private static $constCacheArray = NULL;
    public static function getConstants()
    {
        if (!(self::$constCacheArray == NULL)) {
            goto IKs;
        }
        self::$constCacheArray = array();
        IKs:
        $vh = get_called_class();
        if (array_key_exists($vh, self::$constCacheArray)) {
            goto jOT;
        }
        $N7 = new ReflectionClass($vh);
        self::$constCacheArray[$vh] = $N7->getConstants();
        jOT:
        return self::$constCacheArray[$vh];
    }
    public static function isValidName($ts, $vN = false)
    {
        $RD = self::getConstants();
        if (!$vN) {
            goto SZ7;
        }
        return array_key_exists($ts, $RD);
        SZ7:
        $YI = array_map("\x73\164\162\164\x6f\x6c\x6f\x77\145\x72", array_keys($RD));
        return in_array(strtolower($ts), $YI);
    }
    public static function isValidValue($sw, $vN = true)
    {
        $n4 = array_values(self::getConstants());
        return in_array($sw, $n4, $vN);
    }
}
