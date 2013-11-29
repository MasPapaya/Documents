<ul class="nav">	
	<li><?php echo $this->Html->link('<i class="icon-user"></i>&nbsp;' . __('Users'), array('controller' => 'users', 'action' => 'index', 'admin' => true), array('escape' => false)); ?></li>	
	<li><?php echo $this->Html->link('<i class="icon-star"></i>&nbsp;' . __('Featureds'), array('controller' => 'Featureds', 'action' => 'index', 'admin' => true), array('escape' => false)); ?></li>		
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-home icon-black"></i>&nbsp;<?php echo __('Study') ?><b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
			<li><?php echo $this->Html->link(__('Schools'), array(				'controller'=>'Schools','action'=>'index','admin'=>true), array('escape'=>false));?></li>
			<li><?php echo $this->Html->link(__('Program Groups'), array(		'controller'=>'ProgramGroups','action'=>'index','admin'=>true));?></li>
			<li><?php echo $this->Html->link(__('Programs'), array(				'controller'=>'Programs','action'=>'index','admin'=>true));?></li>			
			<li><?php echo $this->Html->link(__('Study Types'), array(			'controller'=>'StudyTypes','action'=>'index','admin'=>true));?></li>
		</ul>
	</li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-bookmark icon-black"></i>&nbsp;<?php echo __('Skill') ?><b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
			<li><?php echo $this->Html->link(__('Skills'), array(				'controller'=>'Skills','action'=>'index','admin'=>true));?></li>
			<li><?php echo $this->Html->link(__('Skill Groups'), array(			'controller'=>'SkillGroups','action'=>'index','admin'=>true));?></li>
			<li><?php echo $this->Html->link(__('Skill Types'), array(			'controller'=>'SkillTypes','action'=>'index','admin'=>true));?></li>
		</ul>
	</li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-inbox icon-black"></i>&nbsp;<?php echo __('Company') ?><b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
			<li><?php echo $this->Html->link(__('companies'), array(			'controller' => 'companies', 'action' => 'index', 'admin' => true), array('escape' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Works'), array(				'controller'=>'works', 'action'=>'admin_index','admin'=>true), array('escape'=>false));?></li>	
			<li><?php echo $this->Html->link(__('Positions'), array(			'controller'=>'Positions','action'=>'index','admin'=>true), array('escape'=>false));?></li>	
			<li><?php echo $this->Html->link(__('Industries'), array(			'controller'=>'Industries','action'=>'index','admin'=>true), array('escape'=>false));?></li>
			<li class="divider"></li>
			<li><?php echo $this->Html->link(__('Job Types'), array(			'controller'=>'JobTypes','action'=>'index','admin'=>true));?></li>
			<li><?php echo $this->Html->link(__('Manager Groups'), array(		'controller'=>'ManagerGroups','action'=>'index','admin'=>true));?></li>
		</ul>
	</li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-wrench icon-black"></i>&nbsp;<?php echo __('System') ?><b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
			<li><?php echo $this->Html->link('<i class="icon-globe"></i>&nbsp;' .__('Languages'),		array('controller'=>'Languages','action'=>'index','admin'=>true), array('escape'=>false));?></li>
			<li><?php echo $this->Html->link('<i class="icon-map-marker"></i>&nbsp;' .__('Locations'),	array('controller'=>'locations','action'=>'index','admin'=>true), array('escape'=>false));?></li>
			<li><?php echo $this->Html->link('<i class="icon-file"></i>&nbsp;'.__('Documents'),			array('controller'=>'Documents', 'action'=>'pagecontents','admin'=>true), array('escape'=>false));?></li>	
			<li class="divider"></li>			
			<li><?php echo $this->Html->link(__('Resource Types'), array(			'controller' => 'ResourceTypes', 'action' => 'index', 'admin' => true)); ?></li>
			<li><?php echo $this->Html->link(__('Allowed Types'), array(			'controller' => 'AllowedTypes', 'action' => 'index', 'admin' => true)); ?></li>
			<li><?php echo $this->Html->link(__('Resource Group Types'), array(		'controller' => 'ResourceGroupTypes', 'action' => 'index', 'admin' => true)); ?></li>
			<li><?php echo $this->Html->link(__('Allowed Resource Types'), array(	'controller' => 'AllowedResourceTypes', 'action' => 'index', 'admin' => true)); ?></li>
		</ul>
	</li>	
</ul>