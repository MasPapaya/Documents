<div class="documents form">
	<?php echo $this->Form->create('Document'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Document'); ?></legend>
		<?php
		echo $this->Form->input('id');

		if (isset($parent_entity_id)) {
			echo $this->Form->input('parent_entityid', array('type' => 'hidden', 'value' => $parent_entity_id));
		} else {
			echo $this->Form->input('parent_entityid', array('type' => 'hidden'));
		}

		if (Configure::read('language_multiple')) {
			echo $this->Form->input('language_id');
		} else {
			echo $this->Form->input('language_id', array('type' => 'hidden', 'value' => Configure::read('language_default')));
		}

		echo $this->Form->input('title', array());
		echo $this->Form->input('excerpt', array('type' => 'textarea'));
		echo $this->Form->input('content', array('class' => 'tinymce-editor'));
//		echo $this->Form->input('published', array('class' => 'datetime', 'type' => 'text'));
		?>
	</fieldset>
	<div class="btn-group">
		<?php echo $this->Js->link(__('Cancel'), '/documents/Documents/index/' . $document['Document']['document_type_id'] . '/' . $document['Document']['parent_entityid'], array('class' => 'btn', 'escape' => FALSE, 'update' => "#" . $document['DocumentType']['alias'], 'value' => 'cancel')); ?>
		<?php echo $this->Js->submit(__('Edit'), array('url' => '/documents/documents/edit/' . $document['Document']['id'] . '/' . $document['Document']['document_type_id'] . '/' . $document['Document']['parent_entityid'], 'class' => 'btn btn-primary', 'escape' => FALSE, 'update' => "#" . $document['DocumentType']['alias'], 'div' => FALSE)); ?>
	</div>
	<?php echo $this->Form->end(); ?>
</div>

<script type="text/javascript">
//	var resources_tiny = "<?php // echo str_replace('/', '\/', $this->Html->url(array('controller' => 'resources', 'action' => 'tiny_upload', 'admin' => true)));		  ?>";
	var resources_tiny = "<?php echo str_replace('/', '\/', $this->Html->url(array('controller' => 'documents', 'action' => 'upload_file', 'admin' => true))) ?>";
</script>


