<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD App Using CI4 and Ajax</title>
    <style>
        .postimage {
            width: 100%; 
            height: 300px; 
            /* object-fit: cover;  */
        }
        .imgtop{
            padding-top: 10px;
        }
        .dpost{
            color:red;
            font-size: 25px;
            font-weight: 600;
        }
    </style>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<body>
<!-- Add Post Modal start -->
<div class="modal fade" id="add_post_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add New Post</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="post" enctype="multipart/form-data" id="add_post_form" novalidate>
        <div class="modal-body p-5">
            <div class="mb-3">
                <label>Post Title</label>
                <input type="text" name="title" class="form-control" placeholder="Title" required>
                <div class="invalid-feedback">Post Title is required</div>
            </div>
            <div class="mb-3">
                <label>Post Category</label>
                <input type="text" name="category" class="form-control" placeholder="Category" required>
                <div class="invalid-feedback">Post Category is required</div>
            </div>
            <div class="mb-3">
                <label>Post Body</label>
                <textarea name="body" class="form-control" rows="4" placeholder="Body" required></textarea>
                <div class="invalid-feedback">Post Body is required</div>
            </div>
            <div class="mb-3">
                <label>Post Image</label>
                <input type="file" name="file" class="form-control" id="image" required>
                <div class="invalid-feedback">Post Image is required</div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="add_post_btn">Add Post</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal end -->
 <!-- Edit Post Modal start -->
<div class="modal fade" id="edit_post_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Post</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="post" enctype="multipart/form-data" id="edit_post_form" novalidate>
        <input type="hidden" name="pid" id="pid">
        <input type="hidden" name="old_image" id="old_image">
        <div class="modal-body p-5">
            <div class="mb-3">
                <label>Post Title</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Title" required>
                <div class="invalid-feedback">Post Title is required</div>
            </div>
            <div class="mb-3">
                <label>Post Category</label>
                <input type="text" name="category" id="category" class="form-control" placeholder="Category" required>
                <div class="invalid-feedback">Post Category is required</div>
            </div>
            <div class="mb-3">
                <label>Post Body</label>
                <textarea name="body" class="form-control" id="body" rows="4" placeholder="Body" required></textarea>
                <div class="invalid-feedback">Post Body is required</div>
            </div>
            <div class="mb-3">
                <label>Post Image</label>
                <input type="file" name="file" id="image" class="form-control" required>
                <div class="invalid-feedback">Post Image is required</div>
                <div id="post_image"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="edit_post_btn">Update Post</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Edit Modal end -->

<!-- Delete Modal Start -->
<div class="modal fade" id="delete_post_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <span class="dpost">Are you sure want to delete post ? </span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
 <!-- Delete Modal End -->

    <div class="container">
        <div class="row my-4">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-item-center">
                        <div class="text-secondary fw-bold fs-3">All Posts</div>
                        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#add_post_modal">Add New Post</button>
                    </div>
                    <div class="card-body">
                        <div class="row" id="show_posts">
                            <?php foreach($Posts as $key=>$value){ ?>
                            <div class="col-md-4 imgtop">
                                <div class="card shadow-sm">
                                    <a href="#">
                                    <!-- <img src="<?= base_url('upload/avtar/' . $value->image) ?>" alt="Image" class="img-fluid card-img-top"> -->
                                    <img src="<?= base_url('upload/avtar/' . $value->image) ?>" alt="Image" class="postimage">
                                        <!-- <img src="https://cdn.pixabay.com/photo/2018/01/14/23/12/nature-3082832_640.jpg" class="img-fluid card-img-top"> -->
                                    </a>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="card-title fs-5 fw-bold"><?= $value->title;?></div>
                                            <div class="badge bg-dark"><?= $value->category;?></div>
                                        </div>
                                        <p><?= $value->body;?></p>
                                    </div>
                                    <div class="card-footer d-flex justify-content-between align-items-center">
                                        <div class="fst-italic">21-12-2022</div>
                                        <div>
                                            <a href="#" id="<?= $value->pid ;?>" class="btn btn-success btn-sm post_edit_btn" data-bs-toggle="modal" data-bs-target="#edit_post_modal">Edit</a>
                                            <a href="#" id="<?= $value->pid ;?>" class="btn btn-danger btn-sm post_delete_btn" data-bs-toggle="modal" data-bs-target="#delete_post_modal">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function(){
            // add new post ajax request
            $("#add_post_form").submit(function(e){
                e.preventDefault();
                const formData = new FormData(this);
                if(!this.checkValidity()){
                    e.preventDefault();
                    $(this).addClass('was-validated');
                }else{
                    //console.log("valid");
                    $("#add_post_btn").text("Adding...");
                    $.ajax({
                        url: '<?= base_url("post/add")?>',
                        method: 'post',
                        data: formData,
                        contentType:false,
                        cache:false,
                        processData:false,
                        dataType: 'json',
                        success:function(response){
                            //console.log(response);
                            if(response.error){
                                $("#image").addClass('is-invalid');
                                $("#image").next().text(response.message.image);
                            }else{
                                $("#add_post_modal").modal('hide');
                                $("#add_post_form")[0].reset();
                                $("#image").removeClass('is-invalid');
                                $("#image").next().text('');
                                $("#add_post_form").removeClass('was-validated');
                                Swal.fire(
                                   'Added !',
                                    response.message,
                                   'success'
                                );
                            }
                            $("#add_post_btn").text('Add Post');
                        }
                    });
                }
            });
        });

        // edit post ajax request
        $(document).delegate('.post_edit_btn','click',function(e){
            e.preventDefault();
            const id = $(this).attr('id');
            console.log(id);
            $.ajax({
                url: '<?= base_url("post/edit/");?>/' + id,
                method: "get",
                //data: $(),    not use in get method
                success:function(response){
                    // console.log(response);
                    $("#pid").val(response.message.pid);
                    $("#old_image").val(response.message.image);
                    $("#title").val(response.message.title);
                    $("#category").val(response.message.category);
                    $("#body").val(response.message.body);
                    $("#post_image").html('<img src="<?= base_url('../upload/avtar/')?>/' + response.message.image + ' " class="img-fluid mt-2 img-thumbnail" width="150" >');
                }
            });
        });

        $(function(){
            // add new post ajax request
            $("#edit_post_form").submit(function(e){
                e.preventDefault();
                const formData = new FormData(this);
                if(!this.checkValidity()){
                    e.preventDefault();
                    $(this).addClass('was-validated');
                }else{
                    //console.log("valid");
                    $("#edit_post_btn").text("Updating...");
                    $.ajax({
                        url: '<?= base_url("post/update")?>',
                        method: 'post',
                        data: formData,
                        contentType:false,
                        cache:false,
                        processData:false,
                        dataType: 'json',
                        success:function(response){
                            //console.log(response);
                            if(response.error){
                                $("#image").addClass('is-invalid');
                                $("#image").next().text(response.message.image);
                            }else{
                                $("#edit_post_modal").modal('hide');
                                $("#edit_post_form")[0].reset();
                                $("#image").removeClass('is-invalid');
                                $("#image").next().text('');
                                $("#edit_post_form").removeClass('was-validated');
                                Swal.fire(
                                   'Updated !',
                                    response.message,
                                   'success'
                                ).then(function() {
                                    // Reload the page after the SweetAlert is closed
                                    location.reload();
                                });
                            }
                            $("#edit_post_btn").text('Update Post');
                        }
                    });
                }
            });
        });

    </script>
</body>
</html>