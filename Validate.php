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
     * Static function for validating email addresses with multiple secure levels and black- and whitelist.
     * @param string $email email address
     * @param int $level secure level
     * @param array $lists filter lists like whitelist, blacklist,..
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

        return $results;
    }

    /**
     * Static function for validating a IP Address.
     * @param string $address IP address
     * @return bool is the IP Address valid?
     */
    static function ip(string $address) : bool
    {
        return false !== filter_var($address, FILTER_VALIDATE_IP);
    }

    /**
     * Static function for validating a IPv4 Address.
     * @param string $address IPv4 address
     * @return bool is the IPv4 Address valid?
     */
    static function ipv4 (string $address) : bool
    {
        return false !== filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    /**
     * Static function for validating a IPv6 Address.
     * @param string $address IPv6 address
     * @return bool is the IPv6 Address valid?
     */
    static function ipv6 (string $address) : bool
    {
        return false !== filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
    }

    /**
     * Static function for validating a number range.
     * @param float $value number to validate
     * @param float $min min value
     * @param float $max max value
     * @return bool is the value between min and max?
     */
    static function range(float $value, float $min, float $max) : bool
    {
        return ($value >= $min && $value <= $max);
    }

    /**
     * Static function for validating a IBAN (International Bank Account Number).
     * @param string $iban International Bank Account Number
     * @return bool is the IBAN valid?
     */
    static function iban(string $iban) : bool
    {
        $country_length = [
            "AL" => 28, "AD" => 24, "AT" => 20, "AZ" => 28, "BH" => 22, "BE" => 16, "BA" => 20, "BR" => 29, "BG" => 22, "CR" => 21,
            "HR" => 21, "CY" => 28, "CZ" => 24, "DK" => 18, "DO" => 28, "TL" => 23, "EE" => 20, "FO" => 18, "FI" => 18, "FR" => 27,
            "GE" => 22, "DE" => 22, "GI" => 23, "GR" => 27, "GL" => 18, "GT" => 28, "HU" => 28, "IS" => 26, "IE" => 22, "IL" => 23,
            "IT" => 27, "JO" => 30, "KZ" => 20, "XK" => 20, "KW" => 30, "LV" => 21, "LB" => 28, "LI" => 21, "LT" => 20, "LU" => 20,
            "MK" => 19, "MT" => 31, "MR" => 27, "MU" => 30, "MC" => 27, "MD" => 24, "ME" => 22, "NL" => 18, "NO" => 15, "PK" => 24,
            "PS" => 29, "PL" => 28, "PT" => 25, "QA" => 29, "RO" => 24, "SM" => 27, "SA" => 24, "RS" => 22, "SK" => 24, "SI" => 19,
            "ES" => 24, "SE" => 24, "CH" => 21, "TN" => 24, "TR" => 26, "AE" => 23, "GB" => 22, "VG" => 24
        ];

        $iban = mb_ereg_replace("/(\s|\-)/", "", $iban); // sanitize for validation (remove spaces)
        $country = mb_strtoupper(mb_substr($iban, 0, 2));

        // we know the country the IBAN belongs to?
        if(isset($country_length[$country])) {

            // The IBAN matches in length and basic structure?
            $matches = null;
            if(mb_ereg_match('/^([A-Za-z]{2})(\d{2})([A-Za-z0-9]{' . $country_length[$country] . '})$/', $iban, $matches)) {
                $checkNum = $matches[1];
                $bban = strtoupper($matches[2]);

                // Replace letters with digits (a or A => 11, b or B => 12,..)
                $checkString = mb_ereg_replace_callback('/[A-Z]/', function ($matches) {
                        return base_convert($matches[0], 36, 10);
                }, $bban . $country . '00');

                $int_iban = intval($checkString); // remove leading zeros by converting to int.

                // calculate check number of IBAN and convert to string of length 2.
                $calc_checkNum = 98 - bcmod($int_iban, 97);
                $calc_checkNum = ($calc_checkNum < 10 ? "0$calc_checkNum" : "$calc_checkNum");

                // Invalid if check number is not the same as the calculated one.
                if ($calc_checkNum !== $checkNum) return false;
            }
            else
                return false;

        }

        return true;
    }

    /**
     * A static method to validate SWIFT/BIC codes.
     * @param string $swift swift/bic code
     * @return bool swift/bic valid?
     */
    static function swift(string $swift) : bool
    {
        $swift = trim($swift); // sanitize swift/bic
        return mb_ereg_match("^([a-zA-Z]){4}([a-zA-Z]){2}([0-9a-zA-Z]){2}([0-9a-zA-Z]{3})?$", $swift);
    }

}