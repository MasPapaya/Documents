<script type="text/javascript">
	//var baseurl = '<?php echo $this->html->url('/documents/'); ?>';
</script>
<div class="row-fluid">
	<div class="span12">
		<h2><?php echo __('CMS Groups'); ?></h2>
		<table class=" table table-condensed table-bordered table-striped">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('alias'); ?></th>
					<th><?php echo $this->Paginator->sort('is_multiple'); ?></th>
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
						<td class="actions">
							<div class="btn-group">
								<?php echo $this->Ajs->link('<i class="glyphicon glyphicon-list"></i>', array('controller' => 'Documents', 'action' => 'index', $documentType['DocumentType']['id'], 0), 'btn btn-default', '#documents') ?>
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
			?>
		</p>
		<div class="pagination-centered">
			<ul class="pagination">
				<?php echo $this->Paginator->prev('«', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
				<?php echo $this->Paginator->numbers(array('tag' => 'li', 'separator' => '', 'currentTag' => 'a', 'currentClass' => 'active')); ?>
				<?php echo $this->Paginator->next('»', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
			</ul>
		</div>
		<div id="documents"></div>
	</div>
</div>