<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, height=device-height">
        <base href="http://localhost:8000" />

        <script src="https://draggable.github.io/formeo/assets/js/formeo.min.js"></script>
        <link rel="stylesheet" href="https://draggable.github.io/formeo/assets/css/formeo.min.css">
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        
        <script src="js/createAlert.js"></script>
        <link rel="stylesheet" href="css/alert.css">
        
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
        <div id='pageMessages'>
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
                        createAlert('','Form saved successfully','','success',true,true,'pageMessages');
                        location.href = '<?php echo base_url('/');?>';
                    }
                    else{
                        createAlert('Opps!','Something went wrong','There was an error saving the form.','danger',true,false,'pageMessages');
                    }
                })
                .catch(error => {
                    console.log(error);
                    createAlert('Opps!','Something went wrong','There was an error saving the form.','danger',true,false,'pageMessages');
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