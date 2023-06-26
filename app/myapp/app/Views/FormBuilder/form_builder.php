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

                var formName = prompt('Please enter a name for this form');

                if (formName){
                    var form = JSON.stringify({
                        'formName': formName,
                        'formData': JSON.stringify(formData),
                    });

                    console.log(form);

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
                        alert('Form saved successfully');
                        location.href = '<?php echo base_url('/');?>';
                    })
                    .catch(error => console.log(error));
                }
            }
        }

        if(<?php echo isset($form) ? 'true' : 'false' ?>){
            formData = JSON.parse(<?= json_encode($form, JSON_UNESCAPED_UNICODE); ?>);
            var formeo = new FormeoEditor({
                editorContainer: '#formeo-editor',
                events: {onSave: onSave},
            }, formData['formData']);
        }
        else {
            var formeo = new FormeoEditor({
                editorContainer: '#formeo-editor',
                events: {onSave: onSave},
            });

        }
    </script>

</html>