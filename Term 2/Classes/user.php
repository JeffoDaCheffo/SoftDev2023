<?php

class User
{
  public $username;
  public $fName;
  public $lName;

  public function __construct(/*array*/$data)
  {
    $this->username = $data['0'];
    $this->fName = $data['1'];
    $this->lName = $data['2'];
  }
}

// CRUD functions for User class


/** Function to create a new user
 * @param $POST array from index.php
 * @return error or instance of User class
 */
function CreateUser(/*$POST*/$data)
{

  /**
   * validate data
   *  check if all fields are filled
   *  check if username is valid
   *  check if password and confirm password match
   * Open CSV file
   * Check if username already exists
   *  If username exists, return error
   * append new user to CSV file 
   * return instance of User class
   */

  $data['fName'] = filter_input($data, 'fName');
  $data['lname'] = filter_input($data, 'lName');
  $data['email'] = filter_input($data, 'email');

  if ($data['fName'] == null || $data['lName'] == null || $data['email'] == null) {
    $error = "Please enter all fields";
  }

  if ($data['password'] !== $data['confirmPassword']) {
    $error = "Passwords do not match";
  }

  if (empty($error)) {
    // Open users table in read mode
    $dataFilePath = "../CSVs/";
    $file = new SplFileObject($dataFilePath . "users.csv", "r");
    $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY);

    // does email already exist?
    foreach ($file as $user) {
      if (strcasecmp($user[0], $data['email']) == 0) {
        $error = "Email already exists";
        break;
      }
    }

    if (empty($error)) {
      $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
      unset($data['confirmPassword']);
      $file->fputcsv($data);
      return new User($data);
    }
  }

  // if we get here there is an error
  return $error;

}




function ReadUser(/*string*/$email)
{

  /**
   * Open CSV file
   * Check if username exists
   * If username exists, return instance of User class
   * If username does not exist, return error
   */
}

function UpdateUser()
{
}

function DeleteUser()
{
}
