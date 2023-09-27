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
            <?= $this->Html->link(__('Edit Person'), ['action' => 'edit', $person->id], ['class' => 'side-nav-item']) ?>
        
            <?= $this->Html->link(__('List Persons'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
         

        </div>

    </aside>
    <div class="column-responsive column-80">
        <div class="persons view content">
            <h3><?= h($person->name) ?></h3>
            <table>
            <tr>
    <th><?= __('Image') ?></th>
    <?php if (!empty($person->image)): ?>

        <td><img src="<?= $this->Url->image($person->image) ?>" alt="Person Image" style="width: 93px; height: 93px; border-radius: 70%;"></td>
    <?php else: ?>
        <td>No image available</td>
    <?php endif; ?>
</tr>


</tr>
       
       <th><?= __('Id') ?></th>
       <td><?= $this->Number->format($person->id) ?></td>
   </tr>
 
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($person->name) ?></td>
                </tr>
          
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($person->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($person->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Department') ?></th>
                    <td><?= h($person->department) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bloodgroup') ?></th>
                    <td><?= h($person->bloodgroup) ?></td>
                </tr>
                <tr>
                    <th><?= __('Gender') ?></th>
                    <td><?= h($person->gender) ?></td>
                </tr>
                <tr>
                    <th><?= __('Skillset') ?></th>
                    <td><?= h($person->skillset) ?></td>
               
            </table>
        </div>
    </div>
</div>
