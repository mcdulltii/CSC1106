<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Builder</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        table {
            font-family: arial, sans-serif;
            width: 100%;
            border: none;
        }

        td {
            text-align: center;
            border: 1px solid #ccc;
            padding: 10px;
            height: 60px;
            width: 60px;
        }

        button {
            background-color: #547aa5;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 15px;
            cursor: pointer;

        }

        fieldset {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 8px;
        }

        legend {
            font-weight: bold;
        }

        text.items {
            align-items: center;
            margin-top: 0;
            margin-bottom: 0;
        }

        input {
            border: 1px solid #ccc;
            border-radius: 50px;
            padding: 8px;
        }

        textarea {
            vertical-align: middle;
            border: 1px solid #ccc;
            border-radius: 30px;
            padding: 8px;
        }

        select {
            color: #333;
            font-size: 16px;
            padding: 10px 20px;
            text-decoration: none;
            background-color: #f5f5f5;
            color: #333;
            border-radius: 15px;
            cursor: pointer;
        }

        label {
            margin-bottom: 5px;
            padding: 8px;
        }
    </style>
</head>

<body>
    <?php
    // Iterate $form array to build grid layout
    if (isset($form)) {
        $total_row = 0;
        $total_column = 0;
        foreach (json_decode($form) as $item) {
            // Add row if it doesn't exist
            if ($total_row - 1 < $item->row) {
                $total_column = 0;
                if ($total_row > 0) echo '</tr></tbody></table>';
                echo '<table><tbody><tr>';
                $total_row++;
            }
            // Add column in row if it doesn't exist
            if ($total_column <= $item->column) {
                echo '<td style="background-color: ' . $item->backgroundColor . '" data-font-weight: "' . $item->fontWeight . '">' . $item->html . '</td>';
                $total_column++;
            }
        }
        echo '</tr></tbody></table>';
    }
    ?>
</body>

</html>