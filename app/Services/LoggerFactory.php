<?php

namespace App\Services;

use Closure;

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

class LoggerFactory
{

    protected $logPath = 'logs';

    public function setPath($logPath)
    {
        $this->logPath = $logPath;
        return $this;
    }

    public function createLogger($logger_name, $format = null, Closure $processor = null)
    {
        $format = $format ?: "[%datetime%][%level_name%] %message% %context% %extra%\n";
        $path = $this->loggerDirectoryPath() . "/" . $logger_name . ".log";

        $handler = new RotatingFileHandler($path);
        $handler->setFormatter(new LineFormatter($format, null, true, true));

        $logger = new Logger($logger_name);
        $logger->pushHandler($handler);

        if ($processor) {
            $logger->pushProcessor($processor);
        }

        return $logger;
    }

    protected function loggerDirectoryPath()
    {
        return storage_path($this->logPath);
    }
}
