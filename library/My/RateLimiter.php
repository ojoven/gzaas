<?php

class My_RateLimiter
{
    public static function check($bucket, $identifier, $limit, $windowSeconds)
    {
        $limit = max(1, (int) $limit);
        $windowSeconds = max(1, (int) $windowSeconds);
        $now = time();
        $directory = self::_getStorageDirectory();

        if ($directory === false) {
            error_log('Gzaas rate limiter could not create its storage directory.');
            return self::_result(false, $limit, 0, $now + $windowSeconds);
        }

        $key = sha1((string) $bucket . '|' . (string) $identifier);
        $path = $directory . DIRECTORY_SEPARATOR . $key . '.json';
        $handle = @fopen($path, 'c+');

        if ($handle === false) {
            error_log('Gzaas rate limiter could not open its counter file.');
            return self::_result(false, $limit, 0, $now + $windowSeconds);
        }

        if (!flock($handle, LOCK_EX)) {
            fclose($handle);
            error_log('Gzaas rate limiter could not lock its counter file.');
            return self::_result(false, $limit, 0, $now + $windowSeconds);
        }

        rewind($handle);
        $stored = stream_get_contents($handle);
        $counter = json_decode($stored, true);

        if (!is_array($counter)
            || !isset($counter['count'])
            || !isset($counter['reset'])
            || (int) $counter['reset'] <= $now
        ) {
            $counter = array(
                'count' => 0,
                'reset' => $now + $windowSeconds
            );
        }

        $allowed = ((int) $counter['count'] < $limit);
        if ($allowed) {
            $counter['count'] = (int) $counter['count'] + 1;
        }

        $encodedCounter = json_encode($counter);
        rewind($handle);
        ftruncate($handle, 0);
        $bytesWritten = fwrite($handle, $encodedCounter);
        $writeSucceeded = ($bytesWritten === strlen($encodedCounter)) && fflush($handle);
        flock($handle, LOCK_UN);
        fclose($handle);

        if (!$writeSucceeded) {
            error_log('Gzaas rate limiter could not persist its counter.');
            return self::_result(false, $limit, 0, $now + $windowSeconds);
        }

        return self::_result(
            $allowed,
            $limit,
            max(0, $limit - (int) $counter['count']),
            (int) $counter['reset']
        );
    }

    public static function applyHeaders($response, $result)
    {
        $response->setHeader('X-RateLimit-Limit', (string) $result['limit'], true);
        $response->setHeader('X-RateLimit-Remaining', (string) $result['remaining'], true);
        $response->setHeader('X-RateLimit-Reset', (string) $result['reset'], true);

        if (!$result['allowed']) {
            $retryAfter = max(1, (int) $result['reset'] - time());
            $response->setHeader('Retry-After', (string) $retryAfter, true);
        }
    }

    private static function _getStorageDirectory()
    {
        $baseDirectory = defined('APPLICATION_PATH')
            ? APPLICATION_PATH . DIRECTORY_SEPARATOR . 'tmp'
            : sys_get_temp_dir();
        $directory = $baseDirectory . DIRECTORY_SEPARATOR . 'rate-limits';

        if ((!is_dir($directory) && !@mkdir($directory, 0700, true)) || !is_writable($directory)) {
            $directory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'gzaas-rate-limits';
            if ((!is_dir($directory) && !@mkdir($directory, 0700, true)) || !is_writable($directory)) {
                return false;
            }
        }

        return $directory;
    }

    private static function _result($allowed, $limit, $remaining, $reset)
    {
        return array(
            'allowed' => (bool) $allowed,
            'limit' => (int) $limit,
            'remaining' => (int) $remaining,
            'reset' => (int) $reset
        );
    }
}
