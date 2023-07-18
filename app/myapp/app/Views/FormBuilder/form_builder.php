<?= $this->extend('layout/bootstrap') ?>

<?= $this->section('body') ?>
<div class="grid-container" id="form-builder">
    <div class="item3">
        <div id="form-fields" class="container h-100"></div>
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
    const form_fields = ['Button', 'Fieldset', 'Input', 'Label', 'Select', 'Textarea'];

    // Create modal
    var modal = $("<div class='modal fade' id='form-fields-modal' tabindex='-1' role='dialog' aria-labelledby='form-fields-modal-label' aria-hidden='true'></div>");
    var modal_dialog = $("<div class='modal-dialog' role='document'></div>");
    var modal_content = $("<div class='modal-content'></div>");
    var modal_header = $("<div class='modal-header'></div>");
    var modal_title = $("<h5 class='modal-title' id='form-fields-modal-label'></h5>");
    var modal_close_button = $("<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>");
    var modal_body = $("<div class='modal-body'></div>");
    var modal_footer = $("<div class='modal-footer'></div>");
    var modal_add_button = $("<button type='button' class='btn btn-primary' data-dismiss='modal'>Add</button>");

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
        // Create button
        var button = $("<button class='btn btn-secondary w-100 my-1' data-toggle='modal' data-target='#form-fields-modal'>" + form_fields[i] + "</button>");

        // Append button to #form-fields-buttons div
        $("#form-fields-buttons").append(button);

        // Add click event to button
        button.click(function () {
            // Get button text
            var button_text = $(this).text();

            // Empty modal body
            modal_body.empty();

            // Switch case for button text
            switch (button_text) {
                case "Button":
                    modal_body.append(""); // TODO
                    break;
                case "Fieldset":
                    modal_body.append(""); // TODO
                    break;
                case "Input":
                    modal_body.append(""); // TODO
                    break;
                case "Label":
                    modal_body.append(""); // TODO
                    break;
                case "Select":
                    modal_body.append(""); // TODO
                    break;
                case "Textarea":
                    modal_body.append(""); // TODO
                    break;
                default:
                    modal_body.append("<p>Something went wrong</p>");
            }

            // Show modal
            modal_title.text(button_text);
            $("#form-fields-modal").modal('show');
        });
    }

    // Add field button click event
    $("#add-field").click(function () {
        // get value from row, column label and input type inputs
        var row = $("#row-input").val();
        var col = $("#col-input").val();
        var label = $("#label-input").val();
        var type = $("#type-input").val();

        var element_data;
        // switch case for input type
        // mock element data from api
        switch (type) {
            case "input":
                var element_data = {
                    "row": row,
                    "col": col,
                    "html": ""
                };
                // Temporary button type for input form element
                getFormElement(label, type, "button").then(function (formElem) {
                    element_data["html"] = formElem["html"];
                    addField(element_data);
                });
                break;
            case "textarea":
                var element_data = {
                    "row": row,
                    "col": col,
                    "html": ""
                };
                // Temporary button type for input form element
                getFormElement(label, type).then(function (formElem) {
                    element_data["html"] = formElem["html"];
                    addField(element_data);
                });
                break;
        }

        // clear row and col input
        $("#row-input").val("");
        $("#col-input").val("");
        $("#label-input").val("");
    });

    // Delete field button click event
    $("#delete-field").click(function () {
        // get value from row and column inputs
        var row = $("#row-input").val();
        var col = $("#col-input").val();

        // get children elements of form-fields div
        var rows = $("#form-fields").children();

        // get child_row at index row
        var child_row = rows.eq(row - 1);

        // if child_row is undefined, do nothing
        // else if row is greater than number of rows, do nothing
        // else if row is less than 1, do nothing
        // else remove child_row
        if (child_row == undefined || child_row.length == 0) {
            console.log("child row is undefined");
        }
        else if (row > rows.length) {
            console.log("row is greater than child row length");
        }
        else if (row < 1) {
            console.log("row is less than 1");
        }
        else {
            console.log("row is defined");

            // get children elements of child_row
            var cols = child_row.children();

            // get child_col at index col
            var child_col = cols.eq(col - 1);

            // if child_col is undefined, do nothing
            // else if col is greater than number of cols, do nothing
            // else if col is less than 1, do nothing
            // else remove child_col
            if (child_col == undefined || child_col.length == 0) {
                console.log("child col is undefined");
            }
            else if (col > cols.length) {
                console.log("col is greater than child col length");
            }
            else if (col < 1) {
                console.log("col is less than 1");
            }
            else {
                console.log("col is defined");
                child_col.remove();
            }
        }

        // clear row and col input
        $("#row-input").val("");
        $("#col-input").val("");
        $("#label-input").val("");
    });

    // Save form button click event
    $("#save-form").click(function (e) {
        e.preventDefault();

        var formJson = []

        // get form-fields children
        var rows = $("#form-fields").children();

        // iterate through rows and col
        rows.each(function (index) {
            // get row children
            var cols = $(this).children();

            // iterate through cols
            cols.each(function (index) {

                // get input and label element html
                var input = $(this).find("input").prop("outerHTML");
                var label = $(this).find("label").prop("outerHTML");

                // create field object with the input and label html and row and column index
                var field = {
                    "label": label,
                    "input": input,
                    "row": $(this).parent().index() + 1,
                    "col": index + 1
                };

                // push field object to formJson array
                formJson.push(field);
            });
        });

        console.log(formJson);

        var formData = JSON.stringify({
            'formData': JSON.stringify(formJson),
        });

        // Send the form data to the server
        fetch('/form/save', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: formData
        })
        .then(response => {
            console.log(response);

            if(response.ok){
                createAlert('','Form saved successfully','','success',true,true,'pageMessages');

                // Redirect to home if we are creating a new form
                if(<?= !isset($form) ? 'true' : 'false' ?>){
                    location.href = '<?= base_url('/') ?>';
                }
            }
            else{
                createAlert('Opps!','Something went wrong','There was an error saving the form.','danger',true,false,'pageMessages');
            }
        })
        .catch(error => {
            console.log(error);
            createAlert('Opps!','Something went wrong','There was an error saving the form.','danger',true,false,'pageMessages');
        });
    });
});

// function to add field to form-fields div
// accepts fieldData object with label html, type html, row and col properties
function addField(fieldData) {
    // Convert div of divs from #form-fields into an array of arrays
    var rows = Array.from($("#form-fields").children()).map(function (row) {
        return Array.from($(row).children());
    });

    // If the row property of fieldData is greater than the number of divs in #form-fields, add divs until the number of divs in #form-fields is equal to the row property of fieldData
    if (fieldData["row"] > rows.length) {
        for (var i = 0; i < fieldData["row"]; i++) {
            // Create row div
            var row = $("<div class='col-sm border border-dark h-100'></div>");

            // Append row div to #form-fields div
            rows.push(row);
        }
    }

    // If the col property of fieldData is greater than the number of divs in the row property of fieldData, add divs until the number of divs in the row property of fieldData is equal to the col property of fieldData
    if (fieldData["col"] > rows[fieldData["row"] - 1].length) {
        for (var i = rows[fieldData["row"] - 1].length; i < fieldData["col"]; i++) {
            // Create col div
            var col = $("<div class='col-sm border border-dark h-100'></div>");

            // Append col div to row div
            rows[fieldData["row"] - 1].push(col);
        }
    }

    // Place html property of fieldData in the col div at index col - 1 in the row div at index row - 1
    rows[fieldData["row"] - 1][fieldData["col"] - 1].append(fieldData["html"]);

    // Convert array of arrays back into div of divs and append to #form-fields div
    $("#form-fields").empty();
    for (var i = 0; i < rows.length; i++) {
        var row = $("<div class='row border border-dark h-25'></div>");
        for (var j = 0; j < rows[i].length; j++) {
            row.append(rows[i][j]);
        }
        $("#form-fields").append(row);
    }
}

// function to call api for element json data with input type as parameter
function getFormElement(label, tag, type='') {
    const params = {
        label: label,
        type: type
    }
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
