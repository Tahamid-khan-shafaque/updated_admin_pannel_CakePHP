<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Person> $persons
 */
?>
<div class="container" style="max-width: 118rem;position: relative;
    width: 108%;">


<div class="persons index content">
    <?= $this->Html->link(__('Crete Users'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Persons') ?></h3>
   



    <div style="float: right;">
        <?= $this->Form->create(null, ['type' => 'get']) ?>
        <?= $this->Form->input('search', [
    'label' => false,
    'placeholder' => 'Search',
    'class' => 'search-input', // Add a CSS class for styling
    'style' => 'padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;', // Inline CSS for styling
]) ?>

        <?= $this->Form->submit('Submit') ?>
        <?= $this->Form->end() ?>
    </div>





    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('phone') ?></th>
                    <th><?= $this->Paginator->sort('department') ?></th>
                    <th><?= $this->Paginator->sort('bloodgroup') ?></th>
                    <th><?= $this->Paginator->sort('gender') ?></th>
                    <th><?= $this->Paginator->sort('skillset') ?></th>
                    <th><?= $this->Paginator->sort('image') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($persons as $person): ?>
                <tr>
                    <td><?= $this->Number->format($person->id) ?></td>
                    <td><?= h($person->name) ?></td>
                    <td><?= h($person->email) ?></td>
                    <td><?= h($person->phone) ?></td>
                    <td><?= h($person->department) ?></td>
                    <td><?= h($person->bloodgroup) ?></td>
                    <td><?= h($person->gender) ?></td>
                    <td><?= h($person->skillset) ?></td>
                    <td><?= @$this->Html->image($person->image)?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $person->id]) ?>
                        <?= $this->Html->link(__('Download'), ['action' => 'download', $person->id]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers(['class' => 'pagination-number', 'style' => 'border: 1px solid green;']) ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p style="color: green; border: 1px solid black; padding: 5px; border-radius: 5px;">
    <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
</p>
    </div>

    </div>
    <script>
function downloadPDF(url) {

    var iframe = document.createElement('iframe');
    iframe.src = url;
    iframe.style.display = 'none';
    document.body.appendChild(iframe);
}
</script>
    
</div>
