<?php
// $this->Html->script(array(
// 	'/' . strtolower($this->plugin) . '/js/jquery-1.9.1.min',
// 	'/' . strtolower($this->plugin) . '/js/jquery_ui.min',
// 	'/' . strtolower($this->plugin) . '/js/tiny_mce/tiny_mce',
// 	'/' . strtolower($this->plugin) . '/js/admin_doc'
//  	),array('inline'=>false));

// $this->Html->css(array(
// 	'/' . strtolower($this->plugin) . '/css/jquery_ui.min'
// 	),null,array('inline'=>false))
?>
<div class="documents form">
	<?php echo $this->Form->create('Document'); ?>
	<fieldset>
		<legend><?php echo __('Add Document'); ?></legend>
		<?php
		echo $this->Form->input('document_type_id', array('type' => 'hidden', 'value' => $parent_entityid));
		echo $this->Form->input('parent_entityid', array('type' => 'hidden', 'value' => $parent_entityid));
		if (Configure::read('language_multiple')) {
			echo $this->Form->input('language_id', array('options' => $languages));
		} else {
			echo $this->Form->input('language_id', array('type' => 'hidden', 'value' => Configure::read('language_default')));
		}
		echo $this->Form->input('title', array());
		echo $this->Form->input('excerpt', array('type' => 'textarea'));
		echo $this->Form->input('content', array('class' => 'tinymce-editor'));
		?>
	</fieldset>
	<div class="btn-group">
		<?php echo $this->Js->link(__('Cancel'), '/documents/Documents/index/' . $document_type_id . '/' . $parent_entityid, array('class' => 'btn', 'escape' => FALSE, 'update' => "#" . $documentType['DocumentType']['alias'], 'value' => 'cancel')); ?>
		<?php echo $this->Js->submit(__('Add'), array('url' => '/documents/Documents/add/' . $document_type_id . '/' . $parent_entityid, 'class' => 'btn btn-primary', 'escape' => FALSE, 'update' => "#".$documentType['DocumentType']['alias'], 'div' => FALSE)); ?>
	</div>
	
	<?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">
//	var resources_tiny = "<?php // echo str_replace('/', '\/', $this->Html->url(array('plugin' => 'resources', 'controller' => 'resources', 'action' => 'tiny_upload', 'admin' => true)));	  ?>";
	var resources_tiny = "<?php echo str_replace('/', '\/', $this->Html->url(array('controller' => 'documents', 'action' => 'upload_file', 'admin' => true))) ?>";
</script>
