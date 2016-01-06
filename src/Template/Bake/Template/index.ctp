<div class="page-title">                    
    <h2><span class="fa fa-arrow-circle-o-left"></span> Lista de <?php echo $pluralVar; ?></h2>
</div>
<div class="page-content-wrap">                
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">                                
                    <h3 class="panel-title"><?php echo $pluralVar; ?></h3>   
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
                            <?php foreach ($fields as $field): ?>
                                <th><?php echo "<?php echo __('{$field}'); ?>"; ?></th>
                            <?php endforeach; ?>
                                <th class="actions"><?php echo "<?php echo __('Actions'); ?>"; ?></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            echo "<?php foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
                            echo "\t<tr>\n";
                                foreach ($fields as $field) {
                                    $isKey = false;
                                    if (!empty($associations['belongsTo'])) {
                                        foreach ($associations['belongsTo'] as $alias => $details) {
                                            if ($field === $details['foreignKey']) {
                                                $isKey = true;
                                                echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey'][0]}'])); ?>\n\t\t</td>\n";
                                                break;
                                            }
                                        }
                                    }
                                    if ($isKey !== true) {
                                        echo "\t\t<td><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
                                    }
                                }

                                echo "\t\t<td>\n";
                                    echo "\t\t\t<span class='icon'>\n\t\t\t\t<?php echo \$this->Html->image('admin/view.png', array('alt' => 'Visualizar','url' => array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey[0]}']))); ?>\n\t\t\t</span>\n";
                                    echo "\t\t\t<span class='icon'>\n\t\t\t\t<?php echo \$this->Html->image('admin/edit.png', array('alt' => 'Editar','url' => array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey[0]}']))); ?>\n\t\t\t</span>\n";
                                    echo "\t\t\t<span class='icon'>\n\t\t\t\t<?php echo \$this->Form->postLink(\$this->Html->image('admin/delete.png', array('alt' => 'Deletar')), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey[0]}']), array('escape' => false, 'confirm' => __('Tem certeza de que deseja excluir este cadastro #id: %s?', \${$singularVar}['{$modelClass}']['{$primaryKey[0]}']))); ?>\n\t\t\t</span>\n";
                                echo "\t\t</td>\n";
                            echo "\t</tr>\n";

                            echo "<?php endforeach; ?>\n";
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
