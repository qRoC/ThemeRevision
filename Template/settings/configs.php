<div class="page-header">
    <h2><?= t('ThemeRevision Settings') ?></h2>
</div>
<?php if ($this->user->isAdmin()): ?>
    <span <?= !$data_in_db ? 'style="display:block;"' : 'style="display:none;"'; ?>>
        <p class="alert alert-warning">
            <b><?= t('Notice') ?></b><br>
            <small><?= t('Editing the theme settings via UI will disable your config file ("config-default.php" or "config.php") in the plugin directory. But you can still re-enable it later.') ?></small><br>
        </p>
        <a id="continue-btn" href="javascript:void(0)" class="btn btn-blue"><?= t('Continue') ?></a>
    </span>

    <span id="tr-settings" <?= !$data_in_db ? 'style="display:none;"' : ''; ?>>
        <form method="post" action="<?= $this->url->href('PluginConfigsController', 'save', array('plugin' => 'ThemeRevision')) ?>">
            <?= $this->form->csrf() ?>
            <fieldset>
                <legend><?= t('Mode') ?></legend>
                <p><small><?= t('Development mode will introduce raw CSS files for easier customization and minify automatically after switching back. Make sure the "Asset" folder in plugin\'s root directory is writable and executable before switching') ?></small></p>
                <?= $this->form->select('mode', 
                    array('production' => t('Production'), 'development' => t('Development')), 
                    array('mode' => $configs['mode'])
                ) ?>

                <legend><?= t('Color Scheme') ?></legend>
                <p><small><?= t('The "user" option will provide an individually controlled panel for users to switch between "Auto", "Light", and "Dark"') ?></small></p>
                <?= $this->form->select('color_scheme', 
                    array('user' => t('User'), 'light' => t('Light'), 'dark' => t('Dark')), 
                    array('color_scheme' => $configs['color_scheme'])
                ) ?>
                
                <legend><?= t('Default Task Color') ?></legend>
                <p><small><?= t('Overwrite the default task color for better UI consistency. The option in project settings will be invalidated') ?></small></p>
                <?= $this->form->checkbox('overwrite_default_task_color', 
                    t('Overwrite with "task-grey"'), 
                    $configs['overwrite_default_task_color'] ? "true" : "false", 
                    $configs['overwrite_default_task_color'],
                    "overwrite-checkbox"
                ) ?>
            </fieldset>

            <fieldset>
                <legend><?= t('Light Palette') ?></legend>
                <p><small><?= t('Check the file "config-default.php" in the plugin directory for more information.') ?></small> <a href="https://github.com/greyaz/ThemeRevision/blob/main/config-default.php" target="_blank"><small><?= t("View on Github") ?></small></a></p>
                <div class="color-palette" style="display:flex;flex-wrap:wrap;">
                    <?php foreach($configs['light_palette'] as $key=>$value):  ?>
                        <?= in_array($key, $end_keys['light']) ? '<hr style="width:100%;margin-bottom:1.5rem;">' : ''; ?>
                        <span class="tr-color-picker" style="width:16rem;"><input type='text' value="<?= $value ?>" name="<?= 'light_palette['.$key.']' ?>" /> <?= $key ?></span>
                    <?php endforeach; ?>
                    <hr style="width:100%;margin-bottom:1rem;">
                </div>
            </fieldset>

            <fieldset>
                <legend><?= t('Dark Palette') ?></legend>
                <p><small><?= t('Check the file "config-default.php" in the plugin directory for more information.') ?></small> <a href="https://github.com/greyaz/ThemeRevision/blob/main/config-default.php" target="_blank"><small><?= t("View on Github") ?></small></a></p>
                <div class="color-palette" style="display:flex;flex-wrap:wrap;">
                    <?php foreach($configs['dark_palette'] as $key=>$value):  ?>
                        <?= in_array($key, $end_keys['dark']) ? '<hr style="width:100%;margin-bottom:1.5rem;">' : ''; ?>
                        <span class="tr-color-picker" style="width:16rem;"><input type='text' value="<?= $value ?>" name="<?= 'dark_palette['.$key.']' ?>" /> <?= $key ?></span>
                    <?php endforeach; ?>
                    <hr style="width:100%;margin-bottom:1rem;">
                </div>
            </fieldset>

            <input type="submit" class="btn btn-blue" value="<?= t('Save') ?>"> 
            
        </form>

        <form method="post" action="<?= $this->url->href('PluginConfigsController', 'reset', array('plugin' => 'ThemeRevision')) ?>">
            <fieldset>
                <legend><?= t('Reset Configs') ?></legend>
                <p><small><?= t('Clear all configs stored in the database and reuse your config file on the server.') ?></small></p>
                <input type="submit" class="btn btn-red" value="<?= t('Reset') ?>"> 
            </fieldset>
        </form>
    </span>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', (event) => {
            $(".tr-color-picker > input[type='text']").spectrum({
                preferredFormat: "rgb",
                showInput: true,
                showAlpha: true
            });

            $(".overwrite-checkbox").change(function(event) {
                $(event.target).val($(event.target).is(':checked')) 
            });

            $("#continue-btn").click((event) => {
                $("#continue-btn").parent().hide();
                $("#tr-settings").show();
            });
        });
    </script>
<?php else: ?>
    <p class="alert alert-error"><?= t('Access Forbidden') ?></p>
<?php endif ?>
