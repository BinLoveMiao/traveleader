<?php
$this->breadcrumbs = array(
    UserModule::t('Users') => array('admin'),
    $model->username,
);


$this->menu = array(
    array('label' => UserModule::t('Create User'), 'icon' => 'plus', 'url' => array('create')),
    array('label' => UserModule::t('Update User'), 'icon' => 'pencil', 'url' => array('update', 'id' => $model->id)),
    array('label' => UserModule::t('Delete User'), 'icon' => 'trash', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => UserModule::t('Are you sure to delete this item?'))),
    array('label' => UserModule::t('Manage Users'), 'icon' => 'cog', 'url' => array('admin')),
    array('label' => UserModule::t('Manage Profile Field'), 'icon' => 'cog', 'url' => array('profileField/admin')),
    array('label' => UserModule::t('List User'), 'icon' => 'list', 'url' => array('/user')),
);
?>
<h3 align="center"><?php echo UserModule::t('View User') . ' "' . $model->username . '"'; ?></h3>

<!--<?php
  $attributes = array(
      'id',
      'username',
  );

  $profileFields = ProfileField::model()->forOwner()->sort()->findAll();
  if ($profileFields) {
      foreach ($profileFields as $field) {
  	array_push($attributes, array(
  	    'label' => UserModule::t($field->title),
  	    'name' => $field->varname,
  	    'type' => 'raw',
  	    'value' => (($field->widgetView($model->profile)) ? $field->widgetView($model->profile) : (($field->range) ? Profile::range($field->range, $model->profile->getAttribute($field->varname)) : $model->profile->getAttribute($field->varname))),
  	));
      }
  }

  array_push($attributes, 'password', 'email', 'activkey', 'create_at', 'lastvisit_at', array(
      'name' => 'superuser',
      'value' => User::itemAlias("AdminStatus", $model->superuser),
  	), array(
      'name' => 'status',
      'value' => User::itemAlias("UserStatus", $model->status),
  	)
  );

  $this->widget('bootstrap.widgets.TbDetailView', array(
      'data' => $model,
      'attributes' => $attributes,
  ));
  ?>
 -->



  <div class="container" id="demo-table">
    <table class="table table-striped table-bordered">
        <tr>
            <th class="col-xs-2">ID</th>
            <td class="col-xs-4">1</td>
        </tr>
        <tr>
            <th class="col-xs-2">用户名：</th>
            <td class="col-xs-4">demo</td>
        </tr>
        <tr>
            <th class="col-xs-2">真实姓名：</th>
            <td class="col-xs-4">小明</td>
        </tr>
        <tr>
            <th class="col-xs-2">昵称：</th>
            <td class="col-xs-4">戒不掉的微笑</td>
        </tr>
        <tr>
            <th class="col-xs-2">手机号码：</th>
            <td class="col-xs-4">18700948308</td>
        </tr>
        <tr>
            <th class="col-xs-2">密码：</th>
            <td class="col-xs-4">xxx@@123</td>
        </tr>
        <tr>
            <th class="col-xs-2">E-mail：</th>
            <td class="col-xs-4">xiaoming@jago-ag.cn</td>
        </tr>
        <tr>
            <th class="col-xs-2">激活码：</th>
            <td class="col-xs-4">9d8bcf670b341743ea695e51990d8474</td>
        </tr>

        <tr>
            <th class="col-xs-2">注册日期：</th>
            <td class="col-xs-4">2013-03-21 20:09:08</td>
        </tr>
        <tr>
            <th class="col-xs-2">上次访问：</th>
            <td class="col-xs-4">2013-03-21 20:09:08</td>
        </tr>
        <tr>
            <th class="col-xs-2">超级会员：</th>
            <td class="col-xs-4">是</td>
        </tr>
        <tr>
            <th class="col-xs-2">状态：</th>
            <td class="col-xs-4">激活</td>
        </tr>
    </table>
 </div>