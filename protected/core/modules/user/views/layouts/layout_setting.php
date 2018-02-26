<!-- Layout options -->
<aside class="control-sidebar control-sidebar-dark">
    <div class="tab-content">
        <div id="control-sidebar-theme-demo-options-tab" class="tab-pane active">
            <div>
                <h4 class="control-sidebar-heading"><?= Yii::t('AdminModule.views_layouts_layout_setting', 'Layout Options');?></h4>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        <input type="checkbox" data-layout="fixed" class="pull-right">
                        <?= Yii::t('AdminModule.views_layouts_layout_setting', 'Fixed layout') ?>
                    </label>
                    <p><?= Yii::t('AdminModule.views_layouts_layout_setting', 'Activate the fixed layout. You can\'t use fixed and boxed layouts together')?></p>
                </div>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        <input type="checkbox" data-layout="layout-boxed" class="pull-right">
                        <?= Yii::t('AdminModule.views_layouts_layout_setting', 'Boxed Layout') ?>
                    </label>
                    <p><?= Yii::t('AdminModule.views_layouts_layout_setting', 'Activate the boxed layout') ?></p>
                </div>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        <input type="checkbox" data-layout="sidebar-collapse" class="pull-right">
                        <?= Yii::t('AdminModule.views_layouts_layout_setting', 'Toggle Sidebar') ?>
                    </label>
                    <p><?= Yii::t('AdminModule.views_layouts_layout_setting', 'Toggle the left sidebar\'s state (open or collapse)') ?></p>
                </div>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        <input type="checkbox" data-enable="expandOnHover" class="pull-right">
                        <?= Yii::t('AdminModule.views_layouts_layout_setting', 'Sidebar Expand on Hover') ?>
                    </label>
                    <p><?= Yii::t('AdminModule.views_layouts_layout_setting', 'Let the sidebar mini expand on hover') ?></p>
                </div>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        <input type="checkbox" data-controlsidebar="control-sidebar-open" class="pull-right">
                        <?= Yii::t('AdminModule.views_layouts_layout_setting', 'Toggle Right Sidebar Slide') ?>
                    </label>
                    <p><?= Yii::t('AdminModule.views_layouts_layout_setting', 'Toggle between slide over content and push content effects') ?></p>
                </div>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        <input type="checkbox" data-sidebarskin="toggle" class="pull-right">
                        <?= Yii::t('AdminModule.views_layouts_layout_setting', 'Toggle Right Sidebar Skin') ?>
                    </label>
                    <p><?= Yii::t('AdminModule.views_layouts_layout_setting', 'Toggle between dark and light skins for the right sidebar') ?></p>
                </div>

                <h4 class="control-sidebar-heading"><?= Yii::t('AdminModule.views_layouts_layout_setting', 'Skins') ?></h4>

                <ul class="list-unstyled clearfix">
                    <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0);" data-skin="skin-blue"
                           style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)"
                           class="clearfix full-opacity-hover"
                        >
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9;"></span>
                                <span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span>
                            </div>

                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin"><?= Yii::t('AdminModule.views_layouts_layout_setting', 'Blue') ?></p>
                    </li>

                    <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0);" data-skin="skin-black"
                           style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)"
                           class="clearfix full-opacity-hover"
                        >
                            <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                                <span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe;"></span>
                                <span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe;"></span>
                            </div>

                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #222;"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin"><?= Yii::t('AdminModule.views_layouts_layout_setting', 'Black') ?></p>
                    </li>

                    <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0);" data-skin="skin-purple"
                           style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)"
                           class="clearfix full-opacity-hover"
                        >
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span>
                                <span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span>
                            </div>

                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin"><?= Yii::t('AdminModule.views_layouts_layout_setting', 'Purple') ?></p>
                    </li>

                    <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0);" data-skin="skin-green"
                           style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)"
                           class="clearfix full-opacity-hover"
                        >
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span>
                                <span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span>
                            </div>

                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin"><?= Yii::t('AdminModule.views_layouts_layout_setting', 'Green') ?></p>
                    </li>

                    <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0);" data-skin="skin-red"
                           style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)"
                           class="clearfix full-opacity-hover"
                        >
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span>
                                <span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span>
                            </div>
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin"><?= Yii::t('AdminModule.views_layouts_layout_setting', 'Red') ?></p>
                    </li>

                    <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0);" data-skin="skin-yellow"
                            style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)"
                            class="clearfix full-opacity-hover"
                        >
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span>
                                <span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span>
                            </div>
                            <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin"><?= Yii::t('AdminModule.views_layouts_layout_setting', 'Yellow') ?></p>
                    </li>

                    <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0);" data-skin="skin-blue-light"
                            style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)"
                            class="clearfix full-opacity-hover"
                        >
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9;"></span>
                                <span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span>
                            </div>
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin" style="font-size: 12px"><?= Yii::t('AdminModule.views_layouts_layout_setting', 'Blue Light') ?></p>
                    </li>

                    <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0);" data-skin="skin-black-light"
                            style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)"
                            class="clearfix full-opacity-hover"
                        >
                            <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                                <span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe;"></span>
                                <span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe;"></span>
                            </div>
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin" style="font-size: 12px"><?= Yii::t('AdminModule.views_layouts_layout_setting', 'Black Light') ?></p>
                    </li>

                    <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0);" data-skin="skin-purple-light"
                            style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)"
                            class="clearfix full-opacity-hover"
                        >
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span>
                                <span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span>
                            </div>
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin" style="font-size: 12px"><?= Yii::t('AdminModule.views_layouts_layout_setting', 'Purple Light') ?></p>
                    </li>

                    <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0);" data-skin="skin-green-light"
                            style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)"
                            class="clearfix full-opacity-hover"
                        >
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span>
                                <span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span>
                            </div>
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin" style="font-size: 12px"><?= Yii::t('AdminModule.views_layouts_layout_setting', 'Green Light') ?></p>
                    </li>

                    <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0);" data-skin="skin-red-light"
                            style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)"
                            class="clearfix full-opacity-hover"
                        >
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span>
                                <span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span>
                            </div>
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin" style="font-size: 12px"><?= Yii::t('AdminModule.views_layouts_layout_setting', 'Red Light') ?></p>
                    </li>

                    <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0);" data-skin="skin-yellow-light"
                            style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)"
                            class="clearfix full-opacity-hover"
                        >
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span>
                                <span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span>
                            </div>
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin" style="font-size: 12px;"><?= Yii::t('AdminModule.views_layouts_layout_setting', 'Yellow Light') ?></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <br/>

</aside>
