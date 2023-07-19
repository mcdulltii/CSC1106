<?= $this->extend('layout/bootstrap') ?>

<?= $this->section('body') ?>
<div class="grid-container" id="form-builder">
    <div id="form-fields" class="item3">
        <!-- The initial row with the "plus" button container -->
        <div class="rowGrid plus-button-container">  
            <div class="plus-button" onclick="addNewRow()">+</div>
        </div>
    </div>
    <div id="form-fields-buttons" class="item4"></div>
</div>
<div id='pageMessages'></div>

<script>
// If the form variable is set, we are editing an existing form
// Else, do nothing as we are creating a new form
if(<?= isset($form) ? 'true' : 'false' ?>){
    // Parse the form variable into a JSON object
    formData = JSON.parse(<?= json_encode($form, JSON_UNESCAPED_UNICODE); ?>);
    console.log(formData);
    // Iterate thtough the json object and add each field to the form
    for (var i = 0; i < formData.length; i++) {
        addField(formData[i]);
    }
}

$(document).ready(function () {
    // Form fields array
    const form_fields = [
        { type: 'button', label: 'Button', properties: ['type', 'value'] },
        { type: 'fieldset', label: 'Fieldset', properties: ['legend'] }, //to change FormFieldset.php?
        { type: 'input', label: 'Input', properties: ['label', 'type', 'datalist'] },
        { type: 'label', label: 'Label', properties: ['form_name', 'value'] },
        { type: 'select', label: 'Select', properties: ['label','options','optgroups'] },
        { type: 'textarea', label: 'Text Area', properties: ['label', 'type'] }
    ];

    // Create modal
    var modal = $("<div class='modal fade' id='form-fields-modal' tabindex='-1' role='dialog' aria-labelledby='form-fields-modal-label' aria-hidden='true'></div>");
    var modal_dialog = $("<div class='modal-dialog' role='document'></div>");
    var modal_content = $("<div class='modal-content'></div>");
    var modal_header = $("<div class='modal-header'></div>");
    var modal_title = $("<h5 class='modal-title' id='form-fields-modal-label'></h5>");
    var modal_close_button = $("<button type='button' class='close' data-bs-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>");
    var modal_body = $("<div class='modal-body'></div>");
    var modal_footer = $("<div class='modal-footer'></div>");
    var modal_add_button = $("<button type='button' class='btn btn-primary' data-bs-dismiss='modal' id='modal-add-button'>Add</button>");

    // Append modal elements to modal
    modal_header.append(modal_title);
    modal_header.append(modal_close_button);
    modal_footer.append(modal_add_button);
    modal_content.append(modal_header);
    modal_content.append(modal_body);
    modal_content.append(modal_footer);
    modal_dialog.append(modal_content);
    modal.append(modal_dialog);

    // Append modal to #form-fields-buttons div
    $("#form-fields-buttons").append(modal);

    // Iterate form_fields to add buttons into #form-fields-buttons div, and add click event to each button to open a modal
    for (var i = 0; i < form_fields.length; i++) {
        (function(field) {
            // Create button
            button_label = field.label;
            var button = $("<button class='btn btn-secondary w-100 my-1' data-toggle='modal' data-target='#form-fields-modal'>" + field.label + "</button>");

            // Append button to #form-fields-buttons div
            $("#form-fields-buttons").append(button);

            // Add click event to button
            button.click(function () {

                var button_type = field.type;
                var properties = field.properties;
                var modalBodyHTML = generateModalBody(button_type, properties);
                if (button_type){
                    modal_body.empty();
                    modal_body.append(modalBodyHTML);
                } else{
                    modal_body.append("<p>Something went wrong</p>");
                }

                // Show modal
                modal_title.text(field.label);
                $("#form-fields-modal").modal('show');
            });
        })(form_fields[i]);
    }

    // Add button click event 
    modal_add_button.click(function () {
        var params = {};
        modal_body.find('input, select').each(function () {
            var key = $(this).attr('name');
            var value = $(this).val();
            params[key] = value;
        });
        console.log(params);
        console.log(modal_title.text().toLowerCase().replace(/ /g, ''));
        getFormElement(modal_title.text().toLowerCase().replace(/ /g, ''), params).then(function (formElem){
            appendHTMLToGrid(formElem["html"]);
        })
        
    });
});

// Function to add a new row when the "plus" button is clicked
function addNewRow() {
    var newRow = '<div class="rowGrid">' +
        '<div class="itemsContainer">' +
        '<div class="item">' +
        '<div class="delete-button" onclick="deleteCell(this)">x</div>' +
        '</div></div>' +
        '<div class="col-plus-button" onclick="addNewColumn(this.parentNode)">+</div>'+
        '</div>';
    document.getElementById("form-fields").insertBefore(createFragment(newRow), document.querySelector('.plus-button-container'));
}

// Function to add a new column when the "plus" button is clicked
function addNewColumn(row) {
    var newColumn = '<div class="item">' +
        '<div class="delete-button" onclick="deleteCell(this)">x</div>' +
        '</div>';
    var items = row.getElementsByClassName('item');
    var itemsContainer = row.querySelector('.itemsContainer');
    itemsContainer.insertAdjacentHTML('beforeend', newColumn);
}

// Function to create an HTML element from a string
function createFragment(htmlStr) {
    var template = document.createElement('template');
    template.innerHTML = htmlStr.trim();
    return template.content.firstChild;
}

// Function to append user-provided HTML above the "plus" button
function appendHTMLToGrid(htmlCode) {
    var newRow = '<div class="rowGrid">' +
        '<div class="itemsContainer">' +
        '<div class="item">' + htmlCode +
        '<div class="delete-button" onclick="deleteCell(this)">x</div>' +
        '</div></div>' +
        '<div class="col-plus-button" onclick="addNewColumn(this.parentNode)">+</div>'+
        '</div>';
        document.getElementById("form-fields").insertBefore(createFragment(newRow), document.querySelector('.plus-button-container'));
}

// Function to delete the cell when the delete button is clicked
function deleteCell(button) {
    var item = button.closest('.item');
    item.remove();
}



function generateModalBody(buttonType, properties){
        var modalBodyHTML = "";
        types = ["color", "date", "datetime-local", "email", "file", "hidden", "image", "month", "number", 
                    "password", "radio", "range", "reset", "search", "submit", "tel", "text", "time", "url", "week"];
        for (var i = 0; i < properties.length; i++) {
            var property = properties[i];
            if (buttonType == 'button' && property == 'type') {
                modalBodyHTML += '<div class="form-group row">' +
                    '<label class="col-sm-4 col-form-label">Type:</label>' +
                    '<div class="col-sm-8">' +
                    '<select name="type" id="bType" class="form-select">' +
                    '<option value="button">Button</option><option value="submit">Submit</option><option value="reset">Reset</option></select>' +
                    '</div></div>';
            } else if (buttonType == 'input' && property == 'type') {
                var options = "";
                for (var i = 0; i < types.length; i++) {
                    options += '<option value="' + types[i] + '">' + types[i] + '</option>'
                }
                modalBodyHTML += '<div class="form-group row">' +
                    '<label class="col-sm-4 col-form-label">Type:</label>' +
                    '<div class="col-sm-8">' +
                    '<select name="type" id="iType" class="form-select">' + options + '</select></div></div>';
            } else { // text fields
                modalBodyHTML += '<div class="form-group row">' + 
                    '<label for="' + property + '" class="col-sm-4 col-form-label">' + property.charAt(0).toUpperCase() + property.slice(1) + ':</label>' +
                    '<div class="col-sm-8">' + '<input type="text" class="form-control" name="'+ property + '" id="' + property + '"></div></div>';
            }
        }
        return modalBodyHTML;
    }


// function to call api for element json data with input type as parameter
function getFormElement(tag, params) {

    // Return form element after GET request succeeds
    return new Promise(function (resolve, reject) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var res = JSON.parse(this.responseText);
                console.log(res);
                resolve(res);
            }
        };
        // API route
        xhttp.open("POST", "/form-components/" + tag, true);
        xhttp.setRequestHeader('Content-type', 'application/json')
        xhttp.send(JSON.stringify(params));
    });
}
</script>
<?= $this->endSection() ?>
