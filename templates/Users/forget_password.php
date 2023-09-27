<h1>Forget Password</h1>

<?= $this->Form->create() ?>
    <?= $this->Form->control('email', ['type' => 'email', 'required' => true]) ?>
    <?= $this->Form->button('Submit') ?>
<?= $this->Form->end() ?>