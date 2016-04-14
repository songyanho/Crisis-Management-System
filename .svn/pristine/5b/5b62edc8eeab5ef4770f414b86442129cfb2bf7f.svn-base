<?php

use Base\Incident as BaseIncident;

/**
 * Skeleton subclass for representing a row from the 'incident' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Incident extends BaseIncident
{
    public function toMessage(){
        return "Incident #".$this->getId().". ".$this->getTitle().". Location: ".$this->getLocation()."(".$this->getLatitude().",".$this->getLongitude().")";
    }
}
