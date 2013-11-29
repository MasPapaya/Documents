<?php echo $this->Html->script(array('tiny_mce/tiny_mce_popup','tiny_mce/plugins/jbimages/js/dialog'));?>
<?php // echo $this->Html->css(array('tiny_mce/plugins/jbimages/tiny_mce_popup'));?>

<?php if(isset($result)):?>
	<script language="javascript" type="text/javascript">
			window.parent.window.jbImagesDialog.uploadFinish({
					filename:'<?php echo $this->Html->webroot('files/tiny/'.$result['file']); ?>'
			});
	</script>
<?php else:?>
	<?php echo $this->Form->create('Resource', array('type' => 'file')); ?>			   
	<?php echo $this->Form->input('filename', array('label'=>__('Selected File'),'type' => 'file', 'required'));?>
	<br />
	<?php echo $this->Form->end(array('label' => __('Add Resource', true), 'class' => 'btn btn-primary btn-large submit-file')); ?>
<?php endif;?>