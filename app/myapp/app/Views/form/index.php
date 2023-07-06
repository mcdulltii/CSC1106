<?= $this->extend('layout/bootstrap') ?>

<?= $this->section('body') ?>

<?php if (isset($component)): ?>
    <div>
        <?php foreach ($component as $value): ?>
            <?= $value ?>
        <?php endforeach ?>
    </div>
<?php endif ?>

<!-- Button trigger modal -->
<button type="button" id="checkbox" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="this_clicked(this.id)">Checkbox</button>
<button type="button" id="text" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="this_clicked(this.id)">Text</button>
<button type="button" id="textarea" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="this_clicked(this.id)">Textarea</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo base_url('/form-components'); ?>" method="post">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <input type="hidden" id="input_type" name="input_type" value="<?= set_value('type') ?>" />

                    <label for="label">Enter Label</label>
                    <input type="input" name="label" value="<?= set_value('label') ?>">
                    <br>

                    <label for="value">Enter Value</label>
                    <input type="input" name="value" value="<?= set_value('value') ?>">
                    <br>

                    <label for="row">Enter Row</label>
                    <input type="input" name="row" value="<?= set_value('row') ?>">
                    <br>

                    <label for="col">Enter Col</label>
                    <input type="input" name="col" value="<?= set_value('col') ?>">
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Insert</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    function this_clicked(type) {
        document.getElementById("input_type").value = type;

        if (type == 'textarea') {
            modal = document.querySelector("div.modal-body");
            modal.innerHTML += `
                <label for="rows">Enter Height</label>
                <input type="input" name="rows" value="<?= set_value('rows') ?>">
                <br>

                <label for="cols">Enter Width</label>
                <input type="input" name="cols" value="<?= set_value('cols') ?>">
                <br>
            `;
        }
    }
</script>
<?= $this->endSection() ?>