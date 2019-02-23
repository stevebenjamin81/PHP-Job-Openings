<?php
/*
Copyright 2019 Steven S Benjamin
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the Software), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, andor sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED AS IS, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
session_start();

require 'configuration.php';
require 'class.lib.php';
$mysqli = new mysqli($mySQLServer, $mySQLUser, $mySQLpassword, $mySQLDatabase);

// Sanatize Data, the data is escaped in the class to avoid mysql injection
$sPOST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
$sGET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

$output = '';

// General actions, lets decide what to do....
if ($sGET['type'] == "categories") {
    $jobs = new jobs($mysqli);
    $output = $jobs->get_categories();
} elseif ($sGET['type'] == "jobs") {
    $jobs = new jobs($mysqli);
    $output = $jobs->get_jobs($sGET['category_id']);
} elseif ($sGET['type'] == "job") {
    $jobs = new jobs($mysqli);
    $output = $jobs->get_job($sGET['job_id']);
} elseif ($sGET['type'] == "category") {
    $jobs = new jobs($mysqli);
    $output = $jobs->get_category($sGET['category_id']);
} elseif ($sGET['type'] == "login") {
    $jobs = new jobs($mysqli);
    $output = $jobs->login($sPOST['email'], $sPOST['password']);
} elseif ($sGET['type'] == "register") {
    $jobs = new jobs($mysqli);
    $output = $jobs->register($sPOST['rname'], $sPOST['remail'], $sPOST['rpassword']);
} elseif ($sGET['type'] == "logout") {
    $jobs = new jobs($mysqli);
    $output = $jobs->logout();
}

if (isset($_SESSION['user_logged']) && $_SESSION['user_id'] != 0) {
    //User actions secure area
    if ($sGET['type'] == "upload") {
        $fup = new fileUpload($mysqli);
        $output = json_encode($fup->upload($sGET['jobs_id']));
    }
}

if (isset($_SESSION['user_logged']) &&
        $_SESSION['user_id'] != 0 &&
        $_SESSION['is_admin'] != 0) {
// Admin actions secure area
    if ($sGET['type'] == "applicants") {
        $admin = new admin($mysqli);
        $output = $admin->get_applicants($sGET['jobs_id']);
    } elseif ($sGET['type'] == "users") {
        if ($_SESSION['is_admin'] == 2) {
            $admin = new admin($mysqli);
            $output = $admin->get_users();
        }
    } elseif ($sGET['type'] == "saveUser") {
        if ($_SESSION['is_admin'] == 2) {
            $admin = new admin($mysqli);
            $output = $admin->save_user($sPOST['id'], $sPOST['is_admin'], $sPOST['name'], $sPOST['email']);
        }
    } elseif ($sGET['type'] == "upcategory") {
        $admin = new admin($mysqli);
        $output = $admin->updateCategory($sPOST['id'], $sPOST['name'], $sPOST['description']);
    } elseif ($sGET['type'] == "upjob") {
        $admin = new admin($mysqli);
        $output = $admin->updateJob($sPOST['id'], $sPOST['name'], $sPOST['description'], $sPOST['category']);
    } elseif ($sGET['type'] == "addcategory") {
        $admin = new admin($mysqli);
        $output = $admin->addCategory($sPOST['name'], $sPOST['description']);
    } elseif ($sGET['type'] == "addjob") {
        $admin = new admin($mysqli);
        $output = $admin->addJob($sPOST['name'], $sPOST['description'], $sPOST['category']);
    } elseif ($sGET['type'] == "delete") {
        $admin = new admin($mysqli);
        $output = $admin->delete($sPOST['id'], $sPOST['table']);
    }
}
// Send jSON response
header('Content-Type: application/json charset=utf-8');
echo $output;

