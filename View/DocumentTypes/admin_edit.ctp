<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link('<i class="icon-list"></i> ' . __('List Document Types'), array('action' => 'index'), array('escape' => FALSE)); ?></li>
		</ul>
	</div>
</div>

<div class="span8">
	<?php echo $this->Form->create('DocumentType'); ?>
	<fieldset>
		<legend><?php echo __('Edit Document Type'); ?></legend>
		<?php
		echo $this->Form->input('id');
		echo $this->Form->input('entity_id');
		echo $this->Form->input('name');
		echo $this->Form->input('alias');
		echo $this->Form->input('is_multiple');
		echo $this->Form->input('use_user_id', array('type' => 'checkbox'));
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn btn-primary')); ?>
</div>

