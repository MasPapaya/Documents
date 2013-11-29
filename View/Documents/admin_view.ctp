<div class="span12">
	<div>
		<ul class="nav nav-list">
			<li><?php echo $this->Ajs->link('<i class="icon-list"></i>&nbsp;' . __('List Documents'), array('action' => 'admin_index', $document['DocumentType']['id'], $document['Document']['parent_entityid']), '', "#".$document['DocumentType']['alias']); ?></li>
		</ul>
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
