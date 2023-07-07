<?= $this->extend('layout/bootstrap') ?>

<?= $this->section('body') ?>
<div class="display"></div>

<!-- Button trigger -->
<button type="button" id="input/checkbox" class="btn btn-primary" onclick="this_clicked(this.id)">Checkbox</button>
<button type="button" id="input/text" class="btn btn-primary" onclick="this_clicked(this.id)">Text</button>
<button type="button" id="textarea" class="btn btn-primary" onclick="this_clicked(this.id)">Textarea</button>

<script>
    function this_clicked(type) {
        const request = new Request('http://localhost:8080/form-components/' + type, {
            method: "GET"
        });
        fetch(request)
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                for (const key in data){
                    if(data.hasOwnProperty(key)){
                        document.querySelector("div.display").innerHTML += data[key];
                    }
                }
            })
            .catch((error) => {
                console.error(error);
            });
    }
</script>
<?= $this->endSection() ?>