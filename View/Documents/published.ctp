<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
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
			echo $this->Ajs->button('icon-thumbs-up', array('action' => 'published', $document['Document']['id'], $document_type_id, $parent_entityid), '', "#document-" . $document['Document']['id']);
		} else {
			echo $this->Ajs->button('icon-thumbs-down', array('action' => 'published', $document['Document']['id'], $document_type_id, $parent_entityid), '', "#document-" . $document['Document']['id']);
		}
		?>
		<?php echo $this->Ajs->button('icon-pencil', array('action' => 'edit', $document['Document']['id'], $document_type_id, $parent_entityid), '', "#" . $documentType['DocumentType']['alias']) ?>
		<?php echo $this->Ajs->button('icon-eye-open', array('action' => 'view', $document['Document']['id'], $document_type_id, $parent_entityid), '', "#" . $documentType['DocumentType']['alias']) ?>

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