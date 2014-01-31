<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><h3><?php echo __('Actions'); ?></h3></li>
			<li><?php echo $this->Ajs->link('<i class="icon-plus-sign"></i>'.__('New Language'),array('action'=>'add'),'','#primary-ajax');?></li>
		</ul>
	</div>
</div>

<div class="span8">
	<h2><?php echo __('Languages'); ?></h2>
	<table class="table table-condensed table-bordered table-striped">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('name'); ?></th>
				<th><?php echo $this->Paginator->sort('code'); ?></th>
				<th><?php echo $this->Paginator->sort('code2'); ?></th>
				<th><?php echo $this->Paginator->sort('website'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($languages as $language): ?>
				<tr>
					<td><?php echo h($language['Language']['id']); ?>&nbsp;</td>
					<td><?php echo h($language['Language']['name']); ?>&nbsp;</td>
					<td><?php echo h($language['Language']['code']); ?>&nbsp;</td>
					<td><?php echo h($language['Language']['code2']); ?>&nbsp;</td>
					<td><?php echo h($language['Language']['website']); ?>&nbsp;</td>
					<td class="actions">
						<div class="btn-group">
							<?php echo $this->Ajs->button('icon-pencil', array('action' => 'edit', $language['Language']['id']), '', '#primary-ajax'); ?>
							<?php echo $this->Ajs->button('icon-eye-open', array('action' => 'view', $language['Language']['id']), '', '#primary-ajax'); ?>
							<?php echo $this->Ajs->delete('<i class="icon-trash icon-white"></i>', array('action' => 'delete', $language['Language']['id']), array('escape' => false, 'class' => 'btn btn-danger'), array('update' => '#primary-ajax', 'confirm' => __('Are you sure you want to delete \" %s \"?', $language['Language']['id']))); ?>
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
				//'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
				//'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
				)
		);
		echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));
		?>
	</p>
	<div class="pagination pagination-centered">
		<?php echo $this->Ajs->numbers(); ?>
	</div>
</div>
