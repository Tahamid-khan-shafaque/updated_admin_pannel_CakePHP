<br>
<div class="index large-4 medium-4 large-offset-4 medium-offset-4 columns">
	<div class="panel">
		<h2 class="text-center">Please Register</h2>
		<?= $this->Form->create($user); ?>
        <?= $this->Form->input('name', ['type' => 'text', 'placeholder' => 'Enter your name']) ?>
            <?= $this->Form->input('email', ['type' => 'text', 'placeholder' => 'Enter your email']) ?>
            <?= $this->Form->input('password', ['type' => 'password', 'placeholder' => 'Enter your password']) ?>
			<?= $this->Form->submit('Register', array('class' => 'button')); ?>
		<?= $this->Form->end(); ?>
	</div>
</div>