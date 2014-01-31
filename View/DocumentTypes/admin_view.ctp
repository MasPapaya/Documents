<div class="cru">
	<div class="btn-options">
		<?php echo $this->Html->link('<i class="icon-list icon-white"></i>&nbsp;' . __('Back to List'), array('action' => 'index', 'admin' => true), array('class' => 'btn btn-primary', 'escape' => FALSE)); ?>	
	</div>
	<h2><?php echo __d('documents','Document Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($documentType['DocumentType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Entity'); ?></dt>
		<dd>
			<?php echo $this->Html->link($documentType['Entity']['name'], array('controller' => 'entities', 'action' => 'view', $documentType['Entity']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($documentType['DocumentType']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Alias'); ?></dt>
		<dd>
			<?php echo h($documentType['DocumentType']['alias']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Multiple'); ?></dt>
		<dd>
			<?php echo h($documentType['DocumentType']['is_multiple']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Use User'); ?></dt>
		<dd>
			<?php echo h($documentType['DocumentType']['use_user_id']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

