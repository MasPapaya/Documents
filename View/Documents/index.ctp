<div  id="<?php echo $documentType['DocumentType']['alias']; ?>">
	<div>
		<ul class="nav nav-list">	
			<li><?php echo $this->Ajs->link('<i class="icon-plus-sign"></i>&nbsp;' . __('New Document'), array('action' => 'add', $documentType['DocumentType']['id'], $parent_entityid), '', "#" . $documentType['DocumentType']['alias']); ?></li>
		</ul>
	</div>
	<div id="info_documents">
		<h2><?php echo __('Documents'); ?> - <?php echo $documentType['DocumentType']['name']; ?></h2>

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
				<tr id="document-<?php echo $document['Document']['id']; ?>">
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
							echo $document['Document']['created'];
						}
						?>
					</td>
					<td class="actions">						
						<div class="btn-group">
							<?php
							if ($document['Document']['published'] == Configure::read('zero_datetime')) {
								echo $this->Ajs->button('icon-thumbs-up', array('controller'=>'Documents','action' => 'published', $document['Document']['id'], $document_type_id, $parent_entityid,'admin'=>false), '', "#document-" . $document['Document']['id']);
							} else {
								echo $this->Ajs->button('icon-thumbs-down', array('controller'=>'Documents','action' => 'published', $document['Document']['id'], $document_type_id, $parent_entityid,'admin'=>false), '', "#document-" . $document['Document']['id']);
							}
							?>
							<?php echo $this->Ajs->button('icon-pencil', array('action' => 'edit', $document['Document']['id'], $document_type_id, $parent_entityid), '', "#" . $documentType['DocumentType']['alias']) ?>
							<?php // echo $this->Ajs->button('icon-eye-open', array('action' => 'view', $document['Document']['id'], $document_type_id, $parent_entityid), '', "#" . $documentType['DocumentType']['alias']) ?>

							<?php
							if (Configure::read('is_resources')) {
								echo $this->Ajs->button('icon-film', array('plugin' => 'resources', 'controller' => 'Resources', 'action' => 'index', 'admin' => false, 'document', $document['Document']['id']), '', '#document');
							}
							?>
							<?php
							echo $this->Ajs->delete(
									'<i class="icon-trash icon-white"></i>', array('action' => 'delete', $document['Document']['id'], $document_type_id, $parent_entityid), array('escape' => false, 'class' => 'btn btn-danger'), array('update' => "#" . $documentType['DocumentType']['alias'], 'confirm' => __('Are you sure you want to delete %s?', $document['Document']['title']))
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
				'update' => "#" . $documentType['DocumentType']['alias'],
				'evalScripts' => true,
			));
//			echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));
			?>
		</p>
		<div class="pagination pagination-centered">
			<?php echo $this->Ajs->numbers(); ?>
		</div>
		<div id="document"></div>
	</div>
</div>