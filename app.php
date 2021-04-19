<?php
final class App
{
    
    private static $instances = array();
    
    /**
     * App::__callStatic()
     *
     * @param mixed $name
     * @param mixed $args
     * @return
     */
    public static function __callStatic($name, $args)
    {
        try {
            if (!class_exists($name)) {
                throw new Exception("Class name " . $name . " does not exists.");
            }
            //make a new instance
            if (!in_array($name, array_keys(self::$instances))) {
                //check for arguments
                if (empty($args)) {
                    //new keyword will accept a string in a variable
                    $instance = new $name();
                } else {
                    //we need reflection to instantiate with an arbitrary number of args
                    $rc = new ReflectionClass($name);
                    $instance = $rc->newInstanceArgs($args);
                }
                self::$instances[$name] = $instance;
            } else {
                //already have one
                $instance = self::$instances[$name];
            }
            return $instance;
        }
        catch (exception $e) {
            echo ($e->getMessage());
        }
    }
}