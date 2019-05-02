<?php


class Student
{
    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $class;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param mixed $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    public function getStudentById($id){
        require_once('db/DBConnection.php');
        $sql = "SELECT * FROM student WHERE id=\"" . $id . "\"";
        $conn = connectToDB();
        $result = $conn->query($sql);
        if ($result->num_rows ==1 ) {
            while ($row=$result->fetch_assoc()){
                $this->setId($id);
                $this->setFirstName($row['first_name']);
                $this->setLastName($row['last_name']);
                $this->setEmail($row['email']);
                $this->setClass($row['class']);
            }
            return $this;
        }
        return -1;
    }
}