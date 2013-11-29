<?php
// $this->Html->script(array(
// 	'/' . strtolower($this->plugin) . '/js/jquery-1.10.2.min',
// 	'/' . strtolower($this->plugin) . '/js/jquery-1.9.1.min',
// 	'/' . strtolower($this->plugin) . '/js/tinymce/tinymce.min',
// 	'/' . strtolower($this->plugin) . '/js/admin_doc'
// 		), array('inline' => false));

// $this->Html->css(array(
// 	'/' . strtolower($this->plugin) . '/css/jquery_ui.min',
// 	'/' . strtolower($this->plugin) . '/css/content'
// 		), null, array('inline' => false));
?>
<script type="text/javascript">
	//var baseurl = '<?php echo $this->html->url('/documents/'); ?>';
</script>
<div class="row-fluid">
	<div class="span12">
		<h2><?php echo __('UsersCms'); ?></h2>
		<table class=" table table-condensed table-bordered table-striped">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('alias'); ?></th>
					<th><?php echo $this->Paginator->sort('is_multiple'); ?></th>
					<th><?php echo $this->Paginator->sort('use_user_id'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($documentTypes as $documentType): ?>
					<tr>
						<td><?php echo h($documentType['DocumentType']['id']); ?>&nbsp;</td>
						<td><?php echo h($documentType['DocumentType']['name']); ?>&nbsp;</td>
						<td><?php echo h($documentType['DocumentType']['alias']); ?>&nbsp;</td>
						<td><?php
							if ($documentType['DocumentType']['is_multiple'] == '1') {
								echo __('Yes');
							} else {
								echo __('No');
							}
							?>&nbsp;</td>
						<td>
							<?php
							if ($documentType['DocumentType']['use_user_id'] == '1') {
								echo __('Yes');
							} else {
								echo __('No');
							}
							?>&nbsp;
						</td>
						<td class="actions">
							<div class="btn-group">
								<?php echo $this->Ajs->link('<i class="icon-list"></i>', array('controller' => 'Documents', 'action' => 'index', $documentType['DocumentType']['id'], 0), 'btn', '#documents') ?>
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
					)
			);
			echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));
			?>
		</p>
		<div class="pagination pagination-centered">
			<ul>
				<?php echo $this->Paginator->prev('«', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
				<?php echo $this->Paginator->numbers(array('tag' => 'li', 'separator' => '', 'currentTag' => 'a', 'currentClass' => 'active')); ?>
				<?php echo $this->Paginator->next('»', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
			</ul>
		</div>
		<div id="documents"></div>
	</div>
</div>