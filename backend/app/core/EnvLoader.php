<?php 

namespace app\core;

class EnvLoader
{

    private static $loaded = false;

    public static function load()
    {

        if (self::$loaded) {
            return;
        }

        $dotenv =  __DIR__ . '/../../.env';

        if (file_exists($dotenv)) {
            $lines = file($dotenv, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($lines as $line) {
                if (strpos(trim($line), '#') === 0) {
                    continue;
                }

                [$name, $value] = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);

                if (!array_key_exists($name, $_ENV)) {
                    $_ENV[$name] = $value;
                    putenv("$name=$value");
                }
            }

        } else {
            throw new \Exception('No .env file found');
        }

        self::$loaded = true;
    }
}