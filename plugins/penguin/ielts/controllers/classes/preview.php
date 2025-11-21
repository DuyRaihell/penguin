<div class="layout">
    <div class="layout-row">
        <?= Form::open(['class' => 'layout stretch']) ?>
            <div class="layout-cell">
                <?= $this->formRenderPreview() ?>
            </div>
        <?= Form::close() ?>
    </div>
</div>