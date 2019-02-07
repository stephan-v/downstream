<template>
    <div class="add-project-webhook">
        <label for="toggle" class="col-sm-3 col-form-label">Webhook</label>
        <toggle-webhook :project="project" class="col-sm-9 d-flex align-items-center"></toggle-webhook>

        <small id="emailHelp" class="col-sm-12 text-muted">
            Deploy your code whenever you commit changes.
        </small>
    </div><!-- /.add-project-webhook -->
</template>

