<div  id="<?php echo $documentType['DocumentType']['alias']; ?>">
	<div>
		<?php if (empty($disable_button)): ?>
			<?php echo $this->Js->link('<i class="icon-plus-sign icon-white"></i>&nbsp;' . __('New Document'), array('action' => 'admin_add', $documentType['DocumentType']['id'], $parent_entityid), array('escape' => FALSE, 'class' => 'btn btn-primary', 'update' => "#" . $documentType['DocumentType']['alias'])); ?>
		<?php endif; ?>
	</div>

	<div id="info_documents" class="title_form">
		<h2><?php echo __('Documents'); ?> - <?php echo __($documentType['DocumentType']['name']); ?></h2>
		<?php
		echo $this->Form->create('Document', array('action' => 'search'), array('method' => 'POST'));
		echo '<div class="input-append">';
		echo $this->Form->input('search', array('label' => false, 'div' => false, 'class' => 'search input-large', 'placeholder' => __('Search', true)));
		echo $this->Js->submit(__('Search'), array('url' => '/admin/documents/Documents/search/' . $document_type_id . '/' . $parent_entityid, 'update' => '#documents', 'div' => false, 'escape' => false, 'class' => 'btn'));
		//echo $this->Form->button('<i class="icon icon-search"></i>', array( 'type'=>'submit', 'label' => false, 'div' => false, 'class' => 'btn'));
		echo '</div>';
		echo $this->Form->end();
		?>
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
					echo $document['Document']['published'];
				}
					?>
					</td>
					<td class="actions">						
						<div class="btn-group">
							<?php if (CakePlugin::loaded('Seo')): ?>
								<?php echo $this->Seo->BtnHandler($document['Document']['id'],$document['Language']['id'], '#document'); ?>
							<?php endif; ?>
							<?php
							if ($document['Document']['published'] == Configure::read('zero_datetime')) {
								echo $this->Ajs->button('icon-thumbs-up', array('action' => 'admin_published', $document['Document']['id'], $document_type_id, $parent_entityid), '', "#document-" . $document['Document']['id']);
							} else {
								echo $this->Ajs->button('icon-thumbs-down', array('action' => 'admin_published', $document['Document']['id'], $document_type_id, $parent_entityid), '', "#document-" . $document['Document']['id']);
							}
							?>
							<?php echo $this->Ajs->button('icon-pencil', array('action' => 'admin_edit', $document['Document']['id'], $document_type_id, $parent_entityid), '', "#" . $documentType['DocumentType']['alias']) ?>
							<?php echo $this->Ajs->button('icon-eye-open', array('action' => 'admin_view', $document['Document']['id'], $document_type_id, $parent_entityid), '', "#" . $documentType['DocumentType']['alias']) ?>

							<?php
							if (Configure::read('is_resources')) {
								echo $this->Frame->link('icon-film', 'frame', $document['DocumentType']['Entity']['alias'], $document['Document']['id']);
							}
							?>
							<?php
							echo $this->Ajs->delete(
								'<i class="icon-trash icon-white"></i>', array('action' => 'admin_delete', $document['Document']['id'], $document_type_id, $parent_entityid), array('escape' => false, 'class' => 'btn btn-danger'), array('update' => "#" . $documentType['DocumentType']['alias'], 'confirm' => __('Are you sure you want to delete %s?', $document['Document']['title']))
							);
							?>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
		<?php
		if (CakePlugin::loaded('Resources')) {

			echo $this->Frame->modal('frame', array('title' => __('Documents')));
		}
		?>
		<div class="pagination pagination-centered">
			<p><?php
		$this->Paginator->options(array(
			'update' => "#" . $documentType['DocumentType']['alias'],
			'evalScripts' => true,
		));
		?></p>
			<ul><?php
				echo $this->Paginator->prev('«', array('tag' => 'li'), null, array('class' => 'prev disabled ', 'tag' => 'li', 'disabledTag' => 'a'));
				echo $this->Paginator->numbers(array('tag' => 'li', 'currentTag' => 'a', 'separator' => '', 'currentClass' => 'active'));
				echo $this->Paginator->next('»', array('tag' => 'li'), null, array('class' => 'next disabled', 'tag' => 'li', 'disabledTag' => 'a'));
		?></ul>
		</div>
		<div id="document"></div>		
	</div>
</div>