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
    <title>DentalPal - Services</title>
    <?php require('includes/links.php');?>
    <style>
        .custom-alert{
            position: fixed;
            top: 80px;
            right: 25px;
            z-index: 99999;
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
<body style="background-color: rgb(248,247,250);">
<?php 
    require('includes/header.php');
?>
<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-4">Announcements</h4>
                        <button type="button" class="btn btn-success shadow-none btn-md" data-bs-toggle="modal" data-bs-target="#add-service"><i class="bi bi-plus-square"></i> Add</button>
                    </div>
                    <div class="table-responsive-lg" style="height: 650px; overflow-y: scroll;">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr class="text-white" style="background-color: rgb(100,20,22);">
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col" style="width:45%">Description</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="serviceData">
                            </tbody>
                        </table>
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
                    <h5 class="modal-title">Add Announcements</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="name" class="form-control shadow-none" required>
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
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="name" class="form-control shadow-none" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" required rows="4" class="form-control shadow-none"></textarea>
                        </div>
                        <input type="hidden" name="announcement_id">
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
    <?php require('includes/scripts.php');?>
    <script src="scripts/announcement.js"></script>
</body>
</html>