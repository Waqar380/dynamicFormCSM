<?php
require_once './header.php';

session_start();
$_SESSION["form_id"] = $_GET['id'];
?>

<div class="container">
    <div class="mt-5">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-6">
                <h3 id="formName">View Form</h3>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="../" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
        </div>
        
        <form id="dynamicForm" onsubmit="return validateForm()">
        </form>
        <div id="ack-message"></div>
        <button type="submit" onClick="validateForm()" id='submitbtn' class="btn btn-primary">Submit</button>
    </div>
</div>

<?php
require_once '../js/view.php';
require_once './footer.php';
?>