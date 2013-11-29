<?php

?>
<ul class="nav">
	<li><?php echo $this->Html->link(__('Home'), array('controller' => 'pages', 'action' => 'home', 'admin' => false)); ?></li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo  __('User') ?><b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
			<li><?php echo $this->Html->link(__('Sign In'), array('plugin'=>'accounts','controller' => 'users', 'action' => 'login')); ?></li>
		</ul>
	</li>
</ul>