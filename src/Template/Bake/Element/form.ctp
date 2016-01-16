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
            <?= $this->Form->create($<%= $singularVar %>, array('type' => 'file', 'class' => 'form-horizontal')) ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= __('<%= Inflector::humanize($action) %> <%= $singularHumanName %>') ?></h3>
                    <ul class="panel-controls">
                    <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <p>Nessa área será <?= __('<%= Inflector::humanize($action) %> o(a) <%= $singularHumanName %>')?> da sua empresa.</p>
                </div>
                <div class="panel-body">
        <?php
<%
        foreach ($fields as $field) {
            if (in_array($field, $primaryKey)) {
                continue;
            }
            if (isset($keyFields[$field])) {
                $fieldData = $schema->column($field);
                if (!empty($fieldData['null'])) {
%>
   ?>        <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label">1<%= $field %></label>
                <div class="col-md-6 col-xs-12">                                            
                    <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span> 
                        <?php echo $this->Form->input('<%= $field %>', ['class' => 'form-control', 'label' => false, 'options' => $<%= $keyFields[$field] %>, 'empty' => true]); ?>
                    </div>                                            
                    <span class="help-block">Campo tipo data</span>
                </div>
            </div>
<?php
<%
                } else {
%>
?>          <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label">2 <%= $field %></label>
                <div class="col-md-6 col-xs-12">                                            
                    <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span> 
                        <?php echo $this->Form->input('<%= $field %>', ['class' => 'form-control', 'label' => false, 'options' => $<%= $keyFields[$field] %>]); ?>
                    </div>                                            
                    <span class="help-block">Campo de texto</span>
                </div>
            </div>
<?php
<%
                }
                continue;
            }
            if (!in_array($field, ['created', 'modified', 'updated'])) {
                $fieldData = $schema->column($field);
                if (($fieldData['type'] === 'date') && (!empty($fieldData['null']))) {
%>
?>        <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label">3<%= $field %></label>
                <div class="col-md-6 col-xs-12">                                            
                    <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span> 
                        <?php echo $this->Form->input('<%= $field %>', ['class' => 'form-control', 'label' => false, 'empty' => true]); ?>
                    </div>                                            
                    <span class="help-block">Campo de texto</span>
                </div>
            </div>
<?php
            
<%
                } else {
%>
?>        <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label">4<%= $field %></label>
                <div class="col-md-6 col-xs-12">                                            
                    <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span> 
                        <?php echo $this->Form->input('<%= $field %>', ['class' => 'form-control', 'label' => false]); ?>
                    </div>                                            
                    <span class="help-block">Campo de texto</span>
                </div>
            </div>
<?php
            
<%
                }
            }
        }
        if (!empty($associations['BelongsToMany'])) {
            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
%>
            ?>
            <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label">5<%= $field %></label>
                <div class="col-md-6 col-xs-12">                                            
                    <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span> 
                        <?php echo $this->Form->input('<%= $assocData['property'] %>._ids', ['class' => 'form-control', 'label' => false, 'options' => $<%= $assocData['variable'] %>]); ?>
                    </div>                                            
                    <span class="help-block">Campo de texto</span>
                </div>
            </div>
<?php


<%
            }
        }
%>
        ?>
 


                </div>
                <div class="panel-footer">
                    <?= $this->Form->button('Enviar', ['class' => 'btn btn-default'])?>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>                    
</div>
    

