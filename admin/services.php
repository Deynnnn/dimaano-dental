<?php
    require('includes/essentials.php');
    require('includes/dbConfig.php');

    adminLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN PANEL - SERVICES</title>
    <?php require('includes/links.php');?>
    <style>
        .custom-alert{
            position: fixed;
            top: 80px;
            right: 25px;
        }
        .custom-bg{
            background-color: #A51012;
            border: 1px solid #A51012;
        }
        #dashboard-menu{
            position: fixed;
            height: 100%;
            z-index: 11;
        }

        @media screen and (max-width: 991px){
            #dashboard-menu{
                height: auto;
                width: 100%;
            }
            #main-content{
                margin-top: 60px;
            }
        }
    </style>
</head>
<body class="bg-white">
<?php 
    require('includes/header.php');
?>
<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <div class="text-end d-flex justify-content-between align-items-center">
                <h4 class="mb-4">SERVICES</h4>
                <button type="button" class="btn custom-bg text-white fw-medium shadow-none btn-md" data-bs-toggle="modal" data-bs-target="#add-service"><i class="bi bi-plus-square"></i> Add</button>
            </div>

            <div class="card border-0 shadow-none mb-4">
                <div class="card-body">
                    <div id="serviceData" class="row">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--add service modal-->
<div class="modal fade" id="add-service" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="genSettingEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="add_service_form" autocomplete="off">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Room</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="name" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Price</label>
                            <input type="number" min="1" name="price" class="form-control shadow-none" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" required rows="4" class="form-control shadow-none"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal" >CANCEL</button>
                    <button type="submit" class="btn custom-bg text-white">SUBMIT</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--edit service modal-->
<div class="modal fade" id="edit-service" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="genSettingEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="edit_service_form" autocomplete="off">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Service</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="name" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Price</label>
                            <input type="number" min="1" name="price" class="form-control shadow-none" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" required rows="4" class="form-control shadow-none"></textarea>
                        </div>
                        <input type="hidden" name="service_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal" >CANCEL</button>
                    <button type="submit" class="btn custom-bg text-white">SUBMIT</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--room image modal-->
<div class="modal fade" id="service-image" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">SERVICE NAME</h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div id="image-alert"></div>
            <div class="border-bottom border-3 mb-3 pb-3">
                <form id="add_image_form" enctype="multipart/form-data">
                        <label class="form-label fw-bold">Add Image</label>
                        <input type="file" name="image" accept="[.jpg, .png, .webp, .jpeg]" class="form-control shadow-none mb-3" required>
                        <button class="btn custom-bg text-white shadow-none">ADD</button>
                        <input type="hidden" name="service_id">
                </form>
            </div>
            <div class="table-responsive-lg" style="height: 350px; overflow-y: scroll;">
                <table class="table table-hover text-center">
                    <thead>
                        <tr class="bg-dark text-white sticky-top">
                        <th scope="col" width="60%">Image</th>
                        <th scope="col">Thumb</th>
                        <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody id="service-image-data">
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
</div>
    <?php require('includes/scripts.php');?>
    <script src="scripts/services.js"></script>
</body>
</html>