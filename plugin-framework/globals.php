<?php
namespace pluginone\framework;

if(!defined('ABSPATH')){
    exit;
}
class Globals{
    
    public static $FWDIGI_PLUGINID = '';
    public static $FWDIGI_PLUGSLUG = '';
    public static $FWDIGI_PLUGNAME = '';
    public static $FWDIGI_PATHSLUG = '';
    public static $FWDIGI_PATHTOFWASSET = '';
    public static $FWDIGI_URL = '';


    public function __construct(){
        self::$FWDIGI_PATHSLUG = constant('D1G1_PLUGSLUG_'.D1G1_PLUGINIDONE);
        self::$FWDIGI_PLUGNAME = constant('D1G1_PLUGNAME_'.D1G1_PLUGINIDONE);
        self::$FWDIGI_PATHSLUG = constant('D1G1_PATHS_'.D1G1_PLUGINIDONE);
        self::$FWDIGI_PATHTOFWASSET = constant('D1G1_PATHTOFWASSET_'.D1G1_PLUGINIDONE);
        self::$FWDIGI_URL = constant('D1G1_URL_'.D1G1_PLUGINIDONE);
        self::$FWDIGI_PLUGINID = D1G1_PLUGINIDONE;

    }
}
new Globals;

