<?php
/*
Copyright 2019 Steven S Benjamin
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the Software), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, andor sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED AS IS, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
class superClass {
// share the database with sub classes
    public $mysqli;

    function __construct(mysqli $mysqli) {
        $this->mysqli = $mysqli;
    }
// Lets take the mysql result and make some json responses for the front end
    function json_prep($result) {
        // sometimes the input is 1 or 0
        if (is_int($result) || is_string($result)) {
            return '{"status": "success","code": 200,"message": "OK","payload":' . json_encode($result) . '}';
        }
        // sometimes the input is an array
        if (is_array($result)) {
            return '{"status": "success","code": 200,"message": "OK","payload":' . json_encode($result) . '}';
        }
        // other times it's from mysql
        $rows = array();
        while ($r = $result->fetch_assoc()) {
            $rows[] = $r;
        }
        return '{"status": "success","code": 200,"message": "OK","payload":' . json_encode($rows) . '}';
        //return json_encode($rows);
    }
//get file extention
    function fExt($fn) {
        $ext = pathinfo($fn, PATHINFO_EXTENSION);
        return $ext;
    }
// create random file name
    function randName($fn) {
        $rn = sha1(microtime());
        $nn = $rn . '_' . $fn;
        return $nn;
    }
    // store the session for user login
    function setSession($id, $email, $name, $is_admin) {
        $_SESSION["user_logged"] = 1;
        $_SESSION["user_id"] = $id;
        $_SESSION["email"] = $email;
        $_SESSION["name"] = $name;
        $_SESSION["is_admin"] = $is_admin;
        return 1;
    }
    //logout
    function logout() {
        session_destroy();
        return $this->json_prep(1);
    }
}
//upload resumes
class fileUpload extends superClass {
    function upload($jobs_id) {
        if (!empty($_FILES["file"]) && isset($_SESSION["user_id"]) && $jobs_id != '') {
            $fn = basename($_FILES['file']['name']);
            $ext = parent::fExt($fn);

            if (($ext != "docx" && $ext != "doc") || $_FILES["file"]["size"] > 350000) {
                $output = array("success" => false, "error" => "Only .doc or .docx files under 350Kb are accepted!");
                return parent::json_prep($output);
            }
            $rname = '/resumes/' . parent::randName($fn);
            if (move_uploaded_file($_FILES['file']['tmp_name'], dirname(__FILE__) . $rname)) {
                $this->mysqli->query("INSERT INTO resumes(jobs_id, users_id, resume, date) VALUES('" . $this->mysqli->real_escape_string($jobs_id) . "', '" . $this->mysqli->real_escape_string($_SESSION["user_id"]) . "', '" . $this->mysqli->real_escape_string($rname) . "', NOW())");
                $output = array("success" => true, "message" => "Success!");
            } else {
                $output = array("success" => false, "error" => "Couldn't Store File!");
            }
        } else {
            $output = array("success" => false, "error" => "No File Detected!");
        }
        return parent::json_prep($output);
    }

}
// The jobs class
class jobs extends superClass {
    function get_categories() {
        $result = $this->mysqli->query("SELECT * FROM categories");
        if ($result) {
            return parent::json_prep($result);
        }
    }
    // Get job listings based on the category id
    function get_jobs($category_id) {
        $input = $this->mysqli->real_escape_string($category_id);
        if ($category_id == '*') {
            $result = $this->mysqli->query("SELECT * FROM jobs");
        } else {
            $result = $this->mysqli->query("SELECT * FROM jobs WHERE category = '$input'");
        }
        if ($result) {
            return parent::json_prep($result);
        }
    }
    //Possible sub categories later!
    function get_category($category_id) {
        $result = $this->mysqli->query("SELECT * FROM categories WHERE id='$category_id'");
        if ($result) {
            return parent::json_prep($result);
        }
    }
    // Get the job information
    function get_job($job_id) {
        $input = $this->mysqli->real_escape_string($job_id);
        $result = $this->mysqli->query("SELECT * FROM jobs WHERE id='$input'");
        if ($result) {
            return parent::json_prep($result);
        }
    }
    // login
    function login($email, $password) {
        $result = $this->mysqli->query("SELECT * FROM users WHERE email='" . $this->mysqli->real_escape_string($email) . "' and password='" . md5($this->mysqli->real_escape_string($password)) . "'");
        $row = $result->fetch_array();
        if (is_array($row)) {
            parent::setSession($row['id'], $row['email'], $row['name'], $row['is_admin']);
            return parent::json_prep(1);
        } else {
            return parent::json_prep(0);
        }
    }
    //register
    function register($rname, $remail, $rpassword) {
// reject inserts with no data
        if ($rname == '' || $rpassword == '' || $remail == '') {
            return parent::json_prep(0);
        }
// check if the user already exists!
        $res1 = $this->mysqli->query("SELECT email FROM users WHERE email='" . $this->mysqli->real_escape_string($remail) . "'");
        if ($res1->num_rows != 0) {
            return parent::json_prep(2);
        }
// add the user
        $res2 = $this->mysqli->query("INSERT INTO users(name, email, password) VALUES('" . $this->mysqli->real_escape_string($rname) . "', '" . $this->mysqli->real_escape_string($remail) . "', '" . md5($this->mysqli->real_escape_string($rpassword)) . "')");
        if ($res2) {
            parent::setSession($this->mysqli->insert_id, $remail, $rname, 0);
            $this->eMail($remail);
// send response to Jquery
            return parent::json_prep(1);
        } else {
            return parent::json_prep(0);
        }
    }
    //Registration successful email
    function eMail($remail) {
        // Lets send a confirmation email!
        $subject = "Thank You For Registering!";
        $content = "Your jobs account has been registered successfully!";
        $mailHeaders = "From: Admin\r\n";

        if (!@mail($remail, $subject, $content, $mailHeaders)) {
            return parent::json_prep(2);
        } else {
            return parent::json_prep(1);
        }
    }
}

class admin extends jobs {
    // view information about who has applied
    function get_applicants($job_id) {
        $result = $this->mysqli->query("SELECT resumes.*, users.name, users.email, jobs.name AS jName FROM resumes "
                . "LEFT JOIN jobs ON jobs.id=resumes.jobs_id "
                . "LEFT JOIN users ON users.id = resumes.users_id "
                . "WHERE resumes.jobs_id='" . $this->mysqli->real_escape_string($job_id) . "'");
        if ($result) {
            return parent::json_prep($result);
        }
    }
    // Get all user information
    function get_users() {
        $result = $this->mysqli->query("SELECT * FROM users ORDER BY is_admin DESC, name ASC");
        if ($result) {
            return parent::json_prep($result);
        } else {
            return parent::json_prep(0);
        }
    }
    // save updated user information 
        function save_user($id, $is_admin, $name, $email) {
        $result = $this->mysqli->query("UPDATE users SET is_admin='$is_admin', name='$name', email='$email' WHERE id='$id'");
        if ($result) {
            return parent::json_prep(1);
        } else {
            return parent::json_prep(0);
        }
    }
    // save updated category information
    function updateCategory($id, $name, $description) {
        $result = $this->mysqli->query("UPDATE categories SET name='" . $this->mysqli->real_escape_string($name) . "', description='" . $this->mysqli->real_escape_string($description) . "' WHERE id=" . $this->mysqli->real_escape_string($id));
        if ($result) {
            return parent::json_prep(1);
        } else {
            return parent::json_prep(0);
        }
    }
    // save updated job information
    function updateJob($id, $name, $description, $category) {
        $result = $this->mysqli->query("UPDATE jobs SET name='" . $this->mysqli->real_escape_string($name) . "', description='" . $this->mysqli->real_escape_string($description) . "', category='" . $this->mysqli->real_escape_string($category) . "' WHERE id=" . $this->mysqli->real_escape_string($id));
        if ($result) {
            return parent::json_prep(1);
        } else {
            return parent::json_prep(0);
        }
    }
    // add a category
    function addCategory($name, $description) {
        $result = $this->mysqli->query("INSERT INTO categories(name, description) VALUES('" . $this->mysqli->real_escape_string($name) . "', '" . $this->mysqli->real_escape_string($description) . "')");
        if ($result) {
            return parent::json_prep(1);
        } else {
            return parent::json_prep(0);
        }
    }
    //add a job
    function addJob($name, $description, $category) {
        $result = $this->mysqli->query("INSERT INTO jobs(name, description, category) VALUES('" . $this->mysqli->real_escape_string($name) . "', '" . $this->mysqli->real_escape_string($description) . "', '" . $this->mysqli->real_escape_string($category) . "')");
        if ($result) {
            return parent::json_prep(1);
        } else {
            return parent::json_prep(0);
        }
    }
    // delete jobs, categories or users
    function delete($id, $table) {
        if ($table == 'categories') {
            $result = $this->mysqli->query("DELETE FROM jobs WHERE category=" . $this->mysqli->real_escape_string($id));
        }
        $result = $this->mysqli->query("DELETE FROM " . $this->mysqli->real_escape_string($table) . " WHERE id=" . $this->mysqli->real_escape_string($id));
        if ($result) {
            return parent::json_prep(1);
        } else {
            return parent::json_prep(0);
        }
    }
}
