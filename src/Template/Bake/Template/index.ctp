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
        return !in_array($schema->columnType($field), ['binary', 'text']);
    })
    ->take(7);
%>
<div class="page-title">                    
    <h2><span class="fa fa-arrow-circle-o-left"></span> Lista de <%= $pluralHumanName %></h2>
</div>
<div class="page-content-wrap">                
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">                                
                    <h3 class="panel-title"><%= $pluralHumanName %></h3>   
                    <ul class="panel-controls">
                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                    </ul>                                
                </div>
                <div class="panel-body" id="index">
                    <table class="table datatable">
                        <thead>
                        <tr>
                           <% foreach ($fields as $field): %>
                                <th><?php echo "<%= $field %>"; ?></th>
                            <% endforeach; %>
                                <th class="actions"><?php echo "<?= __('Actions') ?>"; ?></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($<%= $pluralVar %> as $<%= $singularVar %>): ?>
                            <tr>
                            <%    foreach ($fields as $field) {
                                    $isKey = false;
                                    if (!empty($associations['belongsTo'])) {
                                        foreach ($associations['belongsTo'] as $alias => $details) {
                                            if ($field === $details['foreignKey']) {
                                                $isKey = true;
                            %>
                                                <td><?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?></td>
                                                
                            <%
                                                break;
                                            }
                                        }
                                    }
                                      if ($isKey !== true) {
                                            if (!in_array($schema->columnType($field), ['integer', 'biginteger', 'decimal', 'float'])) {
                            %>
                                            <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
                            <%
                                            } else {
                            %>
                                            <td><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></td>
                            <%
                                            }
                                        }
                                }
                                $pk = '$' . $singularVar . '->' . $primaryKey[0];
                             %>
                             
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-default btn-gradient dropdown-toggle" data-toggle="dropdown" data-container="body" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-bars"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href='<?= $this->Url->build([
                                                    "controller" => "<%= $pluralHumanName %>",
                                                    "action" => "view",
                                                    <%= $pk %>
                                                ]);?>'>
                                                    <i class="fa fa-eye"></i>
                                                    <?= __("View") ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href='<?= $this->Url->build([
                                                    "controller" => "<%= $pluralHumanName %>",
                                                    "action" => "edit",
                                                    <%= $pk %>
                                                ]);?>'>
                                                    <i class="fa fa-pencil-square-o icone-editar"></i>
                                                    <?= __("Edit") ?>
                                                </a>
                                            </li>
                                            <li>
                                                <?= $this->Form->postLink("<i class='fa fa-trash-o icone-excluir'></i>" . __("Delete"),
                                                    ['action' => 'delete', <%= $pk %>],
                                                    ['escape' => false, 'confirm' => __('Tem certeza de que deseja excluir este cadastro?')]);
                                                ?>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <?php endforeach; ?>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
