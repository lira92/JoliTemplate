<%
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Utility\Inflector;

$fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return $schema->columnType($field) !== 'binary';
    });
%>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <%= "<?php echo \$this->Session->flash(); ?>\n"; %>
            <?= $this->Form->create($<%= $singularVar %>, array('type' => 'file', 'class' => 'form-horizontal')) ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><%="<?php echo __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName; %></h3>
                    <ul class="panel-controls">
                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <p>Nessa área serão cadastrados os <%= $pluralVar %> da sua empresa.</p>
                </div>
                <div class="panel-body">
<%
        foreach ($fields as $field) {
            if (in_array($field, $primaryKey)) {
                continue;
            }
            if (isset($keyFields[$field])) {
                $fieldData = $schema->column($field);
                if (!empty($fieldData['null'])) {
%>

            <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label"><?php echo $field;?></label>
                <div class="col-md-6 col-xs-12">                                            
                    <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span> 
        <?= echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>,'class' => 'form-control', 'label' => false, 'empty' => true]); ?>
                    </div>                                            
                    <span class="help-block">Campo de texto</span>
                </div>
            </div>
<%
                } else {
%>
            <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label"><?php echo $field;?></label>
                <div class="col-md-6 col-xs-12">                                            
                    <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span> 
        <?= echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>,'class' => 'form-control', 'label' => false, 'empty' => true]); ?>
                    </div>                                            
                    <span class="help-block">Campo de texto</span>
                </div>
            </div>
<%
                }
                continue;
            }
            if (!in_array($field, ['created', 'modified', 'updated'])) {
                $fieldData = $schema->column($field);
                if (($fieldData['type'] === 'date') && (!empty($fieldData['null']))) {
%>
            <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label"><?php echo $field;?></label>
                <div class="col-md-6 col-xs-12">                                            
                    <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span> 
        <?= echo $this->Form->input('<%= $field %>', ['class' => 'form-control', 'label' => false, 'empty' => true, 'default' => '']); ?>
                    </div>                                            
                    <span class="help-block">Campo de texto</span>
                </div>
            </div>
<%
                } else {
%>
            <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label"><?php echo $field;?></label>
                <div class="col-md-6 col-xs-12">                                            
                    <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span> 
        <?= echo $this->Form->input('<%= $field %>', ['class' => 'form-control', 'label' => false]); ?>
                    </div>                                            
                    <span class="help-block">Campo de texto</span>
                </div>
            </div>
<%
                }
            }
        }
        if (!empty($associations['BelongsToMany'])) {
            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
%>
            <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label"><?php echo $assocName;?></label>
                <div class="col-md-6 col-xs-12">                                            
                    <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span> 
        <?= $this->Form->input('<%= $assocData['property'] %>._ids', array(['options' => $<%= $assocData['variable'] %>, 'class' => 'form-control', 'label' => false)); ?>
                    </div>                                            
                    <span class="help-block">Campo de texto</span>
                </div>
            </div>
<%
            }
        }
%>
        ?>
    </div>
    <div class="panel-footer">
        <%= "<?php echo \$this->Form->end(array('label' => 'Enviar', 'class' => 'btn btn-default')); ?>\n" %>
    </div>
</div>
