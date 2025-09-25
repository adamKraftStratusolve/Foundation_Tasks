<?php

class ScriptLogger {
    private string $logFile;
    private float $startTime;

    public function __construct(string $logFile) {
        $this->logFile = $logFile;
        date_default_timezone_set('Africa/Johannesburg');
    }

    public function start() {

        $this->startTime = microtime(true);
        $startDateTime = date('Y-m-d H:i:s');
        $startMessage = "[$startDateTime] --- SCRIPT STARTED ---\n";
        file_put_contents($this->logFile, $startMessage, FILE_APPEND | LOCK_EX);
    }

    public function end() {

        $endTime = microtime(true);
        $endDateTime = date('Y-m-d H:i:s');
        $duration = $endTime - $this->startTime;
        $formattedDuration = number_format($duration, 4);
        $endMessage = "[$endDateTime] --- SCRIPT ENDED---\n--- SCRIPT FINISHED in $formattedDuration seconds ---\n\n";
        file_put_contents($this->logFile, $endMessage, FILE_APPEND | LOCK_EX);
    }
}