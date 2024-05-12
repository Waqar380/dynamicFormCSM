<script>
        $(document).ready(function(){
            var fieldCounter = 0;

            function addFieldInput() {
                var fieldInput = `
                <div class="form-row">
                    <div class="form-group col">
                        <label for="fieldName${fieldCounter}">Field Name:</label>
                        <input type="text" class="form-control" id="fieldName${fieldCounter}" name="fieldName${fieldCounter}" placeholder="Enter field name">
                    </div>
                    <div class="form-group col">
                        <label for="fieldType${fieldCounter}">Field Type:</label>
                        <select class="form-control fieldType" id="fieldType${fieldCounter}" name="fieldType${fieldCounter}">
                            <option value="input">Input</option>
                            <option value="textarea">Textarea</option>
                            <option value="select">Select</option>
                            <option value="radio">Radio</option>
                            <option value="checkbox">Checkbox</option>
                        </select>
                    </div>
                    <div class="form-group col">
                        <label for="orderNumber${fieldCounter}">Order Number:</label>
                        <input type="number" class="form-control" id="orderNumber${fieldCounter}" name="orderNumber${fieldCounter}" placeholder="Enter order number" value="${fieldCounter+1}">
                    </div>
                    <div class="form-group col Validation">
                        <label for="validationRules${fieldCounter}">Validation Rules:</label>
                        <input type="text" class="form-control" id="validationRules${fieldCounter}" name="validationRules${fieldCounter}" placeholder="Enter validation rules (comma-separated)">
                        <small class="form-text text-muted">Example: required,min_length:5,numeric</small>
                    </div>
                    <div class="form-group col">
                        <label for="inputType${fieldCounter}" class="inputTypeLabel">Input Type:</label>
                        <input type="text" class="form-control inputType" id="inputType${fieldCounter}" name="inputType${fieldCounter}" placeholder="Enter input type">
                    </div>
                    <div class="form-group col optionFields" style="display: none;">
                        <label for="options${fieldCounter}">Options:</label>
                        <textarea class="form-control" id="options${fieldCounter}" name="options${fieldCounter}" rows="3" placeholder="Enter options (one per line)"></textarea>
                    </div>
                    <div class="form-group col">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="sendEmail${fieldCounter}" name="sendEmail${fieldCounter}">
                            <label class="form-check-label" for="sendEmail${fieldCounter}">Send Email</label>
                        </div>
                    </div>
                </div>`;
                $('#formFields').append(fieldInput);
                fieldCounter++;
            }

            $('#addFieldBtn').click(function(){
                addFieldInput();
            });

            $('#formFields').on('change', '.fieldType', function() {
                var selectedFieldType = $(this).val();
                var inputTypeLabel = $(this).closest('.form-row').find('.inputTypeLabel');
                var inputTypeField = $(this).closest('.form-row').find('.inputType');
                if (selectedFieldType === 'input') {
                    inputTypeLabel.show();
                    inputTypeField.show();
                } else {
                    inputTypeLabel.hide();
                    inputTypeField.hide();
                }
                var optionFields = $(this).closest('.form-row').find('.optionFields');
                var ValidationFields = $(this).closest('.form-row').find('.Validation');
                if (selectedFieldType === 'radio' || selectedFieldType === 'checkbox' || selectedFieldType === 'select') {
                    optionFields.show();
                    ValidationFields.hide();
                } else {
                    optionFields.hide();
                    ValidationFields.show();
                }
            });

            $('#createFormForm').submit(function(e){
                e.preventDefault();
                var formData = [];
                if(fieldCounter == 0){
                    alert('Please select atleast 1 form attribute.');
                    addFieldInput();
                    return;
                }
                for (var i = 0; i < fieldCounter; i++) {
                    var fieldData = {
                        form: $('#formName').val(),
                        name: $('#fieldName'+i).val(),
                        type: $('#fieldType'+i).val(),
                        order: $('#orderNumber'+i).val(),
                        validation: $('#validationRules'+i).val().split(','), 
                        input_type: $('#inputType'+i).val(),
                        options: $('#options'+i).val().split('\n').filter(Boolean),
                        send_email: $('#sendEmail'+i).is(':checked')
                    };
                    formData.push(fieldData);
                }
                // console.log(formData);return;
                
                $.ajax({
                    type: 'POST',
                    url: window.location.origin + '/dynamicFormCSM/api/create_form.php',
                    data: JSON.stringify(formData),
                    contentType: 'application/json',
                    success: function(response) {
                        alert('Form created successfully');
                        window.location.href = window.location.origin + '/dynamicFormCSM/public'
                    },
                    error: function(xhr, status, error) {
                        console.error('Error creating form:', error);
                    }
                });
            });
        });
    </script>