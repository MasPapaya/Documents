<div class="cru">
	<div class="btn-options">
		<?php echo $this->Ajs->link('<i class="icon-list icon-white"></i>&nbsp;' . __('Back to List'), array('action' => 'admin_index', $document['DocumentType']['id'], $document['Document']['parent_entityid']), 'btn btn-primary', "#" . $document['DocumentType']['alias']); ?>

	</div>

	<div class="documents view">
		<h2><?php echo __('Document'); ?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($document['Document']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Document Type'); ?></dt>
			<dd>
				<?php echo h($document['DocumentType']['name']); ?>
				&nbsp;
			</dd>			
			<dt><?php echo __('Title'); ?></dt>
			<dd>
				<?php echo h($document['Document']['title']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Excerpt'); ?></dt>
			<dd>
				<?php echo h($document['Document']['excerpt']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Content'); ?></dt>
			<dd>
				<?php echo $document['Document']['content']; ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Created'); ?></dt>
			<dd>
				<?php echo h($document['Document']['created']); ?>
				&nbsp;
			</dd>						
		</dl>
	</div>
</div>
