<?php if (isset($authuser['group_id']) && $authuser['group_id'] == '1' || $authuser['group_id'] == '2' ): ?>
<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-book"></i>&nbsp;<?php echo __('Documents') ?><b class="caret"></b></a>
	<ul class="dropdown-menu">		
		<li><?php echo $this->Html->link(__('Document Types'), array('controller' => 'DocumentTypes', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'documents')); ?></li>
		<li><?php echo $this->Html->link(__('Cms'), array('controller' => 'Cms', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'documents')); ?></li>
	</ul>
</li>

<?php endif; ?>