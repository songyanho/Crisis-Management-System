<?php

use Base\User as BaseUser;

/**
 * Skeleton subclass for representing a row from the 'user' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class User extends BaseUser
{
    public function toReadableArray(){
        return [
            'id'        => $this->getId(),
            'username'  => $this->getUsername(),
            'role'      => CMS::getUserRole($this)
        ];
    }
}
