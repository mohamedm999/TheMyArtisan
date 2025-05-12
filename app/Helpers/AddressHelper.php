<?php

namespace App\Helpers;

class AddressHelper
{
    /**
     * Format an address from its components
     *
     * @param string|null $address
     * @param string|null $city
     * @param string|null $state
     * @param string|null $postalCode
     * @param string|null $country
     * @return string
     */
    public static function formatAddress($address = null, $city = null, $state = null, $postalCode = null, $country = null)
    {
        $parts = [];

        if (!empty($address)) $parts[] = $address;
        if (!empty($city)) $parts[] = $city;

        if (!empty($state) && !empty($postalCode)) {
            $parts[] = "$state, $postalCode";
        } elseif (!empty($state)) {
            $parts[] = $state;
        } elseif (!empty($postalCode)) {
            $parts[] = $postalCode;
        }

        if (!empty($country)) $parts[] = $country;

        return implode(', ', $parts);
    }
}
