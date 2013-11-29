<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><h3><?php echo __('Actions'); ?></h3></li>
			<li><?php echo $this->Ajs->link('<i class="icon-list"></i>'.__('List Languages'),array('action'=>'index'),'','#primary-ajax');?></li>
		</ul>
	</div>
</div>

<div class="span8">
	<?php echo $this->Form->create('Language'); ?>
	<fieldset>
		<legend><?php echo __('Add Language'); ?></legend>
		<?php
		echo $this->Form->input('name');
		echo $this->Form->input('code');
		echo $this->Form->input('code2');
		echo $this->Form->input('website');
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label'=>__('Submit'),'class'=>'btn-primary')); ?>
</div>

