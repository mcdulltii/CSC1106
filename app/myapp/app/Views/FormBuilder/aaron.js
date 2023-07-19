// addField({'row':1, 'col':1, 'html':'<p>hi</p>'})
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