<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Controllers\BaseController;

class PostController extends BaseController
{
    protected $db;

    public function __construct()
    {
        // Load the database
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $PostModel = new PostModel();
        $AllPosts = $PostModel->getPosts("getallposts");
        // echo "<pre> AllPosts :"; print_r($AllPosts); exit;
        $data = array(
            "Posts"=> $AllPosts
        );
        return view("index", $data);
    }

    // Handle Add New Post
    public function add(){
        $file = $this->request->getFile("file");
        $fileName = $file->getRandomName();
        $title = $this->request->getPost('title');
        $category = $this->request->getPost('category');
        $body= $this->request->getPost('body');
        $image= $fileName;
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        // $data = [
        //     'title' => $this->request->getPost('title'),
        //     'category' => $this->request->getPost('category'),
        //     'body'=> $this->request->getPost('body'),
        //     'image'=> $fileName,
        //     'created_at'=> date('Y-m-d H:i:s'),
        //     'updated_at'=> date('Y-m-d H:i:s')
        // ];

        $validation = \Config\Services::validation();
        $validation->setRules([
            'image' => 'uploaded[file]|max_size[file,1024]|is_image[file]|mime_in[file,image/jpg,image/jpeg,image/png]',
        ]);
        if (!$validation->withRequest($this->request)->run()){
            return $this->response->setJSON([
                'error' => true,
                'message' => $validation->getErrors()
            ]);
        } else{
            $file->move('upload/avtar',$fileName);
            // $postModel = new \App\Models\PostModel();
            // $postModel->save($data);
            $PostModel = new PostModel();
            $result = $PostModel->getPosts('ins',null,$title,$category,$body,$fileName,$created_at);
            if ($result > 0) {
                return $this->response->setJSON([
                    'error' => false,
                    'message' => 'Successfully Added New Post !'
                ]);
            }else{
                return $this->response->setJSON([
                    'error' => false,
                    'message' => 'Something Went Wrong !'
                ]);
            }
        }
    }

    public function edit($id = null){
        $postModel = new PostModel();
        $post = $postModel->getPosts('getpostbyid',$id);
        // echo "<pre> post :"; print_r($post[0]);exit;
        return $this->response->setJSON([
            'error'=> false,
            'message'=> $post[0],
        ]);
    }
    
    public function Update(){
        // echo "<pre> post :"; print_r($_POST); 
        // echo "<pre> file :"; print_r($_FILES);
        $file = $this->request->getFile("file");
        // $fileName = $file->getRandomName();
        $fileName = $file->getName();
        // echo "<pre> file :"; print_r($fileName); exit;
        $postModel = new PostModel();
        $pid = $this->request->getPost("pid");
        $title = $this->request->getPost("title");
        $category = $this->request->getPost("category");
        $body = $this->request->getPost("body");
        $image = $fileName;
        $created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");

        $validation = \Config\Services::validation();
        $validation->setRules([
            'image' => 'uploaded[file]|max_size[file,1024]|is_image[file]|mime_in[file,image/jpg,image/jpeg,image/png]',
        ]);
        
        if (!$validation->withRequest($this->request)->run()){
            return $this->response->setJSON([
                'error' => true,
                'message' => $validation->getErrors()
            ]);
        } else{
            $file->move('upload/avtar',$fileName);
            $result = $postModel->getPosts('upd',$pid,$title,$category,$body,$image,$created_at,$updated_at);
            // echo "<pre> db :"; print_r($this->db->getLastQuery()); exit;
            if($result > 0){
                return $this->response->setJSON([
                    'error'=> false,
                    'message'=> 'Post Update Successfully !'
                ]);
            }else{
                return $this->response->setJSON([
                    'error'=> false,
                    'message'=> 'Something Went Wrong !'
                ]);
            }
        }
    }
}
