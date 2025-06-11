<?php

namespace App\Extensions;

use Illuminate\Session\DatabaseSessionHandler;
use SessionHandlerInterface;

class CustomDatabaseSessionHandler extends DatabaseSessionHandler implements SessionHandlerInterface
{
    protected function addUserInformation(&$payload)
    {
        // Override default 'user_id' dengan 'username'
        $payload['username'] = optional(auth()->user())->username;
        return $this;
    }
    protected function addRequestInformation(&$payload)
    {
        $payload['ip_address'] = request()->ip(); // contoh isi
        return $this; // penting!
    }
    protected function getDefaultPayload($data)
    {
        $payload = parent::getDefaultPayload($data);

        // Tambahkan username ke payload
        $this->addUserInformation($payload);

        return $payload;
    }

    public function write($sessionId, $data): bool
    {
        $this->getQuery()->updateOrInsert(
            ['id' => $sessionId],
            array_merge($this->getDefaultPayload($data), [
                'payload' => base64_encode($data),
                'last_activity' => time(),
            ])
        );

        return true;
    }
}
