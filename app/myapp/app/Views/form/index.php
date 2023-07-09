<?= $this->extend('layout/bootstrap') ?>

<?= $this->section('body') ?>
<div class="display"></div>

<!-- Button trigger -->
<button type="button" id="input" class="btn btn-primary" onclick="this_clicked(this.id, 'checkbox')">Checkbox</button>
<button type="button" id="input" class="btn btn-primary" onclick="this_clicked(this.id, 'text')">Text</button>
<button type="button" id="textarea" class="btn btn-primary" onclick="this_clicked(this.id)">Textarea</button>

<script>
    function this_clicked(tag, type = '') {
        const request = new Request('http://localhost:8080/form-components/' + tag, {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                label: "do u wan bik",
                type: type,
            }),
        });
        fetch(request)
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                for (const key in data) {
                    if (data.hasOwnProperty(key)) {
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