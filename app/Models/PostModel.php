<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $db;

    public function __construct(){
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function getPosts($itype = null, $pid = null,$title = null,$category = null,$body = null,$image = null,$createdat = null, $updatedat = null){
        $sql = "CALL SP_POST(?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql,[
            $itype, $pid,$title,$category,$body,$image,$createdat, $updatedat
        ]);
        $results = $query->getResult(); // or getResultArray() for an array
//      Return or process the results
        return $results;
        // return $this->db->affectedRows();
    }
}
