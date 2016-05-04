<?php

/**
 * User: Marcel 'CoNfu5eD Naeve <confu5ed@serious-pro.de>
 * Date: 03.05.2016
 * Time: 21:28
 */

/**
 * Class Validate.
 */
class Validate
{
    /**
     * Static function for validating email addresses with multiple secure levels and blacklist.
     * @param string $email email address
     * @param int $level secure level
     * @param array $lists filter lists like whitelist, blacklist, dnsbl,..
     * @return bool is the email address valid?
     */
    static function email (string $email, int $level=1, array $lists=[]) : bool
    {
        $results = true;
        $email = trim($email); // sanitize before validation
        $split = explode('@', $email);

        // Whitelisted?
        if(isset($lists['whitelist'])) {
            if(in_array($email, $lists['whitelist']) || in_array($split[1], $lists['whitelist']))
                return true;
        }

        // Blacklisted?
        if(isset($lists['blacklist'])) {
            if(in_array($email, $lists['blacklist']) || in_array($split[1], $lists['blacklist']))
                return false;
        }

        // check format
        if($results && $level >= 1) {
            if(filter_var($email, FILTER_VALIDATE_EMAIL) === false)
            {
                $results = false;
            } else {
                $results = true;
            }
        }

        // check for dns MX entry
        if($results && $level >= 2) {
            $results = checkdnsrr($split[1], "MX");
        }

        // DNS Blacklist (domains)
        if($results && isset($lists['dnsbl']) && $level >= 3) {
            // TODO: check if domain is registered in dnsbl of list.
        }

        return $results;
    }
}