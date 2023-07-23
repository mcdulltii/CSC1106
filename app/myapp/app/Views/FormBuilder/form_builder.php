<?= $this->extend('layout/bootstrap') ?>

<?= $this->section('body') ?>
<div class="grid-container" id="form-builder">
    <datalist id="colorList">
        <option>#ffffff</option>
        <option>#e3eeff</option>
        <option>#bbbdbf</option>
        <option>#baf5ef</option>
        <!-- Add more predefined colors as needed -->
    </datalist>
    <div id="form-fields" class="item3">
        <div class="rowGrid plus-button-container">
            <div class="plus-button" onclick="addNewRow()">+</div>
        </div>
    </div>
    <div id="form-fields-buttons" class="item4"></div>
</div>
<div id='pageMessages'></div>

<script>
// Add a default row to the grid
addNewRow();

// If the form variable is set, we are editing an existing form
// Else, do nothing as we are creating a new form
if(<?= isset($form) ? 'true' : 'false' ?>){
    // Parse the form variable into a JSON object
    formData = JSON.parse(<?= json_encode($form, JSON_UNESCAPED_UNICODE); ?>);
    // Build grid layout from formData
    for (var i = 0; i < formData.length; i++) {
        var row = formData[i].row + 1;
        var col = formData[i].column + 1;
        var html = formData[i].html;
        var backgroundColor = formData[i].backgroundColor;
        var fontWeight = formData[i].fontWeight; // Get the font weight
        // Add row if it doesn't exist
        if (document.getElementById('form-fields').getElementsByClassName('rowGrid').length - 1 < row) {
            addNewRow();
        }
        // Add column in row if it doesn't exist
        if (document.getElementById('form-fields').getElementsByClassName('rowGrid')[row - 1].getElementsByClassName('item').length < col) {
            addNewColumn(document.getElementById('form-fields').getElementsByClassName('rowGrid')[row - 1]);
        }
        addHTMLToGrid(row, col, html);

        // Set the background color of the grid cell if it's available in formData
        var gridCell = document.getElementById('form-fields').getElementsByClassName('rowGrid')[row - 1].getElementsByClassName('item')[col - 1];
        if (backgroundColor) {
            gridCell.style.backgroundColor = backgroundColor;
        }
        if (fontWeight) {
            gridCell.style.fontWeight = fontWeight;
        }
    }
}

$(document).ready(function () {
    // Form fields array
    const form_fields = [
        { type: 'button', label: 'Button', properties: ['type', 'value'] },
        // { type: 'fieldset', label: 'Fieldset', properties: ['legend'] }, // TODO: to change FormFieldset.php?
        { type: 'input', label: 'Input', properties: ['label', 'type', 'datalist'] },
        { type: 'text', label: 'Text', properties: ['heading', 'text'] },
        { type: 'select', label: 'Select', properties: ['label','options','optgroups'] },
        { type: 'textarea', label: 'Text Area', properties: ['label', 'type'] }
    ];

    // Create modal
    var modal = $("<div class='modal fade' id='form-fields-modal' tabindex='-1' role='dialog' aria-labelledby='form-fields-modal-label' aria-hidden='true'></div>");
    var modal_dialog = $("<div class='modal-dialog' role='document'></div>");
    var modal_content = $("<div class='modal-content'></div>");
    var modal_header = $("<div class='modal-header'></div>");
    var modal_title = $("<h5 class='modal-title' id='form-fields-modal-label'></h5>");
    var modal_close_button = $("<button type='button' class='close btn btn-secondary' data-bs-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>");
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
    // Add save form button
    $("#form-fields-buttons").append('<div class="w-100"><button type="button" class="btn btn-primary" id="save-form">Save</button></div>')

    // Add button click event
    modal_add_button.click(function () {
        var params = {};
        modal_body.find('input, select').each(function () {
            var key = $(this).attr('name');
            var value = $(this).val();

            // Modify value for 'optgroups' and 'options' fields
            if (key == 'optgroups') {
                if (value != ''){
                    value = value.split(',').map(str => str.trim());
                    params[key] = value;
                }
            } else if (key == 'options') {
                if (value.includes('[')){
                    console.log("optgrps")
                    // Use regular expression to match values inside square brackets and split them into arrays
                    const regex = /\[(.*?)\]/g;
                    const matches = value.match(regex);
                    if (matches !== null) {
                        value = matches.map(item => {
                            const optionParts = item.slice(1, -1).split(',').map(str => str.trim());
                            return [optionParts[0], optionParts[1]];
                        });
                    } else {
                        value = [];
                    }
                } else{
                    console.log(value);
                    value = value.split(',').map(str => str.trim());
                    console.log("no optgrps");
                }
                params[key] = value;
            } else {
                params[key] = value;
            }
        });
        console.log(params);
        console.log(modal_title.text().toLowerCase().replace(/ /g, ''));
        getFormElement(modal_title.text().toLowerCase().replace(/ /g, ''), params)
        .then(function (formElem){
            addHTMLToGrid(document.getElementById('row').value, document.getElementById('column').value, formElem["html"]);
        })
        .catch(error => {
            createAlert('Oops!','Something went wrong','There was an error in the modal fields.','danger',true,false,'pageMessages');
        });
    });

    // Hide grid highlighting on modal close
    $('#form-fields-modal').on('hide.bs.modal', removeGridHighlight);

    // Save form button click event
    $("#save-form").click(function (e) {
        e.preventDefault();

        // Convert div of divs from #form-fields div into a JSON object
        var grid = document.getElementById("form-fields").getElementsByClassName("rowGrid");
        var form = [];
        for (var i = 0; i < grid.length; i++) {
            var row = grid[i].getElementsByClassName("item");
            for (var j = 0; j < row.length; j++) {
                var cell = row[j];
                // Replace delete button div with empty string
                var html = cell.innerHTML.replace(/<div class="delete-button" onclick="deleteCell\(this\)">&times;<\/div>/g, '');
                var backgroundColor = cell.style.backgroundColor;
                var fontWeight = window.getComputedStyle(cell).getPropertyValue('font-weight'); // Get the font weight
                form.push({ 'row': i, 'column': j, 'html': html, 'backgroundColor': backgroundColor, 'fontWeight': fontWeight });
            }
        }

        // Send the form data to the server
        fetch('/form/save', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({'formData': JSON.stringify(form)})
        })
        .then(response => {
            if (response.ok) {
                createAlert('','Form saved successfully','','success',true,true,'pageMessages');

                // Redirect to home if we are creating a new form
                if(<?= !isset($form) ? 'true' : 'false' ?>){
                    location.href = '<?= base_url('/') ?>';
                }
            }
            else{
                createAlert('Oops!','Something went wrong','There was an error saving the form.','danger',true,false,'pageMessages');
            }
        })
        .catch(error => {
            createAlert('Oops!','Something went wrong','There was an error saving the form.','danger',true,false,'pageMessages');
        });
    });
});

// Function to add a new row when the "plus" button is clicked
function addNewRow() {
    var newRow = '<div class="rowGrid" draggable="true" ondragstart="dragStart(event)" ondragover="dragOver(event)" ondragenter="dragEnter(event)" ondragleave="dragLeave(event)" ondrop="drop(event)">' +
        '<div class="itemsContainer">' +
        '<div class="item" draggable="true" ondragstart="dragStart(event)" ondragover="dragOver(event)" ondragenter="dragEnter(event)" ondragleave="dragLeave(event)" ondrop="drop(event)">' +
        '<div class="bold-button" onclick="toggleFontWeight(this)">B</div>' +
        '<div class="color-button" onclick="openColorInput(this)"></div>' +
        '<div class="delete-button" onclick="deleteCell(this)">&times;</div>' +
        '</div></div>' +
        '<div class="col-plus-button" onclick="addNewColumn(this.parentNode)">+</div>'+
        '</div>';
    document.getElementById("form-fields").insertBefore(createFragment(newRow), document.querySelector('.plus-button-container'));

}

// Function to add a new column when the "plus" button is clicked
function addNewColumn(row) {
    var newColumn = '<div class="item" draggable="true" ondragstart="dragStart(event)" ondragover="dragOver(event)" ondragenter="dragEnter(event)" ondragleave="dragLeave(event)" ondrop="drop(event)">' +
    '<div class="bold-button" onclick="toggleFontWeight(this)">B</div>' +
    '<div class="color-button" onclick="openColorInput(this)"></div>' +
    '<div class="delete-button" onclick="deleteCell(this)">&times;</div>' +
        '</div>';
    var items = row.getElementsByClassName('item');
    var itemsContainer = row.querySelector('.itemsContainer');
    itemsContainer.insertAdjacentHTML('beforeend', newColumn);

}

function toggleFontWeight(triggerElement) {
    var item = triggerElement.closest(".item");
    if (item) {
        // Get the first child element of the .item div
        var nestedElement = item.firstElementChild;
        if (nestedElement) {
            var tagName = nestedElement.tagName.toLowerCase();
            var currentFontWeight = item.dataset.fontWeight || window.getComputedStyle(nestedElement).getPropertyValue('font-weight');
            var initialFontWeight = item.dataset.initialFontWeight || window.getComputedStyle(nestedElement).getPropertyValue('font-weight');

            // Check if the nested element is an <h1>, <h2>, or <h3> tag
            if (tagName === 'h1' || tagName === 'h2' || tagName === 'h3') {
                // Toggle between font weights 900 and 700
                if (currentFontWeight === '900') {
                    nestedElement.style.fontWeight = 500;
                    item.dataset.fontWeight = '';
                } else {
                    nestedElement.style.fontWeight = 900;
                    item.dataset.fontWeight = '900';
                }
            } else {
                // For other elements, toggle between bold (700) and regular (400)
                if (currentFontWeight === 'bold') {
                    nestedElement.style.fontWeight = 400;
                    item.dataset.fontWeight = '';
                } else {
                    nestedElement.style.fontWeight = 'bold';
                    item.dataset.fontWeight = 'bold';
                }
            }

            // Store the initial font weight if it's not already set
            if (!item.dataset.initialFontWeight) {
                item.dataset.initialFontWeight = initialFontWeight;
            }
        }
    }
}

function openColorInput(triggerElement) {
    // Get the color input element
    var colorInput = document.querySelector("input[type='color']");

    // Position the color input relative to the trigger element
    var topPosition = 0;
    var leftPosition = 0;
    var currentElement = triggerElement;
    while (currentElement) {
        topPosition += currentElement.offsetTop;
        leftPosition += currentElement.offsetLeft;
        currentElement = currentElement.offsetParent;
    }

    colorInput.style.position = "absolute";
    colorInput.style.top = topPosition + "px";
    colorInput.style.left = leftPosition + "px";
    colorInput.style.zIndex = "9999"; // Set a higher z-index to ensure the color picker appears on top

    // Add an event listener to listen for color change events
    colorInput.addEventListener("change", function (event) {
        // Set the selected color as the background color of the trigger element
        triggerElement.style.backgroundColor = event.target.value;

        // If triggerElement is an ".item" element, change its background color
        var item = triggerElement.closest(".item");
        if (item) {
            item.style.backgroundColor = event.target.value;
        }

        // Hide the color input after color selection
        colorInput.style.display = "none";
    });

    // Show the color input when the function is called
    colorInput.style.display = "block";
}



// Function to create an HTML element from a string
function createFragment(htmlStr) {
    var template = document.createElement('template');
    template.innerHTML = htmlStr.trim();
    return template.content.firstChild;
}

// Function to append user-provided HTML above the "plus" button
function addHTMLToGrid(row, col, htmlCode) {
    if (row.length == 0 || col.length == 0) {
        createAlert('Oops!','Something went wrong','There was an error adding form element.','danger',true,false,'pageMessages');
        return;
    }
    var rowGrid = document.getElementById("form-fields").getElementsByClassName("rowGrid")[row - 1];
    var colGrid = rowGrid.getElementsByClassName('item')[col - 1];
    colGrid.innerHTML = htmlCode + '<div class="bold-button" onclick="toggleFontWeight(this)">B</div>' + '<div class="color-button" onclick="openColorInput(this)"></div>' +'<div class="delete-button" onclick="deleteCell(this)">x</div>' ;
    // Remove highlighted-item class from the selected cell
    colGrid.classList.remove('highlighted-item');
}

// Function to delete the cell when the delete button is clicked
function deleteCell(button) {
    var item = button.closest('.item');
    var row = item.closest('.rowGrid');
    var cells = row.getElementsByClassName('item');

    // If the row contains only one cell (excluding the "add column" button), remove the entire row
    if (cells.length === 1) {
        row.remove();
    } else {
        item.remove();
    }
}
let draggedItem = null;

function dragStart(event) {
    const target = event.target;
    if (target.classList.contains('item')) {
        draggedItem = target;
        event.dataTransfer.effectAllowed = 'move';
    } else {
        event.preventDefault(); // Prevent dragging the plus button or any other non-item element
    }
}

function dragOver(event) {
    event.preventDefault();
    event.dataTransfer.dropEffect = 'move';
}

function dragEnter(event) {
    event.target.classList.add('drag-over');
}

function dragLeave(event) {
    event.target.classList.remove('drag-over');
}

function drop(event) {
    event.preventDefault();
    const target = event.target.closest('.item');
    if (target && draggedItem) {
        const tempHTML = draggedItem.innerHTML;
        draggedItem.innerHTML = target.innerHTML;
        target.innerHTML = tempHTML;
    }
    event.target.classList.remove('drag-over');
}

function dragEnd() {
    draggedItem = null;
}
// Add event listeners to the document for drag and drop functionality
document.addEventListener('dragover', dragOver);
document.addEventListener('dragenter', dragEnter);
document.addEventListener('dragleave', dragLeave);
document.addEventListener('drop', drop);
document.addEventListener('dragend', dragEnd);

function generateModalBody(buttonType, properties){
    var modalBodyHTML = "";
    types = ["checkbox", "color", "date", "datetime-local", "email", "file", "hidden", "image", "month", "number",
                "password", "radio", "range", "reset", "search", "submit", "tel", "text", "time", "url", "week"];
    // Generate modal body HTML
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
        } else if (buttonType == 'text' && property == 'heading') {
            modalBodyHTML += '<div class="form-group row">' +
                '<label class="col-sm-4 col-form-label">Heading:</label>' +
                '<div class="col-sm-8">' +
                '<select name="heading" id="tHeading" class="form-select">' +
                '<option value="p">p</option>' +
                '<option value="h1">h1</option>' +
                '<option value="h2">h2</option>' +
                '<option value="h3">h3</option>' +
                '</select>' +
                '</div></div>';
        } else { // text fields
            modalBodyHTML += '<div class="form-group row">' +
                '<label for="' + property + '" class="col-sm-4 col-form-label">' + property.charAt(0).toUpperCase() + property.slice(1) + ':</label>' +
                '<div class="col-sm-8">' + '<input type="text" class="form-control" name="'+ property + '" id="' + property + '"></div></div>';
        }
    }

    // Get number of rows from #form-fields div
    var rows = document.getElementById('form-fields').getElementsByClassName('rowGrid').length - 1;
    // Add row dropdown selection to modal body
    modalBodyHTML += '<div class="form-group row">' +
        '<label for="row" class="col-sm-4 col-form-label">Row:</label>' +
        '<div class="col-sm-8">' +
        '<select name="row" id="row" class="form-select" onchange="detectRowChange(this)">';
    modalBodyHTML += '<option id="default-row" value="">Choose a row</option>';
    for (var i = 1; i <= rows; i++) {
        modalBodyHTML += '<option value="' + i + '">' + i + '</option>';
    }
    modalBodyHTML += '</select></div></div>';

    // Add column dropdown selection to modal body
    modalBodyHTML += '<div class="form-group row">' +
        '<label for="column" class="col-sm-4 col-form-label">Column:</label>' +
        '<div class="col-sm-8">' +
        '<select name="column" id="column" class="form-select" onchange="detectColChange(this)">' +
        '<option id="default-col" value="">Choose a column</option>' +
        '</select></div></div>';

    return modalBodyHTML;
}

function detectRowChange(sel) {
    removeGridHighlight();

    // Get number of columns in the row
    var cols = document.getElementById('form-fields').getElementsByClassName('rowGrid')[sel.value - 1].getElementsByClassName('item').length;
    // Add column dropdown options to modal body
    $('#column').empty();
    $('#column').append('<option id="default-col" value="">Choose a column</option>');
    for (var i = 1; i <= cols; i++) {
        $('#column').append('<option value="' + i + '">' + i + '</option>');
    }
    // Remove default row option
    $('#default-row').remove();
}

function detectColChange(column) {
    // Remove default col option
    $('#default-col').remove();
    // Get row and column number
    const row = document.getElementById('row').value;
    const col = column.value;
    var rowGrid = document.getElementById("form-fields").getElementsByClassName("rowGrid")[row - 1];
    var colGrid = rowGrid.getElementsByClassName('item')[col - 1];
    // Add highlighted-item class to the selected cell
    colGrid.classList.add('highlighted-item');
}

function removeGridHighlight() {
    for (let row of document.getElementById('form-fields').getElementsByClassName('rowGrid')) {
        for (let col of row.getElementsByClassName('item')) {
            col.classList.remove('highlighted-item');
        }
    }
}

// function to call api for element json data with input type as parameter
function getFormElement(tag, params) {
    // Return form element after GET request succeeds
    return new Promise(function (resolve, reject) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var res = JSON.parse(this.responseText);
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