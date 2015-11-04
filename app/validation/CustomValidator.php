<?php

namespace App\Validation;

use Illuminate\Validation\Validator;

class CustomValidator extends Validator {

    protected function validateCustomDomain($attribute, $value, $parameters) {
        $host = removeSchemaUrl($value);
        $ip_map = config('gtw.ip_map'); // This should be Ip address of members.gtwhero.kvdev.kvsocial.com
        $dns_config = config('gtw.dns_config'); // DNS IP Look Up
        $valid_dns_ip_1 = false;
        $valid_dns_ip_2 = false;
        $valid_dns_ip_3 = false;

        foreach ($dns_config as $index => $dns_ip) {
            $nslookup = 'nslookup ' . $host . ' ' . $dns_ip;
            exec($nslookup, $output);
            if (isset($output[3]) && isset($output[4])) {
                $domain = trim(str_replace('Name:', '', $output[3]));
                $ip = trim(str_replace('Address:', '', $output[4]));
                if ($domain == $value && $ip == $ip_map) {
                    if ($index == 0) {
                        $valid_dns_ip_1 = true;
                    } else if ($index == 1) {
                        $valid_dns_ip_2 = true;
                    } else if ($index == 2) {
                        $valid_dns_ip_3 = true;
                    }
                } else {
                    // if any one fails break the loop
                    break;
                }
            } else {
                // if dns look up fails break it
                break;
            }
        }

        if ($valid_dns_ip_1 && $valid_dns_ip_2 && $valid_dns_ip_3) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
