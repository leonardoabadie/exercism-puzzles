<?php

/*
* Exercism's challenge: Phone Number
* Iteration: 1
* Coder: MGB 
* Date: ( 2023/06/14 - 11:21AM ) 
*/ 

class PhoneNumber {
  private $number;

  private function cleanUp($number) : string {
    $number = preg_replace("/[^0-9]*/", "", $number);
    return strlen($number) === 10 ? $number : substr($number, 1);
  }

  private function splitNumberIntoCategories($number) : array {
    $number = $this->cleanUp($number);
    preg_match("/^([\d]?)([\d]{3})([\d]{3})([\d]{4})$/", $number, $categories);
    return [
      "countryCode" => $categories[1],
      "areaCode" => $categories[2],
      "exchangeCode" => $categories[3],
      "subscriberNumber" => $categories[4]
    ];
  }

  private function checkForExceptions($number) : void {
    if (strlen($number) < 10) {
      throw new InvalidArgumentException("incorrect number of digits");
    } else if (strlen(preg_replace("/[^0-9]*/", "", $number)) > 11) {
      throw new InvalidArgumentException("more than 11 digits");
    }

    if (strlen($number) === 11 && $number[0] !== "1") {
      throw new InvalidArgumentException("11 digits must start with 1");
    }

    if (preg_match("/[a-zA-Z]+/", $number)) {
      throw new InvalidArgumentException("letters not permitted");
    }

    // valid punctuation: .-()+
    if (preg_match("/[:!@#$%&*]+/", $number)) {
      throw new InvalidArgumentException("punctuations not permitted");
    }

    $categories = $this->splitNumberIntoCategories($number);

    if ($categories["areaCode"][0] === "0") {
      throw new InvalidArgumentException("area code cannot start with zero");
    } else if ($categories["areaCode"][0] === "1") {
      throw new InvalidArgumentException("area code cannot start with one");
    }

    if ($categories["exchangeCode"][0] === "0") {
      throw new InvalidArgumentException("exchange code cannot start with zero");
    } else if ($categories["exchangeCode"][0] === "1") {
      throw new InvalidArgumentException("exchange code cannot start with one");
    }
  }

  public function number() : string {
    return $this->number;
  }

  public function __construct($input) {
    $this->checkForExceptions($input);
    $this->number = $this->cleanUp($input);
  }
}

