<div class="nav-collapse">
	<?php
		if ($this->Session->check('Auth.User')) {
			$user = $this->Session->read('Auth.User');
//			debug($user);
			switch ($user['group_id']) {
				case 1://User SuperAdmin
					echo $this->element('menu/superadmin');
					break;
				case 2://User Admin
					echo $this->element('menu/admin');
					break;
				case 3 ://User voulet
					echo $this->element('menu/user');
					break;
				default;
					echo $this->element('menu/guest');
					break;
			}
		} else {
			echo $this->element('menu/guest');
			}
	?>
</div>