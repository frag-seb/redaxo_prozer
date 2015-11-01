<?php
        if(rex_post('update', 'int', 0) === 1 ){
            $path = rex_path::addon($addon);

            require $path.'class/pz_baseManager.php';
            $foo = new pz_baseManager('prozer', $path, $I18N);
            $bar = $foo->update();
        }

?>

<div id="rex-output">
    <div class="rex-addon-output">
        <h2 class="rex-hl2">Software-Updates</h2>
        <div class="rex-addon-content">
            <p>Wenn Prozer bereits installiert, können Sie durch ein Update die Datenbank <br>aktualliesieren ohne Daten zu überschreiben..</p>
            <div class="rex-form">
                <form action="index.php?page=prozer&subpage=setup" method="post">
                    <fieldset class="rex-form-col-1">
                        <div class="rex-form-wrapper">
                            <div class="rex-form-row">
                                <p class="rex-form-col-a rex-form-submit">
                                    <input type="hidden" name="update" value="1">
                                    <input class="rex-form-submit" type="submit" name="settings[save]" value="New Prozer Version aktualliesiern"  />
                                </p>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>


