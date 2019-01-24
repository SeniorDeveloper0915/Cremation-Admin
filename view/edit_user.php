<?php
    session_start();
    include '../config/config.php';
    error_reporting(0);
// SESSION CHECK SET OR NOT
if (!isset($_SESSION['admin'])) {
    header('location:../index.php');
}

    $userId = $_GET['id'];

    // Query To Get User Data
    $userData = $db->prepare('SELECT * FROM banner WHERE id=?');
    $userData->execute(array($userId));
    $rowUser = $userData->fetch(PDO::FETCH_ASSOC);
?>
<div class="portlet light bordered" style="width: 1000px; position: absolute; left: 50%; transform: translate(-50%, 0%);">
    <div class="portlet-title">
        <div class="caption font-green" style="width: 100%;">
            <i class="icon-pencil font-green"></i>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <span class="caption-subject bold uppercase">Edit User</span>
        </div>
    </div>
    <form id="userUpdate" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-md-line-input">

                        <input type="hidden" name="id" value="<?php echo $rowUser['id'] ?>">
                        <input type="text" id="usernameUpdate" name="usernameUpdate" class="form-control input-sm" data-required="true"
                               value="<?php echo $rowUser['username'] ?>">
                        <label for="name" class="control-label">UserName</label>
                        <span class="form-control-focus"> </span>
                    </div>

                    <div class="form-group form-md-line-input">

                        <input type="hidden" name="id" value="<?php echo $rowUser['id'] ?>">
                        <input type="text" id="firstnameUpdate" name="firstnameUpdate" class="form-control input-sm" data-required="true"
                               value="<?php echo $rowUser['firstname'] ?>">
                        <label for="name" class="control-label">FirstName</label>
                        <span class="form-control-focus"> </span>
                    </div>

                    <div class="form-group form-md-line-input">

                        <input type="hidden" name="id" value="<?php echo $rowUser['id'] ?>">
                        <input type="text" id="lastnameUpdate" name="lastnameUpdate" class="form-control input-sm" data-required="true"
                               value="<?php echo $rowUser['lastname'] ?>">
                        <label for="name" class="control-label">LastName</label>
                        <span class="form-control-focus"> </span>
                    </div>

                    <div class="form-group form-md-line-input">
                        <input type="email" id="emailUpdate" name="emailUpdate" class="form-control input-sm"
                               data-parsley-type="email" data-required="true"
                               value="<?php echo $rowUser['email'] ?>">
                        <label for="email" class="control-label">Email</label>
                        <span class="form-control-focus"> </span>
                    </div>

                    <div class="form-group form-md-line-input">

                        <input type="hidden" name="id" value="<?php echo $rowUser['id'] ?>">
                        <input type="text" id="phonenumberUpdate" name="phonenumberUpdate" class="form-control input-sm" data-required="true"
                               value="<?php echo $rowUser['phonenumber'] ?>">
                        <label for="name" class="control-label">PhoneNumber</label>
                        <span class="form-control-focus"> </span>
                    </div>

                    <div class="form-group form-md-line-input">

                        <input type="hidden" name="id" value="<?php echo $rowUser['id'] ?>">
                        <input type="text" id="pinUpdate" name="pinUpdate" class="form-control input-sm" data-required="true"
                               value="<?php echo $rowUser['PIN'] ?>">
                        <label for="name" class="control-label">PIN</label>
                        <span class="form-control-focus"> </span>
                    </div>

                    <div class="form-group form-md-line-input form-md-floating-label">
                        <input type="text" id="passwordUpdate" name="passwordUpdate" class="form-control input-sm"
                               data-required="true" value="">
                        <label for="password" class="control-label">Password</label>
                        <span class="form-control-focus"> </span>
                        <span class="form-control-info"> (leave blank if you do not want to change password) </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
            <button type="submit" class="btn green btn-outline" name="submit" onclick="updateUser();return false">Submit</button>
        </div>
    </form>
</div>

