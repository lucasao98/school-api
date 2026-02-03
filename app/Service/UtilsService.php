<?php

namespace App\Service;
use PHPUnit\Framework\EmptyStringException;

class UtilsService
{
    public function createUsername(string $fullname, string $birthday){
        $username = '';

        if(empty($fullname)){
            throw new EmptyStringException('Fullname is a empty string');
        }

        $splittedName = explode(" ", $fullname);
        $splittedBirthday = explode("-", $birthday);

        foreach ($splittedName as $index => $surname) {
            if((count($splittedName) - 1) == $index){
                $username .= strtolower($surname);
                $username .= $splittedBirthday[0][2] . $splittedBirthday[0][3];
            } else{
                $username .= strtolower($surname[0]);
            }
        };

        return $username;
    }

    public function makeRegistrationNumber() {
        $registration_number = date('Y') . strval(rand(0, 999) . strval(rand(0, 99)));
        return $registration_number;
    }
}
