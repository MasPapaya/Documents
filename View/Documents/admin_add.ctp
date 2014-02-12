<?php echo $this->Html->css(array('Documents.chosen')); ?>
<?php echo $this->Html->script(array('Documents.chosen.jquery')); ?>
<?php echo $this->Html->script(array('Documents.documents_admin')); ?>


<div class="documents form">
	<?php echo $this->Form->create('Document'); ?>
	<fieldset>
		<legend><?php echo __('Add Document'); ?></legend>
		<div class="col-md-3">
			<?php
			if (!empty($users)) {
				echo $this->Form->input('user_id', array('type' => 'text', 'data-provide' => 'typeahead', 'placeholder' => 'search user', 'required' => 'required', 'autocomplete' => 'off', 'class' => 'input_autcomplet'));
			}
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
		</div>
    </fieldset>
    <div class="btn-group">
		<?php echo $this->Js->link(__('Cancel'), '/admin/documents/Documents/index/' . $document_type_id . '/' . $parent_entityid, array('class' => 'btn btn-default', 'escape' => FALSE, 'update' => "#" . $documentType['DocumentType']['alias'], 'value' => 'cancel')); ?>
		<?php echo $this->Js->submit(__('Add'), array('url' => '/admin/documents/Documents/add/' . $document_type_id . '/' . $parent_entityid, 'class' => 'btn btn-primary', 'escape' => FALSE, 'update' => "#" . $documentType['DocumentType']['alias'], 'div' => FALSE)); ?>
    </div>

	<?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">	
	$(".select_chosen").chosen({
		max_selected_options: 2,
		no_results_text: "No se encontro"

	});
	var baseurl = '<?php echo $this->Html->url('/'); ?>';
	documents_init();	
	var resources_tiny = "<?php echo str_replace('/', '\/', $this->Html->url(array('plugin' => 'resources', 'controller' => 'Media', 'action' => 'tiny_upload', 'admin' => true))); ?>";

</script>
