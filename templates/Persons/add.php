<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Person $person
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Persons'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="persons form content">
            <?= $this->Form->create($person,['type'=>'file']) ?>
            <fieldset>
                <legend><?= __('Add Person') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('email');
                    echo $this->Form->control('phone');
                    echo $this->Form->control('department', ['options' => ['cse' => 'CSE', 'hr' => 'HR', 'philosophy' => 'Philosophy']]);
                    echo $this->Form->control('bloodgroup', ['options' => [
                        'A+' => 'A+',
                        'A-' => 'A-',
                        'B+' => 'B+',
                        'B-' => 'B-',
                        'AB+' => 'AB+',
                        'AB-' => 'AB-',
                        'O+' => 'O+',
                        'O-' => 'O-',
                    ]]);
                    echo $this->Form->control('gender', [
                        'type' => 'radio',
                        'options' => [
                            'male' => 'Male',
                            'female' => 'Female',
                        ],
                    ]);

                    echo $this->Form->control('skillset', [
                        'type' => 'radio',
                        'options' => [
                            'laravel' => 'Laravel',
                            'cakephp' => 'CakePHP',
                            'php' => 'PHP',
                        ],
                    ]);
                    echo $this->Form->control('image_file',['type'=>'file']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
