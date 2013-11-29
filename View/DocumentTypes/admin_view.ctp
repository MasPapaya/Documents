<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link('<i class="icon-list"></i>&nbsp;'.__('List Document Types'),array('action'=>'index'), array('escape' => FALSE));?></li>
		</ul>
	</div>
</div>

<div class="span8">
	<h2><?php echo __('Document Type'); ?></h2>
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
		<dt><?php echo __('Use User');?></dt>
		<dd>
			<?php echo h($documentType['DocumentType']['use_user_id']);?>
			&nbsp;
		</dd>
	</dl>
</div>
