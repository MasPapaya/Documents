<div class="DocumentTypes">
	<?php echo $this->Html->link('<i class="icon-plus-sign icon-white"></i>&nbsp;' . __d('documents','New Document Type'), array('action' => 'add', 'admin' => true), array('class' => 'btn btn-primary', 'escape' => FALSE)); ?>
	<div>
		<h2><?php echo __d('documents', 'Document Types'); ?></h2>
		<table class=" table table-condensed table-bordered table-striped">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('entity_id'); ?></th>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('alias'); ?></th>
					<th><?php echo $this->Paginator->sort('is_multiple'); ?></th>
					<th><?php echo $this->Paginator->sort('use_user_id'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($documentTypes as $documentType): ?>
					<tr>
						<td><?php echo h($documentType['DocumentType']['id']); ?>&nbsp;</td>
						<td>
							<?php //  echo h($documentType['Entity']['name'], array('controller' => 'entities', 'action' => 'view', $documentType['Entity']['id'])); ?>
							<?php echo h($documentType['Entity']['name']); ?>&nbsp;
						</td>
						<td><?php echo h($documentType['DocumentType']['name']); ?>&nbsp;</td>
						<td><?php echo h($documentType['DocumentType']['alias']); ?>&nbsp;</td>
		<!--					<td><?php //  echo h($documentType['DocumentType']['is_multiple']);		       ?>&nbsp;</td>-->
						<td><?php
						if ($documentType['DocumentType']['is_multiple'] == '1') {
							echo __('Yes');
						} else {
							echo __('No');
						}
							?>&nbsp;</td>

						<td><?php
						if ($documentType['DocumentType']['use_user_id'] == '1') {
							echo __('Yes');
						} else {
							echo __('No');
						}
							?>&nbsp;</td>
						<td class="actions">
							<div class="btn-group">
								<?php echo $this->Html->link('<i class="icon-pencil"></i>', array('action' => 'edit', $documentType['DocumentType']['id']), array('escape' => FALSE, 'class' => 'btn')) ?>
								<?php echo $this->Html->link('<i class="icon-eye-open"></i>', array('action' => 'view', $documentType['DocumentType']['id']), array('escape' => FALSE, 'class' => 'btn')) ?>
								<?php //echo $this->Ajs->link('<i class="icon-list"></i>', array('action' => 'index_detail', $documentType['DocumentType']['id']), 'btn', '#documents') ?>
								<?php echo $this->Ajs->link('<i class="icon-list"></i>', array('controller' => 'Documents', 'action' => 'index', $documentType['DocumentType']['id'], 0), 'btn', '#documents') ?>
								<?php
								echo $this->Form->postLink('<i class="icon-trash icon-white"></i>', array('action' => 'delete', $documentType['DocumentType']['id']), array('class' => 'btn btn-danger', 'escape' => FALSE), __('Are you sure you want to delete # %s?', $documentType['DocumentType']['name']));
								?>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<p>
			<?php
			$this->Paginator->options(array(
				'update' => '#primary-ajax',
				'evalScripts' => true,
				)
			);
			?>
		</p>
		<div class="pagination pagination-centered">
			<ul>
				<?php echo $this->Paginator->prev('<', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
				<?php echo $this->Paginator->numbers(array('tag' => 'li', 'separator' => '', 'currentTag' => 'a', 'currentClass' => 'active')); ?>
				<?php echo $this->Paginator->next('>', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
			</ul>
		</div>
		<div id="documents"></div>
	</div>
</div>