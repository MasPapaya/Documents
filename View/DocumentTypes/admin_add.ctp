<div class="cru">
	<div class="btn-options">
		<?php echo $this->Html->link('<i class="icon-list icon-white"></i>&nbsp;' . __('Back to List'), array('action' => 'index', 'admin' => true), array('class' => 'btn btn-primary', 'escape' => FALSE)); ?>	
	</div>
	<?php echo $this->Form->create('DocumentType'); ?>
	<fieldset>
		<legend><?php echo __('Add Document Type'); ?></legend>
		<?php
		echo $this->Form->input('entity_id');
		echo $this->Form->input('name');
		echo $this->Form->input('alias');
		echo $this->Form->input('is_multiple');
		echo $this->Form->input('use_user_id', array('type' => 'checkbox'));
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label' => __('Save'), 'class' => 'btn btn-primary')); ?>
</div>

