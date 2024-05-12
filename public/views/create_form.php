<?php
require_once './header.php';
?>

<div class="container">
    <div class="mt-5">
        <div class="row">
            <div class="col-md-6">
                <h3>Create Dynamic Form</h3>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="../" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
        </div>

        <form id="createFormForm">
            <label for="formName">Form Name:</label>
            <input type="text" class="form-control" id="formName" name="formName" placeholder="Enter form name" required>
            <br />
            
            <div id="formFieldsContainer" style="max-height: 375px; overflow-y: auto;">
                <div id="formFields"></div>
            </div>
            <br />

            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Create Form</button>
            <button type="button" class="btn btn-success" id="addFieldBtn"><i class="fas fa-plus"></i> Add Field</button>
            
        </form>
    </div>
    </div>

<?php
require_once '../js/create.php';
require_once './footer.php';
?>