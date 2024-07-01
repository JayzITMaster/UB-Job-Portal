<?php

class Logger {

    public function __construct() {
    }

    public function debug($message) {
        if (ENVIRONMENT === 'development') {
            $logMessage = $this->formatLogMessage('DEBUG', $message);
            $this->writeToLog($logMessage);
        }
    }
    public function error($message) {
        $logMessage = $this->formatLogMessage('ERROR', $message);
        $this->writeToLog($logMessage);
    }
    public function info($message) {
        $logMessage = $this->formatLogMessage('INFO', $message);
        $this->writeToLog($logMessage);
    }

    private function formatLogMessage($level, $message) {
        $timestamp = date('Y-m-d H:i:s');
        return "[$timestamp][$level] $message\n";
    }

    private function ensureLogFolderExists() {
        $logFolder = '../log/';

        if (!file_exists($logFolder) || !is_dir($logFolder)) {
            // Create the log folder if it doesn't exist
            mkdir($logFolder, 0755, true);

            // Check if the folder was created successfully
            if (!is_dir($logFolder)) {
                throw new Exception("Failed to create log folder: $logFolder");
            }
        }
    }

    private function writeToLog($logMessage) {
        //come out of the inc or views folder and the src folder
        $logFile = '../log/' . date('Y-m-d') . '.log'; // Add a directory separator here
        
        $this->ensureLogFolderExists();

        // echo $logFile;
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }
}
