<?php

namespace App\Database\Connectors;

use Illuminate\Database\Connectors\PostgresConnector;

class NeonPostgresConnector extends PostgresConnector
{
    protected function getDsn(array $config): string
    {
        $dsn = parent::getDsn($config);

        if (empty($config['neon_endpoint'])) {
            return $dsn;
        }

        $endpoint = str_replace("'", "\\'", $config['neon_endpoint']);

        return "{$dsn};options='endpoint={$endpoint}'";
    }
}
