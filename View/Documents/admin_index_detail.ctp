<div id="<?php echo $document_type['DocumentType']['alias'] ?>" class="">
	<h2><?php echo __('Documents'); ?> - <?php echo $document_type['DocumentType']['name']; ?></h2>
	<table class="table table-striped table-bordered table-condensed">
		<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>			
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<?php
			if (Configure::read('language_multiple', true)) {
				echo '<th>' . $this->Paginator->sort('language_id') . '</th>';
			}
			?>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('published'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
		<?php foreach ($documents as $key => $document): ?>
			<tr>
				<td><?php echo h($document['Document']['id']); ?>&nbsp;</td>
				<td><?php echo h($document['Document']['title']); ?>&nbsp;</td>
				<?php
				if (Configure::read('language_multiple', true)) {
					echo '<td>' . h($document['Language']['name']) . '&nbsp;</td>';
				}
				?>
				<td><?php echo h($document['Document']['created']); ?>&nbsp;</td>
				<td><?php
					if ($document['Document']['published'] == Configure::read('zero_datetime')) {
						echo __('No');
					} else {
						echo $document['Document']['published'];
					}
					?>
				</td>
				<td class="actions">						
					<div class="btn-group">
						<?php echo $this->Ajs->button('icon-pencil', array('action' => 'admin_edit', $document['Document']['id']), '', "#" . $document_type['DocumentType']['alias']) ?>
						<?php echo $this->Ajs->button('icon-eye-open', array('action' => 'admin_view', $document['Document']['id']), '', "#" . $document_type['DocumentType']['alias']) ?>
						<?php
						if (Configure::read('is_resources')) {
							echo $this->Ajs->button('icon-film', array('plugin' => 'resources', 'controller' => 'Resources', 'action' => 'index', 'admin' => false, 'document', $document['Document']['id']), '', '#document');
						}
						?>
						<?php
						echo $this->Ajs->delete(
								'<i class="icon-trash icon-white"></i>', array('action' => 'admin_delete', $document['Document']['id']), array('escape' => false, 'class' => 'btn btn-danger'), array('update' => "#" . $document_type['DocumentType']['alias'], 'confirm' => __('Are you sure you want to delete %s?', $document['Document']['title']))
						);
						?>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	<p>
		<?php
		$this->Paginator->options(array(
			'update' => "#" . $document_type['DocumentType']['alias'],
			'evalScripts' => true,
		));
		echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));
		?>
	</p>
	<div class="pagination pagination-centered">
		<?php echo $this->Ajs->numbers(); ?>
	</div>
	<div id="document"></div>
</div>

