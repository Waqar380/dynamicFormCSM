<script>
    function validateForm() {
        var isValid = true;
        var error = '';

        $('input, textarea, select').each(function() {
            var $field = $(this);
            var rules = $field.data('validation-rules');
            if (rules) {
                var fieldValue = $field.val();
                rules.forEach(function(rule) {
                    var ruleParts = rule.split(':');
                    var ruleName = ruleParts[0];
                    var ruleParam = ruleParts[1];
                    if (ruleName === 'required' && !fieldValue) {
                        error += $field.attr('name') + ' is required. \n';
                        isValid = false;
                    } else if (ruleName === 'min_length' && fieldValue.length < ruleParam) {
                        error += $field.attr('name') + ' must be at least ' + ruleParam + ' characters.\n';
                        isValid = false;
                    }
                });
            }
        });

        var radioGroups = {};
        $('input[type="radio"]').each(function() {
            var groupName = $(this).attr('name');
            radioGroups[groupName] = radioGroups[groupName] || false;
            if ($(this).is(':checked')) {
                radioGroups[groupName] = true;
            }
        });
        $.each(radioGroups, function(groupName, isChecked) {
            if (!isChecked) {
                error += 'Please select a value for ' + groupName + '.\n';
                isValid = false;
            }
        });
        
        var checkboxGroups = {};
        $('input[type="checkbox"]').each(function() {
            var groupName = $(this).attr('name');
            checkboxGroups[groupName] = checkboxGroups[groupName] || false;
            if ($(this).is(':checked')) {
                checkboxGroups[groupName] = true;
            }
        });
        $.each(checkboxGroups, function(groupName, isChecked) {
            if (!isChecked) {
                error += 'Please select at least one option for ' + groupName + '.\n';
                isValid = false;
            }
        });
        if(isValid){
            getToken(event);
        }else{
            alert(error);
        }
        
    }

    function getToken(event) {
        event.preventDefault();

        grecaptcha.ready(function() {
            grecaptcha.execute('<?php echo Config::GOOGLE_RECAPTCHA_SITE_KEY; ?>', { action: 'submit' }).then(function(token) {

                var button = document.createElement('input');
                button.type = 'hidden';
                button.name = 'recaptcha_token';
                button.id = 'recaptcha_token';
                button.value = token;

                var form = document.getElementById("dynamicForm");
                form.appendChild(button);

                submitForm();
            });;
        });
    }

    function submitForm() {
        $("#submitbtn").html('Sending ...');
        const form = document.getElementById('dynamicForm');
        const formData = new FormData(form);
        var xhttp = new XMLHttpRequest();
        xhttp.open('POST', '../../api/form_submit.php', true);
        xhttp.send(formData);
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 201) {
                $("#submitbtn").html('Submitted');
                document.getElementById("ack-message").innerHTML = 'From submission successful';
                document.getElementById('recaptcha_token').remove();
                alert('From submission successful');
            }
        }
    }

    $(document).ready(function(){
        $.ajax({
            type: 'POST',
            url: window.location.origin + '/dynamicFormCSM/api/get_Single_form.php',
            contentType: 'application/json',
            data: JSON.stringify({formId: <?php echo $_SESSION["form_id"] ?>}),
            success: function(response) {
                
                var formData = response.data;
                var formHtml = '';
                $('#formName').html(`View - ${formData[0]['form_name']}`);

                formData.forEach(function(field) {
                    var inputType = field.type;
                    var inputName = field.name;
                    var inputId = 'field_' + field.id;
                    var validationRules = JSON.parse(field.validation);
                    var options = JSON.parse(field.options);

                    formHtml += '<div class="form-group">';
                    formHtml += '<label for="' + inputId + '">' + inputName.replace(" ", "_") + '</label>';

                    if (inputType === 'input') {
                        formHtml += '<input type="' + field.input_type + '" class="form-control" id="' + inputId + '" name="' + inputName.replace(" ", "_") + '" data-validation-rules=\'' + JSON.stringify(validationRules) + '\'>';
                    } else if (inputType === 'textarea') {
                        formHtml += '<textarea class="form-control" id="' + inputId + '" name="' + inputName.replace(" ", "_") + '" data-validation-rules=\'' + JSON.stringify(validationRules) + '\'></textarea>';
                    } else if (inputType === 'select') {
                        formHtml += '<select class="form-control" id="' + inputId + '" name="' + inputName.replace(" ", "_") + '" data-validation-rules=\'' + JSON.stringify(validationRules) + '\'>';
                        options.forEach(function(option) {
                            formHtml += '<option value="' + option + '">' + option + '</option>';
                        });
                        formHtml += '</select>';
                    } else if (inputType === 'radio') {
                        options.forEach(function(option) {
                            formHtml += '<div class="form-check">';
                            formHtml += '<input class="form-check-input" type="radio" id="' + inputId + '_' + option + '" name="' + inputName.replace(" ", "_") + '" value="' + option + '" data-validation-rules=\'' + JSON.stringify(validationRules) + '\'>';
                            formHtml += '<label class="form-check-label" for="' + inputId + '_' + option + '">' + option + '</label>';
                            formHtml += '</div>';
                        });
                    } else if (inputType === 'checkbox') {
                        options.forEach(function(option) {
                            formHtml += '<div class="form-check">';
                            formHtml += '<input class="form-check-input" type="checkbox" id="' + inputId + '_' + option + '" name="' + inputName.replace(" ", "_") + '" value="' + option + '" data-validation-rules=\'' + JSON.stringify(validationRules) + '\'>';
                            formHtml += '<label class="form-check-label" for="' + inputId + '_' + option + '">' + option + '</label>';
                            formHtml += '</div>';
                        });
                    }

                    formHtml += '</div>';
                });
                formHtml += '<input type="hidden" id="form_id" name="form_id" value="'+ <?php echo $_SESSION["form_id"] ?> +'">';

                $('#dynamicForm').html(formHtml);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching form:', error);
            }
        });
    });
</script>