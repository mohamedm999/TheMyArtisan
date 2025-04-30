<?php

namespace App\Helpers;

use App\Models\ArtisanProfile;

class AddressHelper
{
    /**
     * Generate a full address string from profile address components
     *
     * @param ArtisanProfile|null $profile
     * @param string $defaultMessage Default message if address is empty
     * @return string
     */
    public static function getFullAddress($profile, $defaultMessage = 'Location not specified')
    {
        if (!$profile) {
            return $defaultMessage;
        }

        $addressParts = [];

        if (!empty($profile->address)) {
            $addressParts[] = $profile->address;
        }

        if (!empty($profile->city)) {
            $addressParts[] = $profile->city;
        }

        if (!empty($profile->postal_code)) {
            $addressParts[] = $profile->postal_code;
        }

        if (!empty($profile->country)) {
            $addressParts[] = $profile->country;
        }

        return !empty($addressParts) ? implode(', ', $addressParts) : $defaultMessage;
    }
}
