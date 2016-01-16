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

$associations += ['BelongsTo' => [], 'HasOne' => [], 'HasMany' => [], 'BelongsToMany' => []];
$immediateAssociations = $associations['BelongsTo'] + $associations['HasOne'];
$associationFields = collection($fields)
    ->map(function($field) use ($immediateAssociations) {
        foreach ($immediateAssociations as $alias => $details) {
            if ($field === $details['foreignKey']) {
                return [$field => $details];
            }
        }
    })
    ->filter()
    ->reduce(function($fields, $value) {
        return $fields + $value;
    }, []);

$groupedFields = collection($fields)
    ->filter(function($field) use ($schema) {
        return $schema->columnType($field) !== 'binary';
    })
    ->groupBy(function($field) use ($schema, $associationFields) {
        $type = $schema->columnType($field);
        if (isset($associationFields[$field])) {
            return 'string';
        }
        if (in_array($type, ['integer', 'float', 'decimal', 'biginteger'])) {
            return 'number';
        }
        if (in_array($type, ['date', 'time', 'datetime', 'timestamp'])) {
            return 'date';
        }
        return in_array($type, ['text', 'boolean']) ? $type : 'string';
    })
    ->toArray();

$groupedFields += ['number' => [], 'string' => [], 'boolean' => [], 'date' => [], 'text' => []];
$pk = "\$$singularVar->{$primaryKey[0]}";
%>




<div class="page-content-wrap">                
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default btn-gradient dropdown-toggle" data-toggle="dropdown" data-container="body" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <a href='<?= $this->Url->build([
                                    "controller" => "<%= $pluralHumanName %>",
                                    "action" => "add"
                                ]);?>'>
                                    <i class="glyphicon glyphicon-new-window"></i>
                                    <?= __("Adicionar") ?>
                                </a>
                            </li>
                            <li>
                                <a href='<?= $this->Url->build([
                                    "controller" => "<%= $pluralHumanName %>",
                                    "action" => "index"
                                ]);?>'>
                                    <i class="fa fa-list"></i>
                                    <?= __("Listar") ?>
                                </a>
                            </li>
                            <li>
                                <a href='<?= $this->Url->build([
                                    "controller" => "<%= $pluralHumanName %>",
                                    "action" => "edit",
                                    <%= $pk %>
                                ]);?>'>
                                    <i class="fa fa-pencil-square-o icone-editar"></i>
                                    <?= __("Editar") ?>
                                </a>
                            </li>
                            <li>
                                <?= $this->Form->postLink("<i class='fa fa-trash-o icone-excluir'></i>" . __("Deletar"),
                                    ['action' => 'delete', <%= $pk %>],
                                    ['escape' => false, 'confirm' => __('Tem certeza de que deseja excluir este cadastro?')]);
                                ?>
                            </li>


                            
                    <%
                        $done = [];
                        foreach ($associations as $type => $data) {
                            foreach ($data as $alias => $details) {
                                if ($details['controller'] !== $this->name && !in_array($details['controller'], $done)) {
                    %>
                             <li>
                                <a href='<?= $this->Url->build([
                                    "controller" => "<%= $details['controller'] %>",
                                    "action" => "index"
                                ]);?>'>
                                    <i class="fa fa-eye"></i>
                                    <?= __("Listar <%= $this->_pluralHumanName($alias) %>") ?>
                                </a>
                            </li>
                            <li>
                                <a href='<?= $this->Url->build([
                                    "controller" => "<%= $details['controller'] %>",
                                    "action" => "add"
                                ]);?>'>
                                    <i class="fa fa-eye"></i>
                                    <?= __("Adicionar <%= Inflector::humanize(Inflector::singularize(Inflector::underscore($alias))) %>") ?>
                                </a>
                            </li>
                    <%
                                    $done[] = $details['controller'];
                                }
                            }
                        }
                    %>
                        </ul>
                    </div>
                    <h3 class="panel-title"><%= $singularVar %>&nbsp;&nbsp;&nbsp;&nbsp; </h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group border-bottom">





<% if ($groupedFields['string']) : %>
        <li class="list-group-item">
<% foreach ($groupedFields['string'] as $field) : %>
<% if (isset($associationFields[$field])) :
            $details = $associationFields[$field];
%>
            
                    <strong><?= __('<%= Inflector::humanize($details['property']) %>') ?>&nbsp;:&nbsp;&nbsp;&nbsp;</strong>
            <p><?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?></p>
            
<% else : %>
           
                    <strong><?= __('<%= Inflector::humanize($field) %>') ?>&nbsp;:&nbsp;&nbsp;&nbsp;</strong>
            <?= h($<%= $singularVar %>-><%= $field %>) ?>
           
<% endif; %>
<% endforeach; %>
         </li>
<% endif; %>



<% if ($groupedFields['number']) : %>
        <li class="list-group-item">
<% foreach ($groupedFields['number'] as $field) : %>
            
                    <strong><?= __('<%= Inflector::humanize($field) %>') ?>&nbsp;:&nbsp;&nbsp;&nbsp;</strong>
                <?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?>
            
<% endforeach; %>
        </li>
<% endif; %>




<% if ($groupedFields['date']) : %>
        <li class="list-group-item">
<% foreach ($groupedFields['date'] as $field) : %>
                
                    <strong><%= "<%= __('" . Inflector::humanize($field) . "') %>" %>&nbsp;:&nbsp;&nbsp;&nbsp;</strong>
                    <?= h($<%= $singularVar %>-><%= $field %>) ?>
           
                
           
<% endforeach; %>
        </li>
<% endif; %>


<% if ($groupedFields['boolean']) : %>
        <li class="list-group-item">
<% foreach ($groupedFields['boolean'] as $field) : %>
                
                    <strong><?= __('<%= Inflector::humanize($field) %>') ?>&nbsp;:&nbsp;&nbsp;&nbsp;</strong>
                    <?= $<%= $singularVar %>-><%= $field %> ? __('Sim') : __('Não'); ?>
                    
              
<% endforeach; %>
          </li>
<% endif; %>




<% if ($groupedFields['text']) : %>
<% foreach ($groupedFields['text'] as $field) : %>
                <li class="list-group-item">
                    <strong><?= __('<%= Inflector::humanize($field) %>') ?>&nbsp;:&nbsp;&nbsp;&nbsp;</strong>
                    <?= $this->Text->autoParagraph(h($<%= $singularVar %>-><%= $field %>)) ?>

                </li>
<% endforeach; %>
<% endif; %>
</div>




<%
$relations = $associations['HasMany'] + $associations['BelongsToMany'];
foreach ($relations as $alias => $details):
    $otherSingularVar = Inflector::variable($alias);
    $otherPluralHumanName = Inflector::humanize(Inflector::underscore($details['controller']));
    %>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related <%= $otherPluralHumanName %>') ?></h4>
    <?php if (!empty($<%= $singularVar %>-><%= $details['property'] %>)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
<% foreach ($details['fields'] as $field): %>
            <th><?= __('<%= Inflector::humanize($field) %>') ?></th>
<% endforeach; %>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($<%= $singularVar %>-><%= $details['property'] %> as $<%= $otherSingularVar %>): ?>
        <tr>
            <%- foreach ($details['fields'] as $field): %>
            <td><?= h($<%= $otherSingularVar %>-><%= $field %>) ?></td>
            <%- endforeach; %>

            <%- $otherPk = "\${$otherSingularVar}->{$details['primaryKey'][0]}"; %>
            <td>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default btn-gradient dropdown-toggle" data-toggle="dropdown" data-container="body" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                            <a href='<?= $this->Url->build([
                                "controller" => "<%= $details['controller'] %>",
                                "action" => "view",
                                <%= $otherPk %>
                            ]);?>'>
                                <i class="fa fa-eye"></i>
                                <?= __("View") ?>
                            </a>
                        </li>
                        <li>
                            <a href='<?= $this->Url->build([
                                "controller" => "<%= $details['controller'] %>",
                                "action" => "edit",
                                <%= $otherPk %>
                            ]);?>'>
                                <i class="fa fa-pencil-square-o icone-editar"></i>
                                <?= __("Edit") ?>
                            </a>
                        </li>
                        <li>
                            <?= $this->Form->postLink("<i class='fa fa-trash-o icone-excluir'></i>" . __("Delete"),
                                ['controller' => '<%= $details['controller'] %>', 'action' => 'delete', <%= $otherPk %>],
                                ['escape' => false, 'confirm' => __('Tem certeza de que deseja excluir este cadastro?')]);
                            ?>
                        </li>
                    </ul>
                </div>
            </td>

        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<% endforeach; %>
 </ul>

                </div>
            </div>
        </div>
    </div>
</div>