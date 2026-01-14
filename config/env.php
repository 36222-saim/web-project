<?php
/**
 * Environment Configuration Loader
 * Loads variables from .env file
 */

class Env {
    private static $loaded = false;
    private static $variables = [];

    /**
     * Load environment variables from .env file
     */
    public static function load($path = null) {
        if (self::$loaded) {
            return;
        }

        // Default to project root
        if ($path === null) {
            $path = dirname(__DIR__) . '/.env';
        }

        // Check if .env file exists
        if (!file_exists($path)) {
            // Fallback to .env.example if .env doesn't exist
            $examplePath = dirname(__DIR__) . '/.env.example';
            if (file_exists($examplePath)) {
                $path = $examplePath;
            } else {
                throw new Exception('.env file not found');
            }
        }

        // Read and parse .env file
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Parse key=value pairs
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);

                $key = trim($key);
                $value = trim($value);

                // Remove quotes if present
                if (preg_match('/^["\'](.*)["\']$/', $value, $matches)) {
                    $value = $matches[1];
                }

                // Store in array and set as environment variable
                self::$variables[$key] = $value;

                // Also set in $_ENV and putenv for compatibility
                $_ENV[$key] = $value;
                putenv("$key=$value");
            }
        }

        self::$loaded = true;
    }

    /**
     * Get an environment variable value
     *
     * @param string $key Variable name
     * @param mixed $default Default value if not found
     * @return mixed
     */
    public static function get($key, $default = null) {
        // Load env if not already loaded
        if (!self::$loaded) {
            self::load();
        }

        // Check in order: $variables array, $_ENV, getenv()
        if (isset(self::$variables[$key])) {
            return self::$variables[$key];
        }

        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }

        $value = getenv($key);
        if ($value !== false) {
            return $value;
        }

        return $default;
    }

    /**
     * Check if an environment variable exists
     *
     * @param string $key Variable name
     * @return bool
     */
    public static function has($key) {
        if (!self::$loaded) {
            self::load();
        }

        return isset(self::$variables[$key]) || isset($_ENV[$key]) || getenv($key) !== false;
    }

    /**
     * Get all environment variables
     *
     * @return array
     */
    public static function all() {
        if (!self::$loaded) {
            self::load();
        }

        return self::$variables;
    }
}

/**
 * Helper function to get environment variable
 *
 * @param string $key Variable name
 * @param mixed $default Default value
 * @return mixed
 */
function env($key, $default = null) {
    return Env::get($key, $default);
}

// Auto-load environment variables
try {
    Env::load();
} catch (Exception $e) {
    // Silently fail if .env not found in development
    // You can log this error in production
}
?>
