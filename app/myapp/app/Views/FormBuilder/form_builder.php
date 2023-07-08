<!DOCTYPE html>
<html>

<head>
    <title>Form Builder</title>

    <base href="<?php echo base_url()?>" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    
    <link href="css/styles.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    
    <script src="js/createAlert.js"></script>
    <link rel="stylesheet" href="css/alert.css">
    <style>
        .item3 {
            grid-area: main;
        }

        .item4 {
            grid-area: right;
        }

        .grid-container {
            display: grid;
            grid-template-areas:
                'main main main main right';
            gap: 10px;
            background-color: #2196F3;
            padding: 10px;
        }

        .grid-container>div {
            background-color: rgba(255, 255, 255, 0.8);
            text-align: center;
            padding: 20px 0;
            font-size: 20px;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="grid-container" id="form-builder">
        <div id="form-fields" class="item3 container">
            <!-- The form fields will be dynamically added here -->

        </div>
        <div class="item4">
            <div><label>Row</label><input type="text" id="row-input"></div>
            <div><label>Column</label><input type="text" id="col-input"></div>
            <div><label>Label</label><input type="text" id="label-input"></div>
            <div><label>Input type</label>
                <select id="type-input">
                    <option value="text">Text</option>
                    <option value="textarea">Text Area</option>
                </select>
            </div>
            <div><button type="button" id="add-field">Add Field</button></div>
            <div><button type="button" id="delete-field">Delete Field</button></div>
            <div><button type="button" id="save-form">Save</button></div>
        </div>
    </div>
    <div id='pageMessages'></div>
</body>

</html>

<script>
    // If the form variable is set, we are editing an existing form
    // Else, do nothing as we are creating a new form
    if(<?php echo isset($form) ? 'true' : 'false' ?>){
        // Parse the form variable into a JSON object
        formData = JSON.parse(<?= json_encode($form, JSON_UNESCAPED_UNICODE); ?>);
        console.log(formData);
        // Iterate thtough the json object and add each field to the form
        for (var i = 0; i < formData.length; i++) {
            addField(formData[i]);
        }
    }

    $(document).ready(function () {

        // Add field button click event
        $("#add-field").click(function () {

            // get value from row, column label and input type inputs
            var row = $("#row-input").val();
            var col = $("#col-input").val();
            var label = $("#label-input").val();
            var type = $("#type-input").val();

            // #TODO call api for element json data with row, column, label and input type as parameters

            var element_data;
            // switch case for input type
            // mock element data from api
            switch (type) {
                case "text":
                    var element_data = {
                        "row": row,
                        "col": col,
                        "label": "<label>" + label + ":</label>",
                        "input": "<input type='" + type + "'>"
                    };
                    break;
                case "textarea":
                    type = "textarea";
                    break;
            }

            addField(element_data);

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
                    if(<?php echo !isset($form) ? 'true' : 'false' ?>){
                        location.href = '<?php echo base_url('/');?>';
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

        var field = $("<div class='col'></div>");
        field.append(fieldData.label);
        field.append(fieldData.input);

        // get children elements of form-fields div
        var rows = $("#form-fields").children();

        // get child_row at index row
        var child_row = rows.eq(fieldData.row - 1);

        // if child_row is undefined, create a new row
        // else if row is greater than number of rows, create a new row and append to form-fields
        // else if row is less than 1, create a new row and prepend to form-fields
        // else append field to child_row
        if (child_row == undefined || child_row.length == 0) {
            console.log("child row is undefined");
            child_row = $("<div class='row'></div>");
            child_row.append(field);
            $("#form-fields").append(child_row);
        }
        else if (fieldData.row > rows.length) {
            console.log("row is greater than child row length");
            new_row = $("<div class='row'></div>");
            new_row.append(field);
            $("#form-fields").append(new_row);
        }
        else if (fieldData.row < 1) {
            console.log("row is less than 1");
            new_row = $("<div class='row'></div>");
            new_row.append(field);
            $("#form-fields").prepend(new_row);
        }
        else {
            console.log("row is defined");
            // child_row.append(field);

            // get children elements of child_row
            var cols = child_row.children();

            // get child_col at index col
            var child_col = cols.eq(fieldData.col - 1);

            // if child_col is undefined, create a new col
            // else if col is greater than number of cols, create a new col and append to child_row
            // else if col is less than 1, create a new col and prepend to child_row
            // else insert field before child_col
            if (child_col == undefined || child_col.length == 0) {
                console.log("child col is undefined");
                child_row.append(field);
            }
            else if (fieldData.col > cols.length) {
                console.log("col is greater than child col length");
                child_row.append(field);
            }
            else if (fieldData.col < 1) {
                console.log("col is less than 1");
                child_row.prepend(field);
            }
            else {
                console.log("col is defined");
                field.insertBefore(child_col);
            }

        }
    }
</script>