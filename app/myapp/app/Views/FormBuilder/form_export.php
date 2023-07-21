<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Builder</title>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href=<?= base_url("css/styles.css") ?> rel="stylesheet" />
    <link href=<?= base_url("css/bootstrap.min.css") ?> rel="stylesheet">
    <link href=<?= base_url("css/form.css") ?> rel="stylesheet">
    <link href=<?= base_url("css/adminlte.min.css") ?> rel="stylesheet">
</head>

<body>
    <div class="grid-container-export" id="form-builder">
        <div id="form-fields" class="item1">
            <?php
            // Iterate $form array to build grid layout
            if (isset($form)) {
                $total_row = 0;
                $total_column = 0;
                foreach (json_decode($form) as $item) {
                    // Add row if it doesn't exist
                    if ($total_row - 1 < $item->row) {
                        $total_column = 0;
                        if ($total_row > 0) echo '</div>';
                        echo '<div class="rowGrid">';
                        $total_row++;
                    }
                    // Add column in row if it doesn't exist
                    if ($total_column <= $item->column) {
                        echo '<div class="item">' . $item->html . '</div>';
                        $total_column++;
                    }
                }
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-12">
            <button onclick="window.print()" class="btn btn-primary float-right" style="margin-right: 5px;"><i class="fas fa-print"></i> Print as PDF</button>
        </div>
    </div>
</body>

</html>