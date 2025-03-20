<?php

class Logger
{
    public string $path = 'logs';
    private static Logger $instance;
    private function __construct() {}
    private function __wakeup() {}
    private function __clone() {}

    public static function getInstance(): ?Logger
    {
        if (!isset(Logger::$instance)) {
            Logger::$instance = new Logger();
        }

        return Logger::$instance;
    }

    public function setLog(string $lvl, string $message): void
    {
        $currentDate = date('Y-m-d');
        $file = "{$this->path}/{$currentDate}.log";
        $log = '';

        if (file_exists($file)) {
            $log .= file_get_contents($file);
            $log .= "\n";
        }

        $log .= "[{$lvl}] : {$message}";

        file_put_contents($file, $log);
    }

    public function getLog(?string $date = null): string
    {
        if (!isset($date)) $date = date('Y-m-d');

        $file = "{$this->path}/{$date}.log";

        return file_get_contents($file);
    }
}

$loggerInstance = Logger::getInstance();
$loggerInstance->setLog('ERROR', 'Произошла ошибка');
$loggerInstance->setLog('INFO', 'Инфо пример');

$loggerInstance2 = Logger::getInstance();
$result = $loggerInstance2->getLog();

echo $result;