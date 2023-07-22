<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Builder</title>
    <style>
        table {
            font-family: arial, sans-serif;
            width: 100%;
            border: none;
            min-height: 60px;
        }

        td {
            text-align: center;
            border: 1px solid #ccc;
            padding: 10px;
            min-height: 60px;
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
                echo '<td>' . $item->html . '</td>';
                $total_column++;
            }
        }
        echo '</tr></tbody></table>';
    }
    ?>
</body>

</html>