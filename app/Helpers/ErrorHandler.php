<?php

namespace App\Helpers;

class ErrorHandler
{
    /**
     * Set a flash message in the session.
     *
     * @param string $key
     * @param string $message
     */
    public static function setFlashMessage(string $key, string $message): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION['flash'][$key] = $message;
    }

    /**
     * Get and clear a flash message from the session.
     *
     * @param string $key
     * @return string|null
     */
    public static function getFlashMessage(string $key): ?string
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (isset($_SESSION['flash'][$key])) {
            $message = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $message;
        }
        return null;
    }

    /**
     * Handle exceptions globally.
     *
     * @param \Throwable $exception
     */
    public static function handleException(\Throwable $exception): void
    {
        echo "🚀 Debugging at " . __FILE__ . ":" . __LINE__ . "\n";
        echo "<pre>";
        print_r($exception->getMessage());
        echo "</pre>";
        die();

        if ($exception instanceof \App\Exceptions\ValidationException) {
            self::setFlashMessage('error', $exception->getMessage());
        } elseif ($exception instanceof \Exception) {
            self::setFlashMessage('error', 'An unexpected error occurred.');
        } else {
            self::setFlashMessage('error', 'An unknown error occurred.');
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}


