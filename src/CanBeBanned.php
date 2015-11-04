<?php

namespace Speelpenning\Authentication;

use Carbon\Carbon;

trait CanBeBanned
{
    /**
     * Indicates whether the user is banned.
     *
     * @return bool
     */
    public function isBanned()
    {
        return ! is_null($this->{$this->getBannedAtColumnName()});
    }

    /**
     * Indicates from what moment the user is banned.
     *
     * @return null|Carbon
     */
    public function isBannedSince()
    {
        return $this->isBanned()
            ? Carbon::createFromFormat('Y-m-d H:i:s', $this->{$this->getBannedAtColumnName()})
            : null;
    }

    /**
     * Get the column name for the "banned since" timestamp.
     *
     * @return string
     */
    public function getBannedAtColumnName()
    {
        return 'banned_at';
    }

    /**
     * Bans the user.
     *
     * @return void
     */
    public function ban()
    {
        $this->{$this->getBannedAtColumnName()} = new Carbon();
    }

    /**
     * Unbans the user.
     *
     * @return void
     */
    public function unban()
    {
        $this->{$this->getBannedAtColumnName()} = null;
    }
}
