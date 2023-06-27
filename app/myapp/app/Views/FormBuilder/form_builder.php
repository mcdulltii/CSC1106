<html>
    <head>
        <script src="https://draggable.github.io/formeo/assets/js/formeo.min.js"></script>
        <link rel="stylesheet" href="https://draggable.github.io/formeo/assets/css/formeo.min.css">

        <style>
            body {
                background: radial-gradient(circle, #484848, #2F3031);
                height: 100vh;
            }
            .formeo-panels-wrap .panel-labels {
                height: auto;
            }
            .field-control button, .formeo-controls .field-control button{
                height: auto;
            }
            .formeo.formeo-editor .children  {
                height: auto;
            }
        </style>

        <title>Form Builder</title>
    </head>

    <body>
        <div id='formeo-editor'></div>   
    </body>

    <script type="text/javascript">
        function onSave(formData){
            if (confirm('Are you sure you want to save this form?')){
                console.log(formData);

                var form = JSON.stringify({
                    'formData': JSON.stringify(formData),
                });

                console.log(form);

                // Send the form data to the server
                fetch('/form-builder/save-form', {
                    method: 'POST',
                    headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                    body: form
                })
                .then(response => {
                    console.log(response);

                    if(response.ok){
                        alert('Form saved successfully');
                        location.href = '<?php echo base_url('/');?>';
                    }
                    else{
                        alert('There was an error saving the form');
                    }
                })
                .catch(error => {
                    console.log(error);
                    alert('There was an error saving the form');
                });
            }
        }

        // If the form variable is set, we are editing an existing form
        // Else, we are creating a new form
        if(<?php echo isset($form) ? 'true' : 'false' ?>){
            // Parse the form variable into a JSON object
            formData = JSON.parse(<?= json_encode($form, JSON_UNESCAPED_UNICODE); ?>);
            // Create a new formeo editor instance with the form data
            var formeo = new FormeoEditor({
                editorContainer: '#formeo-editor',
                events: {onSave: onSave},
            }, formData['formData']);
        }
        else {
            // Create a new formeo editor instance
            var formeo = new FormeoEditor({
                editorContainer: '#formeo-editor',
                events: {onSave: onSave},
            });
        }
    </script>

</html>